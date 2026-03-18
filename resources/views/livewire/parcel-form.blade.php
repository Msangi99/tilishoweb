<div class="w-full max-w-xl mx-auto p-6 bg-card rounded-xl shadow-2xl border">
    <div class="space-y-2 mb-6 text-center">
        <h2 class="text-3xl font-bold tracking-tight">Tuma Mzigo Wako</h2>
        <p class="text-muted-foreground">Jaza maelezo hapa chini ili kuanza mchakato wa kutuma mzigo.</p>
    </div>

    @if ($success_message)
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle-2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
            {{ $success_message }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6">
        <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none">Jina la Mtumaji</label>
                <input wire:model="sender_name" type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Jina Kamili">
                @error('sender_name') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none">Simu ya Mtumaji</label>
                <input wire:model="sender_phone" type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Mfano: 0712 345 678">
                @error('sender_phone') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none">Jina la Mpokeaji</label>
                <input wire:model="receiver_name" type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Jina la Mpokeaji">
                @error('receiver_name') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none">Simu ya Mpokeaji</label>
                <input wire:model="receiver_phone" type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Simu ya Mpokeaji">
                @error('receiver_phone') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none">Inatoka</label>
                <select wire:model="origin" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Chagua Mji</option>
                    <option value="Dar es Salaam">Dar es Salaam</option>
                </select>
                @error('origin') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium leading-none">Inakwenda</label>
                <select wire:model="destination" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
                    <option value="">Chagua Mji</option>
                    <option value="Arusha">Arusha</option>
                    <option value="Moshi">Moshi</option>
                    <option value="Rombo">Rombo</option>
                    <option value="Marangu">Marangu</option>
                    <option value="Himo">Himo</option>
                    <option value="Mwanga">Mwanga</option>
                </select>
                @error('destination') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium leading-none">Maelezo ya Mzigo</label>
            <textarea wire:model="parcel_description" class="flex min-h-[80px] w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Tueleze kidogo kuhusu mzigo wako..."></textarea>
            @error('parcel_description') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 px-8 w-full">
            Tuma Ombi la Mzigo
        </button>
    </form>
</div>
