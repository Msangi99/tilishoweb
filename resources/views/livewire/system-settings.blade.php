<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 font-inter">System Settings</h2>
        <p class="text-sm text-slate-500">Configure global parameters and third-party integrations.</p>
    </div>

    @if (session()->has('message'))
        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-xs font-bold flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="saveSmsSettings" class="space-y-8">
        <fieldset class="p-8 bg-white rounded-3xl border border-slate-200 shadow-sm space-y-6">
            <legend class="px-3 text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] bg-white ml-2">SMS API Configuration (SMS.co.tz)</legend>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                <div class="space-y-2 md:col-span-2">
                    <label class="text-xs font-bold text-slate-700 px-1">Enable SMS</label>
                    <label class="inline-flex items-center gap-3 px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl w-full">
                        <input wire:model="sms_enabled" type="checkbox" class="rounded border-slate-300">
                        <span class="text-sm font-bold text-slate-900">Send automated parcel SMS notifications</span>
                    </label>
                    @error('sms_enabled') <span class="text-[10px] text-red-500 font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 px-1">Sender ID</label>
                    <input wire:model="sender_id" type="text" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900" 
                        placeholder="MYSENDERid">
                    @error('sender_id') <span class="text-[10px] text-red-500 font-bold px-1">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-700 px-1">API Key</label>
                    <input wire:model="api_key" type="password" 
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900" 
                        placeholder="Enter your API Key">
                    @error('api_key') <span class="text-[10px] text-red-500 font-bold px-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="pt-2 flex items-center gap-3 text-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                <p class="text-[10px] font-medium italic">Settings are used for automated parcel notifications via SMS.co.tz API.</p>
            </div>
        </fieldset>

        <div class="flex justify-end pt-4">
            <button type="submit" class="px-8 py-4 bg-slate-900 hover:bg-slate-850 text-white rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-xl shadow-slate-900/20">
                Update Settings
            </button>
        </div>
    </form>
</div>
