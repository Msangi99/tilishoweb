<div class="space-y-8" data-fee-withdrawals-root>
    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">TRA &amp; developer fees</h2>
            <p class="text-sm text-slate-500">
                Shares are calculated from each parcel <span class="font-semibold text-slate-700">amount</span> using the percentages in Settings.
            </p>
        </div>
        @if (session()->has('fee_message'))
            <div class="px-4 py-2 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-xl text-xs font-bold">
                {{ session('fee_message') }}
            </div>
        @endif
    </div>

    <!-- Period filter -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Period</p>
        <div class="flex flex-wrap gap-2">
            @foreach (['day' => 'Today', 'week' => 'This week', 'month' => 'Month', 'year' => 'Year'] as $key => $label)
                <button
                    type="button"
                    wire:click="$set('period', '{{ $key }}')"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all border
                        {{ $period === $key ? 'bg-slate-900 text-white border-slate-900 shadow-md' : 'bg-slate-50 text-slate-600 border-slate-200 hover:border-slate-300' }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        @if ($period === 'month')
            <div class="flex flex-wrap gap-4 pt-2">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Month</label>
                    <select wire:model.live="calendarMonth" class="rounded-xl border-slate-200 text-sm font-semibold text-slate-800 min-w-[160px]">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create(2000, $m, 1)->format('F') }}</option>
                        @endfor
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Year</label>
                    <select wire:model.live="calendarYear" class="rounded-xl border-slate-200 text-sm font-semibold text-slate-800 min-w-[120px]">
                        @foreach ($yearChoices as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        @if ($period === 'year')
            <div class="flex flex-wrap gap-4 pt-2">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-500 uppercase">Year</label>
                    <select wire:model.live="calendarYear" class="rounded-xl border-slate-200 text-sm font-semibold text-slate-800 min-w-[120px]">
                        @foreach ($yearChoices as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <p class="text-xs text-slate-500 pt-2">
            Showing <span class="font-bold text-slate-800">{{ $rangeLabel }}</span>
            · Gross parcel revenue: <span class="font-bold text-emerald-700">TZS {{ number_format($parcelSum, 0) }}</span>
        </p>
    </div>

    <!-- Wallet balances (from wallets table) + TRA / developer actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="text-left bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-slate-100 text-slate-700 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-building-2"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
                </div>
                <span class="text-[10px] font-black text-slate-600 bg-slate-100 px-2 py-1 rounded-lg">System</span>
            </div>
            <h3 class="text-sm font-bold text-slate-500 mb-1">System wallet</h3>
            <p class="text-3xl font-black text-slate-900">TZS {{ number_format((float) $wallet->system, 0) }}</p>
            <p class="text-xs text-slate-500 mt-2">Sum of all parcel amounts (full gross). TRA &amp; developer wallets track their % shares separately.</p>
        </div>

        <button
            type="button"
            wire:click="openModal('tra')"
            class="text-left group bg-white rounded-2xl border border-slate-200 shadow-sm p-8 hover:shadow-xl hover:border-amber-200 hover:-translate-y-0.5 transition-all"
        >
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-amber-50 text-amber-700 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-landmark"><path d="M10 18v-7"/><path d="M14 18v-7"/><path d="M18 18v-7"/><path d="M6 18v-7"/><path d="M3 22h18"/><path d="M6 18H4a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-2"/><path d="M6 11V9a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2"/></svg>
                </div>
                <span class="text-[10px] font-black text-amber-600 bg-amber-50 px-2 py-1 rounded-lg">{{ $traPct }}% · TRA</span>
            </div>
            <h3 class="text-sm font-bold text-slate-500 mb-1">TRA wallet balance</h3>
            <p class="text-3xl font-black text-slate-900">TZS {{ number_format((float) $wallet->tra, 0) }}</p>
            <p class="text-xs text-slate-500 mt-2">Accrued this period: <span class="font-semibold text-slate-700">TZS {{ number_format($traAccrued, 0) }}</span> · Withdrawn: <span class="font-semibold text-slate-700">TZS {{ number_format($traWithdrawn, 0) }}</span></p>
            <p class="text-[11px] text-amber-700 font-bold mt-4 opacity-0 group-hover:opacity-100 transition-opacity">Click to record withdrawal →</p>
        </button>

        <button
            type="button"
            wire:click="openModal('developer')"
            class="text-left group bg-white rounded-2xl border border-slate-200 shadow-sm p-8 hover:shadow-xl hover:border-violet-200 hover:-translate-y-0.5 transition-all"
        >
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-violet-50 text-violet-700 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-code-2"><path d="m18 16 4-4-4-4"/><path d="m6 8-4 4 4 4"/><path d="m14.5 4-5 16"/></svg>
                </div>
                <span class="text-[10px] font-black text-violet-600 bg-violet-50 px-2 py-1 rounded-lg">{{ $devPct }}% · Developer</span>
            </div>
            <h3 class="text-sm font-bold text-slate-500 mb-1">Developer wallet balance</h3>
            <p class="text-3xl font-black text-slate-900">TZS {{ number_format((float) $wallet->developer, 0) }}</p>
            <p class="text-xs text-slate-500 mt-2">Accrued this period: <span class="font-semibold text-slate-700">TZS {{ number_format($developerAccrued, 0) }}</span> · Withdrawn: <span class="font-semibold text-slate-700">TZS {{ number_format($developerWithdrawn, 0) }}</span></p>
            <p class="text-[11px] text-violet-700 font-bold mt-4 opacity-0 group-hover:opacity-100 transition-opacity">Click to record withdrawal →</p>
        </button>
    </div>

    <!-- Modal -->
    @if ($showModal && $modalType)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4" x-data x-on:keydown.escape.window="$wire.closeModal()">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" wire:click="closeModal"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-lg w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">
                            {{ $modalType === 'tra' ? 'TRA withdrawals' : 'Developer withdrawals' }}
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">{{ $rangeLabel }}</p>
                    </div>
                    <button type="button" wire:click="closeModal" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 space-y-4 border-b border-slate-100 bg-slate-50/80">
                    <p class="text-xs text-slate-600">
                        Wallet balance (available):
                        <span class="font-black text-slate-900">
                            TZS {{ number_format($modalType === 'tra' ? (float) $wallet->tra : (float) $wallet->developer, 0) }}
                        </span>
                    </p>
                    <p class="text-xs text-slate-600">
                        Accrual this period:
                        <span class="font-black text-slate-900">
                            TZS {{ number_format($modalType === 'tra' ? $traAccrued : $developerAccrued, 0) }}
                        </span>
                    </p>
                    <form wire:submit.prevent="recordWithdrawal" class="space-y-3">
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase">Amount (TZS)</label>
                            <input
                                type="number"
                                step="0.01"
                                min="0.01"
                                wire:model="withdrawAmount"
                                class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 outline-none"
                                placeholder="0.00"
                            />
                            @error('withdrawAmount') <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase">Note (optional)</label>
                            <textarea
                                wire:model="withdrawNote"
                                rows="2"
                                class="mt-1 w-full px-4 py-3 rounded-xl border border-slate-200 text-sm text-slate-800 focus:ring-2 focus:ring-slate-900/10 focus:border-slate-900 outline-none resize-none"
                                placeholder="Reference, bank slip, etc."
                            ></textarea>
                            @error('withdrawNote') <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p> @enderror
                        </div>
                        <button
                            type="submit"
                            class="w-full py-3 rounded-xl bg-slate-900 text-white text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition-colors"
                        >
                            Record withdrawal
                        </button>
                    </form>
                </div>

                <div class="p-6">
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Withdrawals this period</p>
                    @if ($modalWithdrawals->isEmpty())
                        <p class="text-sm text-slate-400 py-6 text-center">No withdrawals recorded for this period.</p>
                    @else
                        <ul class="space-y-2">
                            @foreach ($modalWithdrawals as $w)
                                <li class="flex justify-between gap-4 px-4 py-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div>
                                        <p class="text-sm font-black text-slate-900">TZS {{ number_format($w->amount, 0) }}</p>
                                        @if ($w->note)
                                            <p class="text-xs text-slate-500 mt-0.5">{{ $w->note }}</p>
                                        @endif
                                        <p class="text-[10px] text-slate-400 mt-1">
                                            {{ $w->created_at->format('M j, Y H:i') }}
                                            @if ($w->recordedBy)
                                                · {{ $w->recordedBy->name }}
                                            @endif
                                        </p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Withdrawal ledger (jQuery DataTables) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="text-lg font-black text-slate-900">Withdrawal transactions</h3>
            <p class="text-xs text-slate-500 mt-1">All recorded TRA and developer withdrawals (sortable &amp; searchable).</p>
        </div>
        <div class="p-4 sm:p-6 overflow-x-auto">
            <table id="jquerytabledata" class="display nowrap w-full text-left text-sm" style="width:100%">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="px-3 py-2 font-bold text-slate-600">Date</th>
                        <th class="px-3 py-2 font-bold text-slate-600">Type</th>
                        <th class="px-3 py-2 font-bold text-slate-600">Amount (TZS)</th>
                        <th class="px-3 py-2 font-bold text-slate-600">Note</th>
                        <th class="px-3 py-2 font-bold text-slate-600">Recorded by</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allWithdrawals as $w)
                        <tr>
                            <td class="px-3 py-2 text-slate-700 whitespace-nowrap">{{ $w->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-3 py-2">
                                <span class="text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-md {{ $w->type === 'tra' ? 'bg-amber-100 text-amber-800' : 'bg-violet-100 text-violet-800' }}">
                                    {{ $w->type === 'tra' ? 'TRA' : 'Developer' }}
                                </span>
                            </td>
                            <td class="px-3 py-2 font-bold text-slate-900">{{ number_format((float) $w->amount, 2) }}</td>
                            <td class="px-3 py-2 text-slate-600 max-w-xs truncate" title="{{ $w->note }}">{{ $w->note ?? '—' }}</td>
                            <td class="px-3 py-2 text-slate-600">{{ $w->recordedBy?->name ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" />
    @endpush

    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
        <script>
            (function () {
                function tilishoInitWithdrawalsDataTable() {
                    var $t = window.jQuery('#jquerytabledata');
                    if (!$t.length) return;
                    if (window.jQuery.fn.dataTable.isDataTable($t)) {
                        $t.DataTable().destroy();
                    }
                    $t.DataTable({
                        order: [[0, 'desc']],
                        pageLength: 10,
                        responsive: true,
                    });
                }

                document.addEventListener('DOMContentLoaded', tilishoInitWithdrawalsDataTable);
                document.addEventListener('livewire:navigated', tilishoInitWithdrawalsDataTable);
                document.addEventListener('livewire:init', function () {
                    Livewire.hook('morph.updated', function (_ref) {
                        var el = _ref.el;
                        if (!el || !el.querySelector) return;
                        if (el.querySelector('#jquerytabledata') || el.id === 'jquerytabledata') {
                            tilishoInitWithdrawalsDataTable();
                        }
                    });
                });
            })();
        </script>
    @endpush
@endonce
