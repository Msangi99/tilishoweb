<div class="space-y-6" x-data="{ showModal: false }" @open-user-modal.window="showModal = true" @user-saved.window="showModal = false">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 font-inter">User Management</h2>
            <p class="text-sm text-slate-500">Manage and monitor your system users.</p>
        </div>
        <button @click="showModal = true; $wire.cancelEdit()" class="flex items-center gap-2 px-6 py-3 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-slate-900/10">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Add New User
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
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search data..." class="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>
        </div>
        
        <!-- Table Area -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b bg-white">
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Name</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Username</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Email Address</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Phone Number</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400">Role</th>
                        <th class="px-6 py-4 text-[11px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-slate-900 border border-slate-800 flex items-center justify-center text-white font-bold text-xs shadow-md shadow-slate-900/10">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-bold text-slate-900">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-md border border-blue-100">@ {{ $user->username }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium text-slate-600 font-mono">{{ $user->phone ?? '---' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-[10px] font-black uppercase tracking-widest rounded-md {{ $user->role == 'admin' ? 'bg-amber-100 text-amber-700 border border-amber-200' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="editUser({{ $user->id }})" class="p-2 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </button>
                                    <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold">No results found</p>
                                    <p class="text-xs text-slate-400 mt-1">Try adjusting your filters or search keywords.</p>
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
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries
            </div>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Create/Edit User Modal (Popup) -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-[2px]"
         style="display: none;">
        
        <div @click.away="showModal = false; $wire.cancelEdit()" 
             x-show="showModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="scale-95 opacity-0 -translate-y-4"
             x-transition:enter-end="scale-100 opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="scale-100 opacity-100 translate-y-0"
             x-transition:leave-end="scale-95 opacity-0 -translate-y-4"
             class="bg-white w-full max-w-lg rounded-[2rem] shadow-2xl overflow-hidden border border-slate-200">
            
            <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/30">
                <div>
                    <h3 class="text-lg font-black text-slate-900">{{ $editingUserId ? 'Edit System User' : 'Add System User' }}</h3>
                    <p class="text-[10px] text-slate-500 font-medium mt-0.5">Configure account access details below.</p>
                </div>
                <button @click="showModal = false; $wire.cancelEdit()" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-full transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>

            <form wire:submit.prevent="saveUser" class="p-8 space-y-4">
                <!-- Success Alert -->
                @if (session()->has('message'))
                    <div class="p-3 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-xl flex items-center gap-2 text-xs font-bold mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle-2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        {{ session('message') }}
                    </div>
                @endif

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 px-1">Full Name</label>
                    <input wire:model="name" type="text" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900 placeholder:text-slate-300" placeholder="e.g. Michael Angelo">
                    @error('name') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 px-1">Username</label>
                        <input wire:model="username" type="text" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900 placeholder:text-slate-300" placeholder="mike_2024">
                        @error('username') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 px-1">Phone</label>
                        <input wire:model="phone" type="text" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900 placeholder:text-slate-300" placeholder="+255 700...">
                        @error('phone') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 px-1">Email Address</label>
                    <input wire:model="email" type="email" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900 placeholder:text-slate-300" placeholder="mike@company.com">
                    @error('email') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 px-1">User Role</label>
                    <select wire:model="role" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                        <option value="staff">Staff (Regular User)</option>
                        <option value="admin">Administrator (Full Access)</option>
                    </select>
                    @error('role') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 px-1">Password {{ $editingUserId ? '(Leave blank to keep current)' : '' }}</label>
                    <input wire:model="password" type="password" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900 placeholder:text-slate-300" placeholder="••••••••">
                    @error('password') <span class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" @click="showModal = false; $wire.cancelEdit()" class="flex-1 px-4 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-xl text-xs font-bold transition-all border border-slate-200">
                        Discard
                    </button>
                    <button type="submit" class="flex-2 px-8 py-3 bg-slate-900 hover:bg-slate-850 text-white rounded-xl text-xs font-bold transition-all shadow-xl shadow-slate-900/20 flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="saveUser">{{ $editingUserId ? 'Save Changes' : 'Confirm & Create' }}</span>
                        <div wire:loading wire:target="saveUser" class="w-3 h-3 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Custom Pagination Styling -->
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
    </style>
</div>
