<?php

namespace App\Livewire;

use App\Models\FeeWithdrawal;
use App\Models\Parcel;
use App\Models\SystemSetting;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FeeTransactions extends Component
{
    public string $period = 'month';

    public ?int $calendarYear = null;

    public ?int $calendarMonth = null;

    public bool $showModal = false;

    public ?string $modalType = null;

    public string $withdrawAmount = '';

    public string $withdrawNote = '';

    public function mount(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403);

        $now = Carbon::now();
        $this->calendarYear = (int) $now->year;
        $this->calendarMonth = (int) $now->month;
    }

    public function updatedPeriod(): void
    {
        $this->closeModal();
    }

    public function updatedCalendarYear(): void
    {
        $this->closeModal();
    }

    public function updatedCalendarMonth(): void
    {
        $this->closeModal();
    }

    public function openModal(string $type): void
    {
        if (! in_array($type, [FeeWithdrawal::TYPE_TRA, FeeWithdrawal::TYPE_DEVELOPER], true)) {
            return;
        }
        $this->modalType = $type;
        $this->withdrawAmount = '';
        $this->withdrawNote = '';
        $this->resetValidation();
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->modalType = null;
        $this->withdrawAmount = '';
        $this->withdrawNote = '';
        $this->resetValidation();
    }

    public function recordWithdrawal(): void
    {
        if (! $this->modalType) {
            return;
        }

        $this->validate([
            'withdrawAmount' => 'required|numeric|min:0.01',
            'withdrawNote' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () {
            Wallet::debitForWithdrawal($this->modalType, (float) $this->withdrawAmount);

            FeeWithdrawal::create([
                'type' => $this->modalType,
                'amount' => $this->withdrawAmount,
                'note' => $this->withdrawNote !== '' ? $this->withdrawNote : null,
                'recorded_by' => auth()->id(),
            ]);
        });

        session()->flash('fee_message', 'Withdrawal recorded successfully.');
        $this->closeModal();
    }

    /**
     * @return array{start: Carbon, end: Carbon, label: string}
     */
    protected function dateRange(): array
    {
        $now = Carbon::now();

        return match ($this->period) {
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
                'start' => $now->copy()->year($this->calendarYear ?? $now->year)->month($this->calendarMonth ?? $now->month)->startOfMonth(),
                'end' => $now->copy()->year($this->calendarYear ?? $now->year)->month($this->calendarMonth ?? $now->month)->endOfMonth(),
                'label' => $now->copy()->year($this->calendarYear ?? $now->year)->month($this->calendarMonth ?? $now->month)->format('F Y'),
            ],
            'year' => [
                'start' => Carbon::create($this->calendarYear ?? $now->year, 1, 1)->startOfDay(),
                'end' => Carbon::create($this->calendarYear ?? $now->year, 12, 31)->endOfDay(),
                'label' => (string) ($this->calendarYear ?? $now->year),
            ],
            default => [
                'start' => $now->copy()->startOfMonth(),
                'end' => $now->copy()->endOfMonth(),
                'label' => $now->format('F Y'),
            ],
        };
    }

    protected function traPercent(): float
    {
        return (float) SystemSetting::getValue('fee_tra_percent', '18');
    }

    protected function developerPercent(): float
    {
        return (float) SystemSetting::getValue('fee_developer_percent', '3');
    }

    public function render()
    {
        $wallet = Wallet::instance();

        $range = $this->dateRange();
        $start = $range['start'];
        $end = $range['end'];

        $parcelSum = (float) Parcel::query()
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $traPct = $this->traPercent();
        $devPct = $this->developerPercent();

        $traAccrued = round($parcelSum * ($traPct / 100), 2);
        $developerAccrued = round($parcelSum * ($devPct / 100), 2);

        $traWithdrawn = FeeWithdrawal::query()
            ->where('type', FeeWithdrawal::TYPE_TRA)
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $developerWithdrawn = FeeWithdrawal::query()
            ->where('type', FeeWithdrawal::TYPE_DEVELOPER)
            ->whereBetween('created_at', [$start, $end])
            ->sum('amount');

        $modalWithdrawals = collect();
        if ($this->showModal && $this->modalType) {
            $modalWithdrawals = FeeWithdrawal::query()
                ->with('recordedBy')
                ->where('type', $this->modalType)
                ->whereBetween('created_at', [$start, $end])
                ->orderByDesc('created_at')
                ->get();
        }

        $y0 = (int) Carbon::now()->year;
        $years = collect(range(0, 10))->map(fn (int $i) => $y0 - $i)->all();

        $allWithdrawals = FeeWithdrawal::query()
            ->with('recordedBy')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.fee-transactions', [
            'wallet' => $wallet,
            'rangeLabel' => $range['label'],
            'parcelSum' => $parcelSum,
            'traPct' => $traPct,
            'devPct' => $devPct,
            'traAccrued' => $traAccrued,
            'developerAccrued' => $developerAccrued,
            'traWithdrawn' => (float) $traWithdrawn,
            'developerWithdrawn' => (float) $developerWithdrawn,
            'modalWithdrawals' => $modalWithdrawals,
            'yearChoices' => $years,
            'allWithdrawals' => $allWithdrawals,
        ]);
    }
}
