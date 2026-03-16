<div class="w-full max-w-sm mx-auto p-8 bg-card rounded-xl shadow-2xl border">
    <div class="space-y-2 mb-8 text-center">
        <h2 class="text-3xl font-bold tracking-tight">Ingia</h2>
        <p class="text-muted-foreground">Ingia katika mfumo wa Tilisho Admin</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle-2"><path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/><path d="m9 12 2 2 4-4"/></svg>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-destructive/10 border border-destructive/20 text-destructive rounded-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-circle"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-6">
        <div class="space-y-2">
            <label class="text-sm font-medium leading-none">Username</label>
            <input wire:model="username" type="text" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="Username yako">
            @error('username') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label class="text-sm font-medium leading-none">Password</label>
                <a href="#" class="text-xs text-primary hover:underline">Umesahau password?</a>
            </div>
            <input wire:model="password" type="password" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" placeholder="••••••••">
            @error('password') <span class="text-xs text-destructive">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-11 px-8 w-full">
            Ingia Sasa
        </button>
    </form>
</div>
