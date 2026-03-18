<x-layouts.admin>
    <div class="flex min-h-screen bg-slate-50">
        <!-- Sidebar -->
        <aside 
            id="sidebar"
            class="fixed inset-y-0 left-0 z-30 w-64 bg-[#1a2234] text-slate-300 flex-shrink-0 flex flex-col shadow-xl"
        >
            <!-- Sidebar Header -->
            <div class="p-8 flex flex-col items-center gap-4">
                <div class="w-full h-16 flex items-center justify-center p-2 bg-white/5 rounded-xl border border-white/10 overflow-hidden">
                    <img src="{{ asset('asset/logo.webp') }}" alt="Tilisho Logo" class="max-h-full max-w-full object-contain filter brightness-125">
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'dashboard' || !request()->query('view') ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard {{ request()->query('view') == 'dashboard' || !request()->query('view') ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    <span class="text-sm">Summary</span>
                </a>
                
                <a href="{{ route('dashboard', ['view' => 'parcels']) }}" 
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'parcels' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package {{ request()->query('view') == 'parcels' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    <span class="text-sm">Manage Parcels</span>
                </a>
                
                @if(Auth::user()->role == 'admin')
                <a href="{{ route('dashboard', ['view' => 'users']) }}" 
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'users' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users {{ request()->query('view') == 'users' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <span class="text-sm">User Management</span>
                </a>

                <a href="{{ route('dashboard', ['view' => 'buses']) }}" 
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'buses' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bus {{ request()->query('view') == 'buses' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><rect width="16" height="16" x="4" y="3" rx="2"/><path d="M4 11h16"/><path d="M8 15h.01"/><path d="M16 15h.01"/><path d="M6 19v2"/><path d="M18 19v2"/></svg>
                    <span class="text-sm">Manage Buses</span>
                </a>

                <a href="{{ route('dashboard', ['view' => 'routes']) }}" 
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'routes' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin {{ request()->query('view') == 'routes' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span class="text-sm">Manage Routes</span>
                </a>

                <a href="{{ route('dashboard', ['view' => 'settings']) }}" 
                   class="flex items-center gap-3 px-4 py-3 {{ request()->query('view') == 'settings' ? 'bg-blue-600 text-white rounded-xl shadow-lg shadow-blue-900/20' : 'hover:bg-white/5 hover:text-white rounded-xl transition-all group' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings {{ request()->query('view') == 'settings' ? 'text-white' : 'text-slate-500 group-hover:text-blue-400' }}"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.1a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    <span class="text-sm">Settings</span>
                </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col relative z-10 bg-slate-50 ml-64">
            <!-- Top Header -->
            <header class="h-20 bg-white/80 backdrop-blur-md border-b flex items-center justify-between px-4 md:px-10 sticky top-0 z-10">
                <div class="flex items-center gap-3">
                    <!-- Mobile menu button -->
                    <!-- (Optional) mobile menu button removed to avoid JS issues -->
                    <div class="flex flex-col">
                    <h1 class="text-xl font-bold text-slate-900">System Dashboard</h1>
                    <p class="text-[11px] text-slate-500 font-medium">Welcome back to the management portal</p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 rounded-full text-[11px] font-bold text-slate-600 border border-slate-200">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        LIVE STATUS
                    </div>
                    <button class="relative p-2 text-slate-500 hover:text-blue-600 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bell"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-blue-600 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="h-8 w-px bg-slate-200"></div>
                    
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
            <div class="flex-1 overflow-y-scroll p-10">
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
                        <!-- Summary cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            <!-- Total parcels -->
                            <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">Total</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-500 mb-1">Total Parcels</h3>
                                <p class="text-3xl font-black text-slate-900" x-text="stats?.totals?.parcels ?? '—'">—</p>
                            </div>

                            <!-- Today -->
                            <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">Today</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-500 mb-1">Today's Parcels</h3>
                                <p class="text-3xl font-black text-slate-900" x-text="stats?.today?.count ?? '—'">—</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Revenue: 
                                    <span class="font-semibold" x-text="formatCurrency(stats?.today?.amount)">TZS 0</span>
                                </p>
                            </div>

                            <!-- This week -->
                            <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                                    </div>
                                    <span class="text-[11px] font-bold text-indigo-500 bg-indigo-50 px-2 py-1 rounded-lg">This Week</span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-500 mb-1">Week Parcels</h3>
                                <p class="text-3xl font-black text-slate-900" x-text="stats?.week?.count ?? '—'">—</p>
                                <p class="text-xs text-slate-500 mt-1">
                                    Revenue: 
                                    <span class="font-semibold" x-text="formatCurrency(stats?.week?.amount)">TZS 0</span>
                                </p>
                            </div>

                            <!-- This month / year toggle -->
                            <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up"><path d="M3 17 9 11 13 15 21 7"/><path d="M14 7h7v7"/></svg>
                                    </div>
                                    <div class="flex gap-1 rounded-full bg-slate-100 p-1 text-[10px] font-bold">
                                        <button 
                                            type="button" 
                                            @click="range = 'month'"
                                            :class="range === 'month' ? 'bg-white text-slate-900 shadow-sm px-2 py-0.5 rounded-full' : 'px-2 py-0.5 text-slate-500'"
                                        >
                                            Month
                                        </button>
                                        <button 
                                            type="button" 
                                            @click="range = 'year'"
                                            :class="range === 'year' ? 'bg-white text-slate-900 shadow-sm px-2 py-0.5 rounded-full' : 'px-2 py-0.5 text-slate-500'"
                                        >
                                            Year
                                        </button>
                                    </div>
                                </div>
                                <template x-if="range === 'month'">
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-500 mb-1">This Month Parcels</h3>
                                        <p class="text-3xl font-black text-slate-900" x-text="stats?.month?.count ?? '—'">—</p>
                                        <p class="text-xs text-slate-500 mt-1">
                                            Revenue: 
                                            <span class="font-semibold" x-text="formatCurrency(stats?.month?.amount)">TZS 0</span>
                                        </p>
                                    </div>
                                </template>
                                <template x-if="range === 'year'">
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-500 mb-1">This Year Parcels</h3>
                                        <p class="text-3xl font-black text-slate-900" x-text="stats?.year?.count ?? '—'">—</p>
                                        <p class="text-xs text-slate-500 mt-1">
                                            Revenue: 
                                            <span class="font-semibold" x-text="formatCurrency(stats?.year?.amount)">TZS 0</span>
                                        </p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Charts + Staff + Recent activity -->
                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
                            <!-- Chart -->
                            <div class="xl:col-span-2 bg-white rounded-3xl border shadow-sm p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-sm font-bold text-slate-900">Parcels (last 7 days)</h2>
                                </div>
                                <template x-if="stats">
                                    <div class="h-56 flex items-end gap-2">
                                        <template x-for="(label, idx) in stats.chart.labels" :key="idx">
                                            <div class="flex-1 flex flex-col items-center justify-end group">
                                                <div class="w-full bg-blue-100 rounded-t-xl overflow-hidden relative">
                                                    <div 
                                                        class="w-full bg-blue-500 rounded-t-xl transition-all duration-500"
                                                        :style="`height: ${barHeight(stats.chart.counts[idx])}%;`"
                                                    ></div>
                                                </div>
                                                <span class="mt-2 text-[10px] font-bold text-slate-500 group-hover:text-slate-900" x-text="label"></span>
                                                <span class="text-[10px] text-slate-400" x-text="stats.chart.counts[idx]"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                                <template x-if="!stats">
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

                        <!-- Recent activity table -->
                        <div class="bg-white rounded-3xl border shadow-sm overflow-hidden">
                            <div class="p-6 border-b flex items-center justify-between">
                                <h2 class="text-sm font-bold text-slate-900">Recent Parcels Activity</h2>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-left text-sm">
                                    <thead class="bg-slate-50 border-b">
                                        <tr>
                                            <th class="px-4 py-2 text-[11px] font-black uppercase tracking-widest text-slate-400">Tracking</th>
                                            <th class="px-4 py-2 text-[11px] font-black uppercase tracking-widest text-slate-400">From / To</th>
                                            <th class="px-4 py-2 text-[11px] font-black uppercase tracking-widest text-slate-400">Amount</th>
                                            <th class="px-4 py-2 text-[11px] font-black uppercase tracking-widest text-slate-400">Status</th>
                                            <th class="px-4 py-2 text-[11px] font-black uppercase tracking-widest text-slate-400">Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template x-if="stats && stats.recent_parcels.length">
                                            <template x-for="item in stats.recent_parcels" :key="item.id">
                                                <tr class="border-b last:border-0 hover:bg-slate-50/60">
                                                    <td class="px-4 py-2 font-mono text-xs text-slate-800" x-text="item.tracking_number"></td>
                                                    <td class="px-4 py-2 text-xs text-slate-700">
                                                        <div class="font-semibold" x-text="item.sender_name + ' → ' + item.receiver_name"></div>
                                                        <div class="text-[11px] text-slate-500" x-text="item.origin + ' → ' + item.destination"></div>
                                                    </td>
                                                    <td class="px-4 py-2 text-xs font-semibold text-emerald-700" x-text="formatCurrency(item.amount)"></td>
                                                    <td class="px-4 py-2">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest"
                                                            :class="statusClass(item.status)">
                                                            <span x-text="item.status"></span>
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2 text-[11px] text-slate-500" x-text="item.created_at"></td>
                                                </tr>
                                            </template>
                                        </template>
                                        <template x-if="!stats || !stats.recent_parcels.length">
                                            <tr>
                                                <td colspan="5" class="px-4 py-10 text-center text-xs text-slate-400">
                                                    No recent parcels yet.
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
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
                            return {
                                stats: null,
                                loading: false,
                                range: 'month',
                                async loadStats() {
                                    this.loading = true;
                                    try {
                                        const response = await fetch('{{ route('dashboard.stats') }}', {
                                            headers: {
                                                'Accept': 'application/json',
                                            },
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
                                    }
                                },
                                formatCurrency(value) {
                                    if (value === null || value === undefined) return 'TZS 0';
                                    const num = Number(value) || 0;
                                    return 'TZS ' + num.toLocaleString('en-TZ', { maximumFractionDigits: 0 });
                                },
                                barHeight(count) {
                                    const max = this.stats && this.stats.chart && this.stats.chart.counts.length
                                        ? Math.max(...this.stats.chart.counts)
                                        : 0;
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
