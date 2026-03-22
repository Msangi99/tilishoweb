<div class="space-y-6" x-data="{
    showQrModal: false,
    qrCodeUrl: '',
    qrTrackingId: '',
    showDetails: @entangle('showDetailsModal'),
    initSelect2() {
        if (typeof $ === 'undefined' || !$(this.$refs.originSelect).length) return;
        if ($(this.$refs.originSelect).hasClass('select2-hidden-accessible')) {
            $(this.$refs.originSelect).select2('destroy');
            $(this.$refs.destinationSelect).select2('destroy');
        }
        $(this.$refs.originSelect).select2({ tags: true, placeholder: 'Select origin', width: '100%', dropdownParent: $(this.$el) }).on('change', (e) => { $wire.set('origin', e.target.value); });
        $(this.$refs.destinationSelect).select2({ tags: true, placeholder: 'Select destination', width: '100%', dropdownParent: $(this.$el) }).on('change', (e) => { $wire.set('destination', e.target.value); });
        $(this.$refs.originSelect).val($wire.origin).trigger('change');
        $(this.$refs.destinationSelect).val($wire.destination).trigger('change');
    }
}">
    @if($action === 'create' || ($action === 'edit' && $parcelId))
        {{-- Create / Edit Parcel page --}}
        <div class="flex items-center justify-between mb-6" x-init="$nextTick(() => { initSelect2(); })">
            <a href="{{ route('dashboard', ['view' => 'parcels']) }}"
                class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl text-sm font-bold transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                Back to list
            </a>
            <h2 class="text-2xl font-bold text-slate-900 font-inter tracking-tight">
                {{ $action === 'edit' ? 'Edit Parcel' : 'Register New Parcel' }}</h2>
            <div class="w-24"></div>
        </div>

        <div class="w-full flex justify-center">
            <div class="w-full max-w-3xl bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 pt-6 pb-4 border-b border-slate-100">
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">
                        {{ $editingParcelId ? 'Edit Parcel' : 'Register New Parcel' }}</h3>
                    <p class="text-[11px] text-slate-500 font-bold uppercase tracking-[0.2em] mt-2">Enter shipment details
                        below</p>
                    @if (session()->has('message'))
                        <p class="text-sm font-semibold text-emerald-600 mt-2">{{ session('message') }}</p>
                    @endif
                </div>

                <div class="p-6 space-y-5">
                    <form wire:submit="saveParcel" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-1.5 h-6 bg-blue-600 rounded-full"></div>
                                    <h4 class="text-[10px] font-black uppercase text-slate-900 tracking-widest">Sender
                                        Details</h4>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Name</label>
                                    <input wire:model="sender_name" type="text"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="Sender's Name">
                                    @error('sender_name') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Phone
                                        Number</label>
                                    <input wire:model="sender_phone" type="text"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="+255 700...">
                                    @error('sender_phone') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Email
                                        <span class="font-semibold normal-case text-slate-400">(optional)</span></label>
                                    <input wire:model="sender_email" type="email"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="sender@example.com">
                                    @error('sender_email') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="w-1.5 h-6 bg-emerald-600 rounded-full"></div>
                                    <h4 class="text-[10px] font-black uppercase text-slate-900 tracking-widest">Receiver
                                        Details</h4>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Name</label>
                                    <input wire:model="receiver_name" type="text"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="Receiver's Name">
                                    @error('receiver_name') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Phone
                                        Number</label>
                                    <input wire:model="receiver_phone" type="text"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="+255 700...">
                                    @error('receiver_phone') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Email
                                        <span class="font-semibold normal-case text-slate-400">(optional)</span></label>
                                    <input wire:model="receiver_email" type="email"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="receiver@example.com">
                                    @error('receiver_email') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-1.5 h-6 bg-slate-900 rounded-full"></div>
                                <h4 class="text-[10px] font-black uppercase text-slate-900 tracking-widest">Shipment Info
                                </h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Parcel
                                        name</label>
                                    <input wire:model="parcel_name" type="text"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="e.g. Box, suitcase">
                                    @error('parcel_name') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Creator
                                        office</label>
                                    <input wire:model="creator_office" type="text"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        placeholder="Office where parcel is registered">
                                    @error('creator_office') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Quantity</label>
                                    <input wire:model="quantity" type="number" min="1" step="1"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    @error('quantity') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Weight</label>
                                    <select wire:model="weight_band"
                                        class="w-full h-10 rounded-md border border-input bg-background px-3 py-2 text-sm font-bold text-slate-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring">
                                        <option value="under_20kg">Less than 20 kg</option>
                                        <option value="over_20kg">20 kg or more</option>
                                    </select>
                                    @error('weight_band') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Origin
                                        (From)</label>
                                    <div wire:ignore>
                                        <select x-ref="originSelect"
                                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                                            <option value=""></option>
                                            @foreach($stations as $station)
                                                <option value="{{ $station }}" {{ $origin == $station ? 'selected' : '' }}>
                                                    {{ $station }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('origin') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Destination
                                        (To)</label>
                                    <div wire:ignore>
                                        <select x-ref="destinationSelect"
                                            class="w-full px-5 py-3 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all text-sm font-bold text-slate-900">
                                            <option value=""></option>
                                            @foreach($stations as $station)
                                                <option value="{{ $station }}" {{ $destination == $station ? 'selected' : '' }}>
                                                    {{ $station }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('destination') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 max-w-md">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Travel
                                        date</label>
                                    <input wire:model="travel_date" type="date"
                                        class="flex h-11 w-full rounded-md border border-input bg-background px-3 py-2 text-sm font-semibold ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    @error('travel_date') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Amount
                                        (TZS)</label>
                                    <input wire:model="amount" type="number" step="0.01"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                                    @error('amount') <span
                                    class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Bus
                                        Info</label>
                                    <p class="text-sm text-slate-500 px-1">
                                        Bus will be filled automatically when scanned.
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-black uppercase text-slate-500 tracking-widest px-1">Description</label>
                                <textarea wire:model="description" rows="3"
                                    class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                    placeholder="Describe the parcel content..."></textarea>
                                @error('description') <span
                                class="text-[9px] text-red-500 font-black px-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="pt-6 flex gap-4">
                            <a href="{{ route('dashboard', ['view' => 'parcels']) }}"
                                class="flex-1 px-8 py-4 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all border border-slate-200 text-center">
                                Cancel
                            </a>
                            <button type="submit"
                                class="flex-[2] px-8 py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all shadow-2xl shadow-slate-900/20 flex items-center justify-center gap-3">
                                <span wire:loading.remove
                                    wire:target="saveParcel">{{ $editingParcelId ? 'Editing Disabled' : 'Confirm Registration' }}</span>
                                <div wire:loading wire:target="saveParcel"
                                    class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    @else
            {{-- Parcel list page --}}
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 font-inter tracking-tight">Parcel Management</h2>
                    <p class="text-sm text-slate-500 font-medium">Register and track shipments across the network.</p>
                </div>
                <a href="{{ route('dashboard', ['view' => 'parcels', 'action' => 'create']) }}"
                    class="flex items-center gap-2 px-6 py-3 bg-slate-900 border border-slate-800 hover:bg-slate-800 text-white rounded-xl text-sm font-bold transition-all shadow-lg shadow-slate-900/10 active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    Register New Parcel
                </a>
            </div>

            <!-- DataTable Container -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <!-- Controls -->
                <div
                    class="p-6 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/30">
                    <div class="flex items-center gap-3">
                        <span class="text-[11px] text-slate-400 font-black uppercase tracking-widest">Show</span>
                        <select wire:model.live="perPage"
                            class="bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 block w-20 p-2 outline-none transition-all font-bold">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                    <div class="flex-1 flex justify-end">
                        <div class="relative w-full md:w-64">
                            <div
                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-search">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                placeholder="Search parcels, tracking ID..."
                                class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold focus:ring-4 focus:ring-blue-500/5 focus:border-blue-500 outline-none transition-all placeholder:text-slate-300">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-white">
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Tracking ID / QR</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">Sender
                                </th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Receiver</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">
                                    Destination</th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">Amount
                                </th>
                                <th class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400">Status
                                </th>
                                <th
                                    class="px-6 py-4 text-[11px] font-black uppercase tracking-widest text-slate-400 text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($parcels as $parcel)
                                <tr wire:key="parcel-{{ $parcel->id }}"
                                    class="hover:bg-slate-50/50 transition-colors group cursor-pointer"
                                    @click="if (!$event.target.closest('button') && !$event.target.closest('[data-no-click]')) $wire.viewParcel({{ $parcel->id }})">
                                    <td class="px-6 py-4" data-no-click>
                                        <div class="flex items-center gap-4">
                                            <div @click="showQrModal = true; qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ $parcel->tracking_number }}'; qrTrackingId = '{{ $parcel->tracking_number }}'"
                                                class="w-12 h-12 rounded-xl border border-slate-100 bg-white p-1 shadow-sm flex-shrink-0 cursor-pointer hover:border-blue-500 transition-all active:scale-95 group relative overflow-hidden">
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $parcel->tracking_number }}"
                                                    alt="QR Code" class="w-full h-full object-contain pointer-events-none">
                                                <div
                                                    class="absolute inset-0 bg-blue-600/0 group-hover:bg-blue-600/5 transition-all pointer-events-none">
                                                </div>
                                            </div>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-xs font-black text-slate-900">{{ $parcel->tracking_number }}</span>
                                                @if($parcel->parcel_name)
                                                    <span
                                                        class="text-[10px] text-slate-600 font-semibold line-clamp-1">{{ $parcel->parcel_name }}</span>
                                                @endif
                                                <span
                                                    class="text-[10px] text-slate-400 font-bold">{{ $parcel->created_at->format('M d, H:i') }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900">{{ $parcel->sender_name }}</span>
                                            <span
                                                class="text-[11px] text-slate-500 font-mono">{{ $parcel->sender_phone }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900">{{ $parcel->receiver_name }}</span>
                                            <span
                                                class="text-[11px] text-slate-500 font-mono">{{ $parcel->receiver_phone }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-wrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="text-slate-400 flex-shrink-0">
                                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                                <circle cx="12" cy="10" r="3" />
                                            </svg>
                                            <span
                                                class="text-sm font-bold text-slate-700 line-clamp-1">{{ $parcel->destination }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-black text-slate-900 text-nowrap">TZS
                                            {{ number_format($parcel->amount) }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-amber-50 text-amber-600 border-amber-200',
                                                'in-transit' => 'bg-blue-50 text-blue-600 border-blue-200',
                                                'delivered' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                                'cancelled' => 'bg-red-50 text-red-600 border-red-200',
                                            ];
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg border {{ $statusClasses[$parcel->display_status] ?? 'bg-slate-50 text-slate-600 border-slate-200' }}">
                                            {{ $parcel->display_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            @if(Auth::user()->role == 'admin' && $parcel->scanned_by)
                                                <button wire:click.stop="resetScan({{ $parcel->id }})"
                                                    class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors group/btn"
                                                    title="Reset Scan">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                                        <path d="M3 3v5h5" />
                                                    </svg>
                                                </button>
                                            @endif
                                            <button wire:click="deleteParcel({{ $parcel->id }})"
                                                wire:confirm="Are you sure you want to delete this parcel?"
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-trash-2">
                                                    <path d="M3 6h18" />
                                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                    <line x1="10" x2="10" y1="11" y2="17" />
                                                    <line x1="14" x2="14" y1="11" y2="17" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <div
                                                class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6 border border-slate-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" class="text-slate-300">
                                                    <path d="m7.5 4.27 9 5.15" />
                                                    <path
                                                        d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                                                    <path d="m3.3 7 8.7 5 8.7-5" />
                                                    <path d="M12 22V12" />
                                                </svg>
                                            </div>
                                            <h4 class="text-lg font-bold text-slate-800">No parcels found</h4>
                                            <p class="text-sm text-slate-500 mt-1 max-w-xs mx-auto">Start by registering your
                                                first parcel to see it listed here.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $parcels->links() }}
                </div>
            </div>
        @endif

        <!-- QR Code Preview Modal -->
        <div x-show="showQrModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[110] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md" x-cloak>

            <div @click.away="showQrModal = false" x-show="showQrModal"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="bg-white rounded-[3rem] p-12 shadow-2xl max-w-sm w-full border border-white/20 relative">

                <button @click="showQrModal = false"
                    class="absolute top-6 right-6 p-2 text-slate-400 hover:text-slate-900 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-x">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>

                <div class="text-center">
                    <div class="mb-8">
                        <h4 class="text-2xl font-black text-slate-900 tracking-tight" x-text="qrTrackingId"></h4>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">Scan for tracking
                            info</p>
                    </div>

                    <div
                        class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-inner inline-block mx-auto mb-8">
                        <img :src="qrCodeUrl" alt="QR Code" class="w-64 h-64 object-contain">
                    </div>

                    <button @click="showQrModal = false"
                        class="w-full py-4 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all shadow-xl shadow-slate-900/20">
                        Close Preview
                    </button>
                </div>
            </div>
        </div>

        <!-- Parcel Details Modal -->
        <div x-show="showDetails" class="fixed inset-0 z-[120] overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center min-h-screen p-4">
                <div x-show="showDetails" @click="showDetails = false; $wire.closeDetails()"
                    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity"></div>

                <div x-show="showDetails" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative bg-white rounded-[3rem] shadow-2xl w-full max-w-2xl overflow-hidden border border-slate-200">

                    @if($viewingParcel)
                        <div class="bg-slate-50 p-10 text-slate-900 relative">
                            <button @click="showDetails = false; $wire.closeDetails()"
                                class="absolute top-8 right-8 text-slate-400 hover:text-slate-700 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 6 6 18" />
                                    <path d="m6 6 12 12" />
                                </svg>
                            </button>
                            <div class="flex items-start gap-6">
                                <div class="p-4 bg-white rounded-2xl border border-slate-200">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $viewingParcel->tracking_number }}"
                                        alt="QR" class="w-20 h-20 object-contain">
                                </div>
                                <div>
                                    <p class="text-[11px] font-black tracking-[0.25em] text-slate-500 uppercase">Tilisho
                                        Parcel</p>
                                    <h3 class="text-2xl font-black tracking-[0.2em] mt-1 text-slate-900">RECEIPT</h3>
                                    <p class="text-xs text-slate-500 mt-2">
                                        Tracking ID:
                                        <span
                                            class="font-mono font-semibold text-slate-800">{{ $viewingParcel->tracking_number }}</span>
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        Created:
                                        <span class="font-mono font-semibold text-slate-800">
                                            {{ $viewingParcel->created_at->format('Y-m-d H:i') }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 bg-white">
                            <div class="text-center text-[11px] text-slate-400 tracking-[0.3em] font-black">
                                --------------------------------------------
                            </div>

                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div class="space-y-6">
                                    @if($viewingParcel->parcel_name || $viewingParcel->quantity || $viewingParcel->weight_band || $viewingParcel->creator_office)
                                        <div class="space-y-2 md:col-span-2">
                                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Parcel
                                                item</p>
                                            @if($viewingParcel->parcel_name)
                                                <p class="text-sm font-semibold text-slate-900">{{ $viewingParcel->parcel_name }}</p>
                                            @endif
                                            <p class="text-xs text-slate-600">
                                                @if($viewingParcel->quantity)
                                                    Qty: <span class="font-mono font-semibold">{{ $viewingParcel->quantity }}</span>
                                                @endif
                                                @if($viewingParcel->weight_band)
                                                    @if($viewingParcel->quantity) · @endif
                                                    Weight:
                                                    <span class="font-semibold">{{ $viewingParcel->weight_band === 'over_20kg' ? '20 kg or more' : 'Less than 20 kg' }}</span>
                                                @endif
                                            </p>
                                            @if($viewingParcel->creator_office)
                                                <p class="text-xs text-slate-600">
                                                    Creator office: <span class="font-semibold">{{ $viewingParcel->creator_office }}</span>
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Sender</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ $viewingParcel->sender_name }}</p>
                                        <p class="text-xs font-mono text-slate-600">{{ $viewingParcel->sender_phone }}</p>
                                        @if($viewingParcel->sender_email)
                                            <p class="text-xs text-slate-600 break-all">{{ $viewingParcel->sender_email }}</p>
                                        @endif
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Receiver</p>
                                        <p class="text-sm font-semibold text-slate-900">{{ $viewingParcel->receiver_name }}</p>
                                        <p class="text-xs font-mono text-slate-600">{{ $viewingParcel->receiver_phone }}</p>
                                        @if($viewingParcel->receiver_email)
                                            <p class="text-xs text-slate-600 break-all">{{ $viewingParcel->receiver_email }}</p>
                                        @endif
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1">
                                            Description
                                        </p>
                                        <p class="text-sm text-slate-700 italic">
                                            "{{ $viewingParcel->description ?: 'No description provided.' }}"
                                        </p>
                                    </div>
                                </div>

                                <div class="space-y-6">
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Route</p>
                                        <p class="text-sm font-semibold text-slate-900">
                                            {{ $viewingParcel->origin }} &rarr; {{ $viewingParcel->destination }}
                                        </p>
                                        <p class="text-xs text-slate-500">
                                            Travel date:
                                            <span class="font-mono">
                                                {{ $viewingParcel->travel_date ? \Carbon\Carbon::parse($viewingParcel->travel_date)->format('Y-m-d') : 'N/A' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Amount &
                                            Status</p>
                                        <p class="text-sm font-black text-slate-900">
                                            TZS {{ number_format($viewingParcel->amount) }}
                                        </p>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span
                                                class="px-2 py-0.5 rounded-lg border text-[10px] font-black uppercase tracking-widest {{ $statusClasses[$viewingParcel->display_status] ?? '' }}">
                                                {{ $viewingParcel->display_status }}
                                            </span>
                                            @if($viewingParcel->transported_by_name)
                                                <span class="text-[10px] font-semibold text-slate-500">
                                                    Given to: {{ $viewingParcel->transported_by_name }}
                                                    @if($viewingParcel->transported_by_phone)
                                                        · {{ $viewingParcel->transported_by_phone }}
                                                    @endif
                                                </span>
                                            @endif
                                            @if($viewingParcel->received_by_name)
                                                <span class="text-[10px] font-semibold text-emerald-600">
                                                    Received by: {{ $viewingParcel->received_by_name }}
                                                    @if($viewingParcel->received_by_phone)
                                                        · {{ $viewingParcel->received_by_phone }}
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                        @if($viewingParcel->transported_at || $viewingParcel->received_at)
                                            <div class="space-y-1 text-[10px] text-slate-500 mt-1">
                                                @if($viewingParcel->transported_at)
                                                    <p>
                                                        Imported at:
                                                        <span class="font-mono">{{ $viewingParcel->transported_at }}</span>
                                                    </p>
                                                @endif
                                                @if($viewingParcel->received_at)
                                                    <p>
                                                        Received at:
                                                        <span class="font-mono">{{ $viewingParcel->received_at }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 text-center text-[11px] text-slate-400 tracking-[0.3em] font-black">
                                --------------------------------------------
                            </div>

                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                                @if($viewingParcel->createdBy)
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">
                                            Created By
                                        </p>
                                        <p class="text-sm font-semibold text-slate-900">
                                            {{ $viewingParcel->createdBy?->name }}
                                        </p>
                                        @if($viewingParcel->createdBy?->phone)
                                            <p class="text-xs font-mono text-slate-600">
                                                {{ $viewingParcel->createdBy?->phone }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                @php
                                    $transportedBus = $viewingParcel->transportedBus;
                                    $busPlate = $transportedBus?->plate_number;
                                    $busRoute = $viewingParcel->transported_route ?: $transportedBus?->route_name;
                                @endphp
                                @if($busPlate || $busRoute)
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">
                                            Transport Bus
                                        </p>
                                        @if($busPlate)
                                            <p class="text-sm font-semibold text-slate-900">
                                                Plate: {{ $busPlate }}
                                            </p>
                                        @endif
                                        @if($busRoute)
                                            <p class="text-xs text-slate-600">
                                                Route: {{ $busRoute }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="mt-6 text-center text-[11px] text-slate-400 tracking-[0.3em] font-black">
                                --------------------------------------------
                            </div>

                            <div class="mt-8 flex items-center justify-between">
                                <button @click="showDetails = false; $wire.closeDetails()"
                                    class="px-8 py-3 bg-slate-50 hover:bg-slate-100 text-slate-600 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all">
                                    Close Receipt
                                </button>
                                <p class="text-[10px] text-slate-400 font-medium italic">
                                    Thank you for using Tilisho
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <style>
            [x-cloak] {
                display: none !important;
            }

            .select2-container--default .select2-selection--single {
                border-radius: 1rem !important;
                height: 48px !important;
                padding-top: 4px !important;
                background-color: #f8fafc !important;
                border: 1px solid #e2e8f0 !important;
            }
        </style>
    </div>