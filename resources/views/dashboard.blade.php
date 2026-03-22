<x-layouts.admin>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css" />
        <style>
            #admin-period-parcels-dt_wrapper .dataTables_filter input {
                border-radius: 0.5rem;
                border: 1px solid #e2e8f0;
                padding: 0.35rem 0.65rem;
                margin-left: 0.5rem;
            }
            #admin-period-parcels-dt_wrapper .dataTables_length select {
                border-radius: 0.5rem;
                border: 1px solid #e2e8f0;
                padding: 0.25rem 0.5rem;
            }
            table.dataTable thead th {
                font-size: 0.65rem;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: #94a3b8;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    @endpush
    <div class="flex min-h-screen bg-slate-50" x-data="{ sidebarOpen: false }" x-on:livewire:navigated.window="sidebarOpen = false" @keydown.window.escape="sidebarOpen = false">
        <!-- Sidebar -->
        <aside 
            id="sidebar"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-[#1a2234] text-slate-300 flex-shrink-0 flex flex-col shadow-xl transform transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <!-- Sidebar Header -->
            <div class="p-8 flex flex-col items-center gap-4 relative">
                <button
                    type="button"
                    class="md:hidden absolute right-3 top-3 inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-white hover:bg-white/10"
                    @click="sidebarOpen = false"
                    aria-label="Close sidebar"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
                <div class="w-full h-16 flex items-center justify-center p-2 bg-white/5 rounded-xl border border-white/10 overflow-hidden">
                    <img src="{{ asset('asset/logo.webp') }}" alt="Tilisho Logo" class="max-h-full max-w-full object-contain filter brightness-125">
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'dashboard' || !request()->query('view') ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard {{ request()->query('view') == 'dashboard' || !request()->query('view') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    <span class="text-sm">Summary</span>
                </a>
                
                <a href="{{ route('dashboard', ['view' => 'parcels']) }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'parcels' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package {{ request()->query('view') == 'parcels' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    <span class="text-sm">Manage Parcels</span>
                </a>
                
                @if(Auth::user()->role == 'admin')
                <a href="{{ route('dashboard', ['view' => 'fees']) }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'fees' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-wallet {{ request()->query('view') == 'fees' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                    <span class="text-sm">TRA &amp; developer fees</span>
                </a>

                <a href="{{ route('dashboard', ['view' => 'users']) }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'users' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users {{ request()->query('view') == 'users' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span class="text-sm">User Management</span>
                </a>

                <a href="{{ route('dashboard', ['view' => 'buses']) }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'buses' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bus {{ request()->query('view') == 'buses' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><rect width="16" height="16" x="4" y="3" rx="2"/><path d="M4 11h16"/><path d="M8 15h.01"/><path d="M16 15h.01"/><path d="M6 19v2"/><path d="M18 19v2"/></svg>
                    <span class="text-sm">Manage Buses</span>
                </a>

                <a href="{{ route('dashboard', ['view' => 'routes']) }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'routes' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin {{ request()->query('view') == 'routes' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span class="text-sm">Manage Routes</span>
                </a>

                <a href="{{ route('dashboard', ['view' => 'settings']) }}" 
                   @click="sidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'settings' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings {{ request()->query('view') == 'settings' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    <span class="text-sm">Settings</span>
                </a>
                @endif
            </nav>
        </aside>

        <div
            x-show="sidebarOpen"
            @click="sidebarOpen = false"
            x-transition.opacity
            class="fixed inset-0 z-30 bg-slate-900/50 md:hidden"
            x-cloak
        ></div>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col relative z-10 bg-slate-50 ml-0 md:ml-64">
            <!-- Top Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b flex items-center justify-between px-4 md:px-10 sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg border border-slate-200 text-slate-600 hover:text-slate-900 hover:bg-slate-100"
                        @click="sidebarOpen = !sidebarOpen"
                        aria-label="Toggle sidebar"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div class="flex flex-col">
                    <h1 class="text-xl font-bold text-slate-900">System Dashboard</h1>
                    <p class="text-[11px] text-slate-500 font-medium">Welcome back to the management portal</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 md:gap-6">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-slate-100 rounded-full text-[11px] font-bold text-slate-600 border border-slate-200">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        LIVE STATUS
                    </div>
                    <button class="relative p-2 text-slate-500 hover:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-blue-600 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>
                    
                    <!-- User Dropdown -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-slate-500 uppercase tracking-tighter">{{ Auth::user()->role == 'admin' ? 'Super Admin' : 'Staff Member' }}</p>
                            </div>
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=1a2234&color=fff" alt="Avatar" class="w-10 h-10 rounded-xl border-2 border-white shadow-sm hover:border-blue-200 transition-all">
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 z-50">
                            <div class="p-2">
                                <a href="{{ route('dashboard', ['view' => 'profile']) }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    Profile
                                </a>
                                @if(Auth::user()->role == 'admin')
                                <a href="{{ route('dashboard', ['view' => 'settings']) }}" class="flex items-center gap-2 px-3 py-2 text-sm text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Settings
                                </a>
                                @endif
                                <hr class="my-1 border-slate-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 px-3 py-2 w-full text-left text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors font-medium">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="flex-1 overflow-y-scroll p-4 sm:p-6 md:p-10">
                @if(request()->query('view') == 'users')
                    <livewire:user-management />
                @elseif(request()->query('view') == 'parcels')
                    <livewire:parcel-management />
                @elseif(request()->query('view') == 'buses')
                    <livewire:bus-management />
                @elseif(request()->query('view') == 'routes')
                    <livewire:route-management />
                @elseif(request()->query('view') == 'settings' && Auth::user()->role == 'admin')
                    <livewire:system-settings />
                @elseif(request()->query('view') == 'fees' && Auth::user()->role == 'admin')
                    <livewire:fee-transactions />
                @elseif(request()->query('view') == 'profile')
                    <livewire:user-profile />
                @elseif(request()->query('view') == 'scan')
                    <livewire:parcel-scanner />
                @else
                    @if(Auth::user()->role == 'admin')
                    <!-- Admin Dashboard (powered by API stats) -->
                    <div 
                        x-data="dashboardStats()" 
                        x-init="loadStats()"
                        class="space-y-10"
                    >
                        <!-- Period filter -->
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Dashboard period</p>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="opt in periodOptions" :key="opt.key">
                                    <button
                                        type="button"
                                        @click="setPeriod(opt.key)"
                                        class="px-4 py-2 rounded-xl text-xs font-bold transition-all border"
                                        :class="period === opt.key ? 'bg-slate-900 text-white border-slate-900 shadow-md' : 'bg-slate-50 text-slate-600 border-slate-200 hover:border-slate-300'"
                                        x-text="opt.label"
                                    ></button>
                                </template>
                            </div>
                            <div class="flex flex-wrap gap-4" x-show="period === 'month'" x-cloak>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Month</label>
                                    <select x-model.number="calendarMonth" @change="loadStats()" class="rounded-xl border-slate-200 text-sm font-semibold text-slate-800 min-w-[160px]">
                                        <template x-for="m in monthOptions" :key="m">
                                            <option :value="m" x-text="monthName(m)"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Year</label>
                                    <select x-model.number="calendarYear" @change="loadStats()" class="rounded-xl border-slate-200 text-sm font-semibold text-slate-800 min-w-[120px]">
                                        <template x-for="y in yearChoices" :key="y">
                                            <option :value="y" x-text="y"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-4" x-show="period === 'year'" x-cloak>
                                <div class="space-y-1">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase">Year</label>
                                    <select x-model.number="calendarYear" @change="loadStats()" class="rounded-xl border-slate-200 text-sm font-semibold text-slate-800 min-w-[120px]">
                                        <template x-for="y in yearChoices" :key="y">
                                            <option :value="y" x-text="y"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500" x-show="stats?.filter?.label">
                                Showing <span class="font-bold text-slate-800" x-text="stats?.filter?.label"></span>
                            </p>
                        </div>

                        <!-- Summary cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <!-- Total parcels -->
                            <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">All time</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-500 mb-1">Total Parcels</h3>
                                <p class="text-3xl font-black text-slate-900" x-text="stats?.totals?.parcels ?? '—'">—</p>
                            </div>

                            <!-- All-time revenue -->
                            <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">All time</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-500 mb-1">Total Revenue</h3>
                                <p class="text-2xl font-black text-slate-900" x-text="formatCurrency(stats?.totals?.revenue)">TZS 0</p>
                            </div>

                            <!-- Selected period -->
                            <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all ring-1 ring-blue-100">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-range"><path d="M4 10h16"/><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-lg max-w-[10rem] truncate" x-text="periodBadge"></span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-500 mb-1">Parcels in period</h3>
                                <p class="text-3xl font-black text-slate-900" x-text="stats?.filter?.count ?? '—'">—</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Revenue:
                                    <span class="font-semibold" x-text="formatCurrency(stats?.filter?.amount)">TZS 0</span>
                                </p>
                            </div>
                        </div>

                        <!-- Charts + Staff + Recent activity -->
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
                            <!-- Chart -->
                            <div class="xl:col-span-2 bg-white rounded-3xl border shadow-sm p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-sm font-bold text-slate-900" x-text="chartTitle">Parcels</h2>
                                </div>
                                <template x-if="stats && chartLabels.length">
                                    <div class="h-56 flex items-end gap-1 sm:gap-2 overflow-x-auto pb-1">
                                        <template x-for="(label, idx) in chartLabels" :key="idx">
                                            <div class="flex-1 min-w-[1.25rem] flex flex-col items-center justify-end group">
                                                <div class="w-full bg-blue-100 rounded-t-xl overflow-hidden relative">
                                                    <div 
                                                        class="w-full bg-blue-500 rounded-t-xl transition-all duration-500"
                                                        :style="`height: ${barHeight(chartCounts[idx])}%;`"
                                                    ></div>
                                                </div>
                                                <span class="mt-2 text-[10px] font-bold text-slate-500 group-hover:text-slate-900 truncate max-w-full" x-text="label"></span>
                                                <span class="text-[10px] text-slate-400" x-text="chartCounts[idx]"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="!stats || !chartLabels.length">
                                    <div class="h-56 flex items-center justify-center text-slate-400 text-sm">
                                        Loading chart...
                                    </div>
                                </template>
                            </div>

                            <!-- Staff summary -->
                            <div class="bg-white rounded-3xl border shadow-sm p-6 space-y-4">
                                <h2 class="text-sm font-bold text-slate-900 mb-2">Staff Overview</h2>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-slate-500">Total Staff</p>
                                        <p class="text-xl font-black text-slate-900" x-text="stats?.staff?.total_staff ?? '—'">—</p>
                                    </div>
                                    <div class="p-3 rounded-2xl bg-slate-50 text-slate-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                                    <div>
                                        <p class="text-xs text-slate-500">Admins</p>
                                        <p class="text-base font-bold text-slate-900" x-text="stats?.staff?.total_admins ?? '—'">—</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Staff</p>
                                        <p class="text-base font-bold text-slate-900" x-text="(stats?.staff?.total_staff ?? 0) - (stats?.staff?.total_admins ?? 0)"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Parcels in period: jQuery DataTables -->
                        <div class="bg-white rounded-3xl border shadow-sm overflow-hidden" x-show="stats?.filter" x-cloak>
                            <div class="p-6 border-b border-slate-100 space-y-1">
                                <h2 class="text-sm font-bold text-slate-900">Parcels in selected period</h2>
                                <p class="text-xs text-slate-500">
                                    Fee splits from settings:
                                    TRA <span class="font-bold text-slate-700" x-text="stats?.filter?.tra_percent ?? '—'"></span>%
                                    · Developer <span class="font-bold text-slate-700" x-text="stats?.filter?.developer_percent ?? '—'"></span>%.
                                    <span class="text-slate-400">Remain = Amount − TRA − Dev.</span>
                                </p>
                            </div>
                            <div class="p-4 overflow-x-auto">
                                <table id="admin-period-parcels-dt" class="display stripe hover cell-border w-full text-sm" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Tracking</th>
                                            <th>Route</th>
                                            <th class="text-right">Amount</th>
                                            <th class="text-right">TRA</th>
                                            <th class="text-right">Dev</th>
                                            <th class="text-right">Remain</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <template x-if="loading">
                            <div class="fixed inset-0 z-20 flex items-center justify-center bg-white/60 backdrop-blur-sm">
                                <div class="flex items-center gap-3 px-4 py-3 bg-white rounded-2xl border shadow-sm">
                                    <div class="w-4 h-4 border-2 border-slate-300 border-t-blue-600 rounded-full animate-spin"></div>
                                    <span class="text-xs font-medium text-slate-600">Loading dashboard...</span>
                                </div>
                            </div>
                        </template>

                    </div>
                    <script>
                        function dashboardStats() {
                            const now = new Date();
                            return {
                                stats: null,
                                loading: false,
                                period: 'month',
                                calendarYear: now.getFullYear(),
                                calendarMonth: now.getMonth() + 1,
                                periodOptions: [
                                    { key: 'day', label: 'Today' },
                                    { key: 'week', label: 'This week' },
                                    { key: 'month', label: 'Month' },
                                    { key: 'year', label: 'Year' },
                                ],
                                monthOptions: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                                get yearChoices() {
                                    const y = new Date().getFullYear();
                                    return Array.from({ length: 11 }, (_, i) => y - i);
                                },
                                get periodBadge() {
                                    const labels = { day: 'Today', week: 'This week', month: 'Month', year: 'Year' };
                                    return labels[this.period] || this.period;
                                },
                                get chartLabels() {
                                    if (!this.stats) return [];
                                    const fc = this.stats.filtered_chart;
                                    const c = this.stats.chart;
                                    return (fc && fc.labels) ? fc.labels : (c && c.labels) ? c.labels : [];
                                },
                                get chartCounts() {
                                    if (!this.stats) return [];
                                    const fc = this.stats.filtered_chart;
                                    const c = this.stats.chart;
                                    return (fc && fc.counts) ? fc.counts : (c && c.counts) ? c.counts : [];
                                },
                                get chartTitle() {
                                    if (this.stats && this.stats.filter) {
                                        return 'Parcels · ' + this.stats.filter.label;
                                    }
                                    return 'Parcels (last 7 days)';
                                },
                                monthName(m) {
                                    return new Date(2000, m - 1, 1).toLocaleString('en', { month: 'long' });
                                },
                                setPeriod(key) {
                                    this.period = key;
                                    this.loadStats();
                                },
                                async loadStats() {
                                    this.loading = true;
                                    try {
                                        const params = new URLSearchParams({
                                            period: this.period,
                                            year: String(this.calendarYear),
                                            month: String(this.calendarMonth),
                                        });
                                        const response = await fetch('{{ route('dashboard.stats') }}?' + params.toString(), {
                                            headers: { 'Accept': 'application/json' },
                                            credentials: 'same-origin',
                                        });
                                        const data = await response.json();
                                        if (data.status === 'success') {
                                            this.stats = data.data;
                                        }
                                    } catch (e) {
                                        console.error('Failed to load dashboard stats', e);
                                    } finally {
                                        this.loading = false;
                                        // Defer until Alpine has toggled x-show (DataTables needs visible layout)
                                        setTimeout(() => this.syncPeriodParcelsDataTable(), 100);
                                    }
                                },
                                syncPeriodParcelsDataTable() {
                                    const $ = window.jQuery;
                                    if (!$ || !$.fn.DataTable) {
                                        return;
                                    }
                                    const el = document.getElementById('admin-period-parcels-dt');
                                    if (!el) {
                                        return;
                                    }
                                    if (!this.stats || !this.stats.filter) {
                                        return;
                                    }
                                    let rows = this.stats.filtered_period_parcels || [];
                                    if (!Array.isArray(rows)) {
                                        rows = [];
                                    }
                                    if ($.fn.DataTable.isDataTable(el)) {
                                        $(el).DataTable().destroy();
                                        $(el).find('tbody').empty();
                                    }
                                    const fmt = (n) => {
                                        const num = Number(n) || 0;
                                        return 'TZS ' + num.toLocaleString('en-TZ', { maximumFractionDigits: 0 });
                                    };
                                    const esc = (s) => {
                                        if (s === null || s === undefined) {
                                            return '';
                                        }
                                        return String(s)
                                            .replace(/&/g, '&amp;')
                                            .replace(/</g, '&lt;')
                                            .replace(/>/g, '&gt;')
                                            .replace(/"/g, '&quot;');
                                    };
                                    const badgeClass = (status) => this.statusClass(status);
                                    const api = $(el).DataTable({
                                        data: rows,
                                        columns: [
                                            { data: 'tracking_number', className: 'font-mono text-xs', render: (d) => esc(d) },
                                            {
                                                data: null,
                                                render: (row) => esc(row.origin || '') + ' → ' + esc(row.destination || ''),
                                            },
                                            {
                                                data: 'amount',
                                                className: 'text-right font-semibold text-emerald-800',
                                                render: (d) => fmt(d),
                                            },
                                            {
                                                data: 'tra_amount',
                                                className: 'text-right text-amber-900',
                                                render: (d) => fmt(d),
                                            },
                                            {
                                                data: 'developer_amount',
                                                className: 'text-right text-violet-900',
                                                render: (d) => fmt(d),
                                            },
                                            {
                                                data: 'remain_amount',
                                                className: 'text-right font-bold text-slate-900',
                                                render: (d) => fmt(d),
                                            },
                                            {
                                                data: 'status',
                                                render: (d) => {
                                                    const c = badgeClass(d);
                                                    return '<span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest ' + c + '">' + esc(d) + '</span>';
                                                },
                                            },
                                            { data: 'created_at', render: (d) => esc(d) },
                                        ],
                                        order: [[7, 'desc']],
                                        pageLength: 25,
                                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
                                        scrollX: true,
                                        language: {
                                            emptyTable: 'No parcels in this period.',
                                            zeroRecords: 'No matching parcels.',
                                        },
                                    });
                                    try {
                                        api.columns.adjust().draw(false);
                                    } catch (e) { /* ignore */ }
                                },
                                formatCurrency(value) {
                                    if (value === null || value === undefined) return 'TZS 0';
                                    const num = Number(value) || 0;
                                    return 'TZS ' + num.toLocaleString('en-TZ', { maximumFractionDigits: 0 });
                                },
                                barHeight(count) {
                                    const counts = this.chartCounts;
                                    const max = counts.length ? Math.max(...counts) : 0;
                                    if (!max) return 5;
                                    return 10 + (count / max) * 80;
                                },
                                statusClass(status) {
                                    const value = (status || '').toLowerCase();
                                    switch (value) {
                                        case 'pending':
                                            return 'bg-amber-50 text-amber-700 border border-amber-100';
                                        case 'in-transit':
                                        case 'packed':
                                            return 'bg-blue-50 text-blue-700 border border-blue-100';
                                        case 'arrived':
                                        case 'delivered':
                                        case 'received':
                                            return 'bg-emerald-50 text-emerald-700 border border-emerald-100';
                                        default:
                                            return 'bg-slate-50 text-slate-600 border border-slate-100';
                                    }
                                },
                            };
                        }
                    </script>
                    @else
                        <livewire:user-dashboard />
                    @endif
                @endif
            </div>
        </main>
    </div>
</x-layouts.admin>
