<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 font-inter">My Profile</h2>
        <p class="text-sm text-slate-500">Manage your account information and security settings.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Account Info -->
        <div class="space-y-6">
            <form wire:submit.prevent="updateProfile" class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 bg-slate-50/30">
                    <h3 class="text-sm font-black uppercase text-slate-400 tracking-widest">Account Details</h3>
                </div>
                <div class="p-8 space-y-6">
                    @if (session()->has('profile_message'))
                        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-[10px] font-bold flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            {{ session('profile_message') }}
                        </div>
                    @endif

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Full Name</label>
                        <input wire:model="name" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                        @error('name') <span class="text-[10px] text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Username</label>
                            <input wire:model="username" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                            @error('username') <span class="text-[10px] text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Phone Number</label>
                            <input wire:model="phone" type="text" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                            @error('phone') <span class="text-[10px] text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-slate-900/20">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Password Change -->
        <div class="space-y-6">
            <form wire:submit.prevent="updatePassword" class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-slate-100 bg-slate-50/30">
                    <h3 class="text-sm font-black uppercase text-slate-400 tracking-widest">Security</h3>
                </div>
                <div class="p-8 space-y-6">
                    @if (session()->has('password_message'))
                        <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl text-[10px] font-bold flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            {{ session('password_message') }}
                        </div>
                    @endif

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">New Password</label>
                        <input wire:model="password" type="password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900" placeholder="Minimum 8 characters">
                        @error('password') <span class="text-[10px] text-red-500 font-bold ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Confirm New Password</label>
                        <input wire:model="password_confirmation" type="password" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                    </div>
                </div>
                <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all shadow-lg shadow-slate-900/20">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
