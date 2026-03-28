<div class="space-y-6">
    @if(!empty($officesTableMissing))
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            <p class="font-bold">Offices table not found</p>
            <p class="mt-1 text-amber-800/90">On the server, run <code class="rounded bg-amber-100 px-1.5 py-0.5 font-mono text-xs">php artisan migrate</code> so the <code class="font-mono text-xs">offices</code> table is created. Until then, the parcel app will load without office-based stops.</p>
        </div>
    @endif
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 font-inter">Offices &amp; intermediate stations</h2>
            <p class="text-sm text-slate-500">Manage office locations and stops used for parcel registration and routes in the mobile app.</p>
        </div>
        @if($showList)
        <button wire:click="showCreateForm" type="button" class="flex items-center gap-2 px-6 py-3 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-slate-900/10">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building-2"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>
            Add office
        </button>
        @else
        <button wire:click="showOfficeList" type="button" class="flex items-center gap-2 px-6 py-3 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-slate-900/10">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
            List offices
        </button>
        @endif
    </div>

    @if(!$showList)
    <div class="w-full mx-auto flex justify-center">
        <div class="w-full max-w-xl">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">{{ $editingOfficeId ? 'Edit office' : 'Add office' }}</h3>
                        <p class="text-[11px] text-slate-500 font-medium">One entry per office or intermediate station name.</p>
                    </div>
                    @if (session()->has('message'))
                        <span class="text-[11px] font-semibold text-emerald-600">{{ session('message') }}</span>
                    @endif
                </div>

                <form wire:submit.prevent="saveOffice" class="p-6 space-y-4 bg-slate-50">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700 px-0.5">Name</label>
                        <input type="text" wire:model="name" class="w-full px-4 py-2.5 rounded-md border border-input bg-background text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" placeholder="e.g. Chalinze, Korogwe">
                        @error('name') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" wire:click="cancelEdit" class="flex-1 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-md text-xs font-bold transition-all border border-slate-200">
                            Discard
                        </button>
                        <button type="submit" class="flex-[2] px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-md text-xs font-bold transition-all shadow-xl shadow-slate-900/20 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="saveOffice">{{ $editingOfficeId ? 'Update' : 'Save' }}</span>
                            <div wire:loading wire:target="saveOffice" class="w-3 h-3 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if($showList)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/30">
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500 font-medium whitespace-nowrap">Show</span>
                <select wire:model.live="perPage" class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2 outline-none transition-all">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="text-sm text-slate-500 font-medium whitespace-nowrap">entries</span>
            </div>
            <div class="flex-1 flex justify-end">
                <div class="relative w-full md:w-48 lg:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search offices…" class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-white">
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Name</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($offices as $office)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-900">{{ $office->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button type="button" wire:click="editOffice({{ $office->id }})" class="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button type="button" wire:click="deleteOffice({{ $office->id }})" wire:confirm="Delete this office?" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-20 text-center text-slate-500 font-medium">
                                No offices yet. Add intermediate stations and office locations here.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="text-sm text-slate-500 font-medium">
                Showing {{ $offices->firstItem() ?? 0 }} to {{ $offices->lastItem() ?? 0 }} of {{ $offices->total() }} entries
            </div>
            <div>
                {{ $offices->links() }}
            </div>
        </div>
    </div>
    @endif

    <style>
        .pagination { display: flex; gap: 0.25rem; }
        .page-link {
            padding: 0.5rem 0.875rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 700;
            background: white;
            border: 1px solid #e2e8f0;
            color: #64748b;
            transition: all 0.2s;
        }
        .page-item.active .page-link {
            background: #0f172a;
            border-color: #0f172a;
            color: white;
        }
    </style>
</div>
