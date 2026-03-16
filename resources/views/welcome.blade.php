<x-layouts.app>
    <div class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('asset/banner_bg.webp') }}" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>
        </div>

        <div class="container relative z-10 mx-auto px-4 py-12">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-white space-y-6">
                    <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight">
                        Mizigo Inayofika <span class="text-yellow-400">Kwa Wakati</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 max-w-lg leading-relaxed">
                        Tunatuma mizigo yako kutoka Dar es Salaam kwenda Arusha, Moshi, Rombo, Marangu, Himo na Mwanga kwa usalama na uhakika.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-4">
                        <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/20 flex items-center gap-3">
                            <div class="p-2 bg-yellow-400 rounded-lg text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-2.235-2.767A.5.5 0 0 0 19.14 10H14"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Usafiri wa Haraka</p>
                                <p class="text-xs text-gray-400">Mizigo inafika ndani ya saa 24</p>
                            </div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md p-4 rounded-xl border border-white/20 flex items-center gap-3">
                            <div class="p-2 bg-yellow-400 rounded-lg text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Ulinzi wa Uhakika</p>
                                <p class="text-xs text-gray-400">Mzigo wako upo salama nasi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:ml-auto">
                    <livewire:login-form />
                </div>
            </div>
        </div>
    </div>

    <!-- About Section with solid color -->
    <section class="py-24 relative overflow-hidden bg-primary text-white">
        <div class="container relative z-10 mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-16">
                <h2 class="text-3xl font-bold tracking-tight md:text-4xl">Huduma Yetu Ni Zaidi ya Usafiri</h2>
                <p class="text-blue-100 text-lg">
                    Tumekuwa katika tasnia ya usafirishaji kwa zaidi ya miaka 20. Tunajivunia kutoa huduma bora zinazowaunganisha Watanzania kote nchini.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-8 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="p-3 bg-yellow-400 rounded-xl w-fit mb-4 text-black group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Tafuta Basi Lako</h3>
                    <p class="text-blue-100/80">Tuambie unakoenda, unakoondoka, na tarehe ya safari yako ya mizigo.</p>
                </div>
                <div class="p-8 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="p-3 bg-yellow-400 rounded-xl w-fit mb-4 text-black group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Lipa Kwa Usalama</h3>
                    <p class="text-blue-100/80">Tunakubali M-Pesa, Tigo Pesa, Airtel Money, na Benki za Mtandaoni.</p>
                </div>
                <div class="p-8 bg-white/5 backdrop-blur-md rounded-2xl border border-white/10 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="p-3 bg-yellow-400 rounded-xl w-fit mb-4 text-black group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-check"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3">Uthibitisho wa Haraka</h3>
                    <p class="text-blue-100/80">Pokea uthibitisho wa mzigo wako kwa SMS na barua pepe papo hapo.</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
