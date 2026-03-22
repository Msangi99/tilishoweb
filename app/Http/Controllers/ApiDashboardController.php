<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Models\SystemSetting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiDashboardController extends Controller
{
    /**
     * Return dashboard statistics for the mobile app and admin web dashboard.
     *
     * Optional query (web): period=day|week|month|year, year=YYYY, month=1-12
     * When present, adds filter, filtered_chart, and filtered_period_parcels (with TRA / dev / remain).
     */
    public function stats(Request $request)
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // Totals
        $totalParcels = Parcel::count();
        $totalRevenue = Parcel::sum('amount');

        // Today
        $todayCount = Parcel::whereDate('created_at', $today)->count();
        $todayAmount = Parcel::whereDate('created_at', $today)->sum('amount');

        // This week
        $weekCount = Parcel::where('created_at', '>=', $startOfWeek)->count();
        $weekAmount = Parcel::where('created_at', '>=', $startOfWeek)->sum('amount');

        // This month
        $monthCount = Parcel::where('created_at', '>=', $startOfMonth)->count();
        $monthAmount = Parcel::where('created_at', '>=', $startOfMonth)->sum('amount');

        // This year
        $yearCount = Parcel::where('created_at', '>=', $startOfYear)->count();
        $yearAmount = Parcel::where('created_at', '>=', $startOfYear)->sum('amount');

        // Chart Data (Last 7 days)
        $labels = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D');
            $counts[] = Parcel::whereDate('created_at', $date)->count();
        }

        // Staff stats
        $totalStaff = User::where('role', 'staff')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // Recent activity (last 10 parcels)
        $recentParcels = Parcel::with(['createdBy', 'transportedBy', 'receivedBy'])
            ->orderByDesc('created_at')
            ->limit(10)
            ->get()
            ->map(fn (Parcel $p) => $this->parcelToSummary($p));

        $data = [
            'totals' => [
                'parcels' => $totalParcels,
                'revenue' => $totalRevenue,
            ],
            'today' => [
                'count' => $todayCount,
                'amount' => $todayAmount,
            ],
            'week' => [
                'count' => $weekCount,
                'amount' => $weekAmount,
            ],
            'month' => [
                'count' => $monthCount,
                'amount' => $monthAmount,
            ],
            'year' => [
                'count' => $yearCount,
                'amount' => $yearAmount,
            ],
            'chart' => [
                'labels' => $labels,
                'counts' => $counts,
            ],
            'staff' => [
                'total_staff' => $totalStaff,
                'total_admins' => $totalAdmins,
            ],
            'recent_parcels' => $recentParcels,
        ];

        $filterRange = $this->resolveFilterRange($request);
        if ($filterRange !== null) {
            /** @var Carbon $fStart */
            /** @var Carbon $fEnd */
            ['start' => $fStart, 'end' => $fEnd, 'label' => $fLabel] = $filterRange;
            $period = $request->query('period');

            $filterCount = Parcel::whereBetween('created_at', [$fStart, $fEnd])->count();
            $filterAmount = Parcel::whereBetween('created_at', [$fStart, $fEnd])->sum('amount');

            $traPct = (float) SystemSetting::getValue('fee_tra_percent', '18');
            $devPct = (float) SystemSetting::getValue('fee_developer_percent', '3');

            $data['filter'] = [
                'period' => $period,
                'label' => $fLabel,
                'count' => $filterCount,
                'amount' => $filterAmount,
                'tra_percent' => $traPct,
                'developer_percent' => $devPct,
            ];
            $data['filtered_chart'] = $this->buildFilteredChart($fStart, $fEnd, (string) $period);
            $data['filtered_period_parcels'] = Parcel::with(['createdBy', 'transportedBy', 'receivedBy'])
                ->whereBetween('created_at', [$fStart, $fEnd])
                ->orderByDesc('created_at')
                ->get()
                ->map(fn (Parcel $p) => $this->parcelToPeriodRow($p, $traPct, $devPct))
                ->values()
                ->all();
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ]);
    }

    /**
     * @return array{start: Carbon, end: Carbon, label: string}|null
     */
    protected function resolveFilterRange(Request $request): ?array
    {
        $period = $request->query('period');
        if (! in_array($period, ['day', 'week', 'month', 'year'], true)) {
            return null;
        }

        $now = Carbon::now();
        $year = (int) $request->query('year', $now->year);
        $month = (int) $request->query('month', $now->month);
        $year = max(2000, min($year, (int) $now->year + 1));
        $month = max(1, min(12, $month));

        return match ($period) {
            'day' => [
                'start' => $now->copy()->startOfDay(),
                'end' => $now->copy()->endOfDay(),
                'label' => $now->format('M j, Y'),
            ],
            'week' => [
                'start' => $now->copy()->startOfWeek(),
                'end' => $now->copy()->endOfWeek(),
                'label' => $now->copy()->startOfWeek()->format('M j').' – '.$now->copy()->endOfWeek()->format('M j, Y'),
            ],
            'month' => [
                'start' => $now->copy()->year($year)->month($month)->startOfMonth(),
                'end' => $now->copy()->year($year)->month($month)->endOfMonth(),
                'label' => $now->copy()->year($year)->month($month)->format('F Y'),
            ],
            'year' => [
                'start' => Carbon::create($year, 1, 1)->startOfDay(),
                'end' => Carbon::create($year, 12, 31)->endOfDay(),
                'label' => (string) $year,
            ],
            default => null,
        };
    }

    /**
     * @return array{labels: array<int, string>, counts: array<int, int>}
     */
    protected function buildFilteredChart(Carbon $start, Carbon $end, string $period): array
    {
        $labels = [];
        $counts = [];

        if ($period === 'day') {
            for ($h = 0; $h < 24; $h += 4) {
                $labels[] = sprintf('%02d:00', $h);
                $segStart = $start->copy()->addHours($h);
                $segEnd = $start->copy()->addHours($h + 4)->subSecond();
                $counts[] = Parcel::whereBetween('created_at', [$segStart, $segEnd])->count();
            }
        } elseif ($period === 'week') {
            for ($i = 0; $i < 7; $i++) {
                $d = $start->copy()->addDays($i);
                $labels[] = $d->format('D');
                $counts[] = Parcel::whereDate('created_at', $d->toDateString())->count();
            }
        } elseif ($period === 'month') {
            $cursor = $start->copy()->startOfDay();
            while ($cursor->lte($end)) {
                $labels[] = $cursor->format('j');
                $counts[] = Parcel::whereDate('created_at', $cursor->toDateString())->count();
                $cursor->addDay();
            }
        } else {
            $y = (int) $start->year;
            for ($m = 1; $m <= 12; $m++) {
                $labels[] = Carbon::create($y, $m, 1)->format('M');
                $ms = Carbon::create($y, $m, 1)->startOfMonth();
                $me = Carbon::create($y, $m, 1)->endOfMonth();
                $counts[] = Parcel::whereBetween('created_at', [$ms, $me])->count();
            }
        }

        return [
            'labels' => $labels,
            'counts' => $counts,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function parcelToSummary(Parcel $p): array
    {
        return [
            'id' => $p->id,
            'tracking_number' => $p->tracking_number,
            'sender_name' => $p->sender_name,
            'receiver_name' => $p->receiver_name,
            'origin' => $p->origin,
            'destination' => $p->destination,
            'amount' => $p->amount,
            'status' => $p->display_status,
            'created_at' => $p->created_at?->toDateTimeString(),
            'created_by' => $p->createdBy?->name,
            'transported_by' => $p->transportedBy?->name,
            'received_by' => $p->receivedBy?->name,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function parcelToPeriodRow(Parcel $p, float $traPercent, float $developerPercent): array
    {
        $amt = (float) $p->amount;
        $tra = round($amt * ($traPercent / 100), 2);
        $dev = round($amt * ($developerPercent / 100), 2);
        $remain = round($amt - $tra - $dev, 2);

        return [
            'id' => $p->id,
            'tracking_number' => $p->tracking_number,
            'sender_name' => $p->sender_name,
            'receiver_name' => $p->receiver_name,
            'origin' => $p->origin,
            'destination' => $p->destination,
            'amount' => $amt,
            'tra_amount' => $tra,
            'developer_amount' => $dev,
            'remain_amount' => $remain,
            'status' => $p->display_status,
            'created_at' => $p->created_at?->toDateTimeString(),
            'created_by' => $p->createdBy?->name,
        ];
    }
}
