<div class="space-y-6" x-data="{ showModal: false }" @open-bus-modal.window="showModal = true" @bus-saved.window="showModal = false">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 font-inter">Manage Fleet</h2>
            <p class="text-sm text-slate-500">Configure buses, routes, and assigned crew members.</p>
        </div>
        <button @click="showModal = true; $wire.cancelEdit()" class="flex items-center gap-2 px-6 py-3 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-slate-900/10">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bus"><rect width="16" height="16" x="4" y="3" rx="2"/><path d="M4 11h16"/><path d="M8 15h.01"/><path d="M16 15h.01"/><path d="M6 19v2"/><path d="M18 19v2"/></svg>
            Add New Bus
        </button>
    </div>

    <!-- DataTable Inspired Container -->
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
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search fleet..." class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>
        
        <!-- Table Area -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-white">
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Plate & Model</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Assigned Route</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Staff Count</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Status</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($buses as $bus)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-slate-900/10 uppercase">
                                        {{ substr($bus->plate_number, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $bus->plate_number }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($bus->route)
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-900">{{ $bus->route->from }} → {{ $bus->route->to }}</span>
                                        <span class="text-[9px] text-slate-400 font-medium truncate max-w-[150px]">{{ $bus->route->stations }}</span>
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-400 italic font-medium">Not Assigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex -space-x-2">
                                        @php 
                                            $staff_count = count($bus->drivers ?? []) + count($bus->conductors ?? []) + count($bus->attendants ?? []); 
                                        @endphp
                                        <div class="w-6 h-6 rounded-full bg-blue-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-blue-600">D</div>
                                        <div class="w-6 h-6 rounded-full bg-emerald-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-emerald-600">C</div>
                                        <div class="w-6 h-6 rounded-full bg-amber-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-amber-600">A</div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">{{ $staff_count }} total</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $bus->status === 'active' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : ($bus->status === 'maintenance' ? 'bg-amber-50 text-amber-600 border border-amber-100' : 'bg-slate-50 text-slate-600 border border-slate-100') }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $bus->status === 'active' ? 'bg-emerald-500' : ($bus->status === 'maintenance' ? 'bg-amber-500' : 'bg-slate-500') }}"></span>
                                    {{ ucfirst($bus->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="editBus({{ $bus->id }})" class="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button wire:click="deleteBus({{ $bus->id }})" wire:confirm="Remove this bus from fleet?" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic">No fleet records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $buses->links() }}
        </div>
    </div>

    <!-- Create/Edit Modal -->
    <div x-show="showModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         style="display: none;"
         x-transition>
        
        <div class="bg-white w-full max-w-2xl rounded-[2rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/30 shrink-0">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight">{{ $editingBusId ? 'Revise Fleet Asset' : 'Register New Asset' }}</h3>
                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Asset & Crew Configuration</p>
                </div>
                <button @click="showModal = false; $wire.cancelEdit()" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="p-8 overflow-y-auto custom-scrollbar">
                @if (session()->has('message'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-xs font-bold flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        {{ session('message') }}
                    </div>
                @endif

                <form wire:submit.prevent="saveBus" class="space-y-8">
                    <!-- Core Asset Info -->
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Bus Number (Plate)</label>
                            <input wire:model="plate_number" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900" placeholder="e.g. T 123 ABC">
                            @error('plate_number') <span class="text-[10px] text-red-500 font-bold px-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Assigned Route</label>
                            <select wire:model="route_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                                <option value="">--- Not Assigned ---</option>
                                @foreach($routes as $rt)
                                    <option value="{{ $rt->id }}">{{ $rt->from }} → {{ $rt->to }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <!-- Dynamic Staff Sections -->
                    <div class="space-y-6">
                        <!-- Drivers -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between px-1">
                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Dereva (Drivers)</h4>
                                <button type="button" wire:click="addDriver" class="text-[10px] font-black text-blue-600 hover:text-blue-700 transition-all">+ Add Driver</button>
                            </div>
                            
                            <div class="space-y-3">
                                @foreach($drivers as $index => $driver)
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl relative group">
                                        <button type="button" wire:click="removeDriver({{ $index }})" class="absolute top-2 right-2 p-1.5 text-slate-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="space-y-1">
                                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Full Name</label>
                                                <input wire:model="drivers.{{ $index }}.name" type="text" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all" placeholder="Enter name">
                                            </div>
                                            <div class="space-y-1">
                                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Phone Number</label>
                                                <input wire:model="drivers.{{ $index }}.phone" type="text" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all" placeholder="Enter phone">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Conductors -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between px-1">
                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Kondakta (Conductors)</h4>
                                <button type="button" wire:click="addConductor" class="text-[10px] font-black text-emerald-600 hover:text-emerald-700 transition-all">+ Add Conductor</button>
                            </div>
                            
                            <div class="space-y-3">
                                @foreach($conductors as $index => $conductor)
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl relative group">
                                        <button type="button" wire:click="removeConductor({{ $index }})" class="absolute top-2 right-2 p-1.5 text-slate-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="space-y-1">
                                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Full Name</label>
                                                <input wire:model="conductors.{{ $index }}.name" type="text" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all" placeholder="Enter name">
                                            </div>
                                            <div class="space-y-1">
                                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Phone Number</label>
                                                <input wire:model="conductors.{{ $index }}.phone" type="text" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all" placeholder="Enter phone">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Attendants -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between px-1">
                                <h4 class="text-xs font-black text-slate-900 uppercase tracking-widest">Mhudumu (Attendants)</h4>
                                <button type="button" wire:click="addAttendant" class="text-[10px] font-black text-amber-600 hover:text-amber-700 transition-all">+ Add Attendant</button>
                            </div>
                            
                            <div class="space-y-3">
                                @foreach($attendants as $index => $attendant)
                                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl relative group">
                                        <button type="button" wire:click="removeAttendant({{ $index }})" class="absolute top-2 right-2 p-1.5 text-slate-400 hover:text-red-500 transition-colors opacity-0 group-hover:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="space-y-1">
                                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Full Name</label>
                                                <input wire:model="attendants.{{ $index }}.name" type="text" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all" placeholder="Enter name">
                                            </div>
                                            <div class="space-y-1">
                                                <label class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Phone Number</label>
                                                <input wire:model="attendants.{{ $index }}.phone" type="text" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-slate-900 focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all" placeholder="Enter phone">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-6 flex gap-4 shrink-0">
                        <button type="button" @click="showModal = false; $wire.cancelEdit()" class="flex-1 px-6 py-4 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-2xl text-xs font-black uppercase tracking-widest transition-all border border-slate-200">
                            Discard
                        </button>
                        <button type="submit" class="flex-[2] px-6 py-4 bg-slate-900 hover:bg-slate-850 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-xl shadow-slate-900/20">
                            {{ $editingBusId ? 'Commit Changes' : 'Finalize Registration' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</div>
