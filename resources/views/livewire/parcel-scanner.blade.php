<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white rounded-[3rem] border border-slate-200 shadow-xl overflow-hidden">
        <div class="bg-slate-900 p-10 text-white flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-black tracking-tight">Parcel Scanner</h2>
                <p class="text-white/60 font-bold uppercase tracking-widest text-xs mt-1">Scan QR or Enter Tracking ID</p>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-xl border border-white/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="5" height="5" x="3" y="3" rx="1"/><rect width="5" height="5" x="16" y="3" rx="1"/><rect width="5" height="5" x="3" y="16" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16h.01"/><path d="M16 12h1"/><path d="M21 12v.01"/><path d="M12 21v-1"/></svg>
            </div>
        </div>

        <div class="p-10 space-y-8">
            <!-- Scan Input -->
            <div class="relative">
                <input wire:model.live="tracking_number" 
                       wire:keydown.enter="processScan"
                       type="text" 
                       placeholder="TLS000XXX" 
                       class="w-full px-10 py-8 bg-slate-50 border-2 border-slate-200 rounded-[2rem] text-4xl font-black text-slate-900 focus:ring-8 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-200 text-center tracking-widest">
                <div class="absolute inset-y-0 right-8 flex items-center">
                    <button wire:click="processScan" class="p-4 bg-slate-900 text-white rounded-2xl hover:scale-105 transition-all shadow-xl shadow-slate-900/20 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>
                    </button>
                </div>
            </div>

            <!-- Messages -->
            @if($error)
                <div class="p-6 bg-red-50 border border-red-100 rounded-[2rem] flex items-center gap-4 text-red-600 animate-shake">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <p class="font-bold text-sm">{{ $error }}</p>
                </div>
            @endif

            @if($success)
                <div class="p-6 bg-emerald-50 border border-emerald-100 rounded-[2rem] flex items-center gap-4 text-emerald-600 animate-bounce-subtle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <p class="font-bold text-sm">{{ $success }}</p>
                </div>
            @endif

            <!-- Scan Details (Step 2) -->
            @if($parcel && !$success)
                <div class="bg-slate-50 rounded-[2.5rem] border border-slate-200 p-8 space-y-8 animate-slide-up">
                    <div class="flex items-center gap-6">
                        @if($parcel)
                        <div class="w-20 h-20 rounded-[1.5rem] bg-white border border-slate-200 p-1 flex items-center justify-center">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $parcel->tracking_number }}" alt="QR" class="w-full h-full object-contain opacity-20">
                        </div>
                        <div>
                            <span class="px-2 py-0.5 bg-blue-100 text-blue-600 text-[9px] font-black uppercase tracking-widest rounded-lg">Parcel Found</span>
                            <h3 class="text-2xl font-black text-slate-900">{{ $parcel->tracking_number }}</h3>
                            <p class="text-sm text-slate-500 font-medium">{{ $parcel->origin }} → {{ $parcel->destination }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="h-px bg-slate-200"></div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Travel Date</label>
                            <input wire:model="travel_date" type="date" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Start Time (Departure)</label>
                            <input wire:model="start_travel_time" type="time" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">End Time (Arrival)</label>
                            <input wire:model="end_travel_time" type="time" class="w-full px-5 py-3 bg-white border border-slate-200 rounded-2xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                        </div>
                    </div>

                    <div class="bg-blue-900 rounded-2xl p-6 text-white flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-5l-4-4h-3v10"/><circle cx="7" cy="18" r="2"/><circle cx="17" cy="18" r="2"/></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-white/50 leading-none mb-1">Assigned Bus</p>
                                <p class="text-lg font-black tracking-tight">{{ $bus->plate_number ?? 'No Bus Assigned' }}</p>
                            </div>
                        </div>
                        <button wire:click="saveScan" class="px-8 py-3 bg-white text-blue-900 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-blue-50 transition-all active:scale-95 shadow-lg shadow-blue-500/20">
                            Confirm Scan
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Bus Status Card (Info) -->
    <div class="bg-slate-50 rounded-[2.5rem] p-8 border border-slate-200 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-600">Scan to initiate tracking</p>
                <p class="text-xs text-slate-400">Parcel status will automatically change as time progresses.</p>
            </div>
        </div>
        @if($bus)
            <div class="flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-black uppercase tracking-widest">
                <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                Active Agent: {{ $bus->plate_number }}
            </div>
        @endif
    </div>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-shake { animation: shake 0.2s ease-in-out infinite; }
    
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up { animation: slide-up 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
</style>
