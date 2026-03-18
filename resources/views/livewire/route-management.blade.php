<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 font-inter">Manage Routes</h2>
            <p class="text-sm text-slate-500">Define and manage bus routes and their stations.</p>
        </div>
        @if($showList)
        <button wire:click="showCreateForm" class="flex items-center gap-2 px-6 py-3 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-slate-900/10">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
            Add New Route
        </button>
        @else
        <button wire:click="showRouteList" class="flex items-center gap-2 px-6 py-3 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-slate-900/10">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list"><line x1="8" x2="21" y1="6" y2="6"/><line x1="8" x2="21" y1="12" y2="12"/><line x1="8" x2="21" y1="18" y2="18"/><line x1="3" x2="3.01" y1="6" y2="6"/><line x1="3" x2="3.01" y1="12" y2="12"/><line x1="3" x2="3.01" y1="18" y2="18"/></svg>
            List Routes
        </button>
        @endif
    </div>

    @if(!$showList)
    <!-- Create/Edit Form (shown first by default) -->
    <div class="w-full mx-auto flex justify-center">
        <div class="w-[80%] max-w-4xl">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900">{{ $editingRouteId ? 'Edit Bus Route' : 'Add New Route' }}</h3>
                        <p class="text-[11px] text-slate-500 font-medium">Configure origin, destination and stop points.</p>
                    </div>
                    @if (session()->has('message'))
                        <span class="text-[11px] font-semibold text-emerald-600">{{ session('message') }}</span>
                    @endif
                </div>

                <form wire:submit.prevent="saveRoute" class="p-6 space-y-4 bg-slate-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5" wire:ignore>
                            <label class="text-xs font-semibold text-slate-700 px-0.5">Origin (From)</label>
                            <select id="select-from" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="">Select Origin...</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}" {{ $from == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
                            @error('from') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1.5" wire:ignore>
                            <label class="text-xs font-semibold text-slate-700 px-0.5">Destination (To)</label>
                            <select id="select-to" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                <option value="">Select Destination...</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}" {{ $to == $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
                            @error('to') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-700 px-0.5">Intermediate Stations</label>
                        <textarea wire:model="stations" rows="3" class="w-full px-4 py-2.5 rounded-md border border-input bg-background text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="e.g. Chalinze, Segera, Korogwe... (separate with commas)"></textarea>
                        <p class="text-[9px] text-slate-400 px-0.5 mt-1 font-medium italic">Separate each station name using a comma (,)</p>
                        @error('stations') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" wire:click="cancelEdit" class="flex-1 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-md text-xs font-bold transition-all border border-slate-200">
                            Discard
                        </button>
                        <button type="submit" class="flex-2 px-8 py-3 bg-slate-900 hover:bg-slate-850 text-white rounded-md text-xs font-bold transition-all shadow-xl shadow-slate-900/20 flex items-center justify-center gap-2">
                            <span wire:loading.remove wire:target="saveRoute">{{ $editingRouteId ? 'Update Route' : 'Establish Route' }}</span>
                            <div wire:loading wire:target="saveRoute" class="w-3 h-3 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if($showList)
    <!-- List of Routes -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- DataTable Header Controls -->
        <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/30">
            <div class="flex items-center gap-3">
                <span class="text-sm text-slate-500 font-medium whitespace-nowrap">Show</span>
                <select wire:model.live="perPage" class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-20 p-2 outline-none transition-all">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-slate-500 font-medium whitespace-nowrap">entries</span>
            </div>

            <div class="flex-1 flex justify-end">
                <div class="relative w-full md:w-48 lg:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search routes..." class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>
        
        <!-- Table Area -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-white">
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Origin (From)</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Destination (To)</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Stations</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($routes as $route)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-blue-600 border border-blue-700 flex items-center justify-center text-white font-bold text-[10px] shadow-md shadow-blue-900/10 uppercase">
                                        {{ substr($route->from, 0, 2) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-900">{{ $route->from }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-bold text-slate-900">{{ $route->to }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @php $route_stations = array_filter(explode(',', $route->stations)); @endphp
                                    @foreach(array_slice($route_stations, 0, 3) as $st)
                                        <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 px-2 py-0.5 rounded border border-slate-200">{{ trim($st) }}</span>
                                    @endforeach
                                    @if(count($route_stations) > 3)
                                        <span class="text-[10px] font-black text-blue-600 px-1">+{{ count($route_stations) - 3 }} more</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="editRoute({{ $route->id }})" class="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button wire:click="deleteRoute({{ $route->id }})" wire:confirm="Are you sure you want to delete this route?" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold">No routes found</p>
                                    <p class="text-xs text-slate-400 mt-1">Initialize your transport network by adding routes.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- DataTable Footer Controls -->
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="text-sm text-slate-500 font-medium">
                Showing {{ $routes->firstItem() ?? 0 }} to {{ $routes->lastItem() ?? 0 }} of {{ $routes->total() }} entries
            </div>
            <div>
                {{ $routes->links() }}
            </div>
        </div>
    </div>
    @endif

    <!-- Custom Pagination & Scrollbar Styling -->
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
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        .page-link:hover:not(.active) {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</div>
