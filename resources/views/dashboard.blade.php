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
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
                        <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-2.235-2.767A.5.5 0 0 0 19.14 10H14"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                                </div>
                                <span class="text-[11px] font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">+12%</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-500 mb-1">Today's Parcels</h3>
                            <p class="text-3xl font-black text-slate-900">14</p>
                        </div>

                        <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-purple-50 text-purple-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                </div>
                                <span class="text-[11px] font-bold text-green-500 bg-green-50 px-2 py-1 rounded-lg">+8%</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-500 mb-1">New Customers</h3>
                            <p class="text-3xl font-black text-slate-900">52</p>
                        </div>

                        <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-banknote"><rect width="20" height="12" x="2" y="6" rx="2"/><circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/></svg>
                                </div>
                                <span class="text-[11px] font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-lg">This Week</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-500 mb-1">Revenue (TZS)</h3>
                            <p class="text-3xl font-black text-slate-900">1.8M</p>
                        </div>

                        <div class="group bg-white p-7 rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-3 bg-orange-50 text-orange-600 rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-timer"><path d="M10 2h4"/><path d="M12 14v-4"/><path d="M4 13a8 8 0 0 1 8-7 8 8 0 1 1-5.3 14L4 17.6"/><path d="M9 17H4v5"/></svg>
                                </div>
                                <span class="text-[11px] font-bold text-orange-500 bg-orange-50 px-2 py-1 rounded-lg">Tasks</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-500 mb-1">In Transit</h3>
                            <p class="text-3xl font-black text-slate-900">03</p>
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                        <!-- Recent Activity -->
                        <div class="xl:col-span-2 bg-white rounded-3xl border shadow-sm overflow-hidden flex flex-col">
                            <div class="p-8 border-b flex items-center justify-between">
                                <h2 class="text-lg font-bold text-slate-900">Recent Shipments</h2>
                                <button class="text-xs font-bold text-blue-600 hover:text-blue-700">View All</button>
                            </div>
                            <div class="p-12 text-center flex-1 flex flex-col items-center justify-center space-y-4">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="M3.29 7 12 12l8.71-5"/><path d="M12 22V12"/></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-800">No shipments found yet</h4>
                                    <p class="text-xs text-slate-500 mt-1">New shipments will appear here automatically when registered.</p>
                                </div>
                                <button class="px-6 py-3 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition-all">Register New Parcel</button>
                            </div>
                        </div>

                        <!-- Important Information -->
                        <div class="bg-white rounded-3xl border shadow-sm p-8">
                            <h2 class="text-lg font-bold text-slate-900 mb-6">Important Notices</h2>
                            <div class="space-y-6">
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-orange-100 flex-shrink-0 flex items-center justify-center text-orange-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 line-clamp-1">Tarakea route closed</p>
                                        <p class="text-[10px] text-slate-500 mt-0.5">Heavy rain causing 4-hour delay.</p>
                                        <span class="text-[9px] text-slate-400 mt-2 block font-medium">5 minutes ago</span>
                                    </div>
                                </div>
                                
                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-100 flex-shrink-0 flex items-center justify-center text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 line-clamp-1">Monthly report ready</p>
                                        <p class="text-[10px] text-slate-500 mt-0.5">Available for download and review.</p>
                                        <span class="text-[9px] text-slate-400 mt-2 block font-medium">2 hours ago</span>
                                    </div>
                                </div>

                                <div class="flex gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-green-100 flex-shrink-0 flex items-center justify-center text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 line-clamp-1">10 new users registered</p>
                                        <p class="text-[10px] text-slate-500 mt-0.5">From Arusha and Moshi regions.</p>
                                        <span class="text-[9px] text-slate-400 mt-2 block font-medium">4 hours ago</span>
                                    </div>
                                </div>
                            </div>

                            <button class="w-full mt-8 py-3 bg-slate-50 hover:bg-slate-100 text-slate-500 rounded-xl text-xs font-bold border border-dashed border-slate-200 transition-all">View All Activity Logs</button>
                        </div>
                    </div>
                    @else
                        <livewire:user-dashboard />
                    @endif
                @endif
            </div>
        </main>
    </div>
</x-layouts.admin>
