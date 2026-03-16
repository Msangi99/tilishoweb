<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Tilisho Parcel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-background text-foreground">
        <div class="min-h-screen">
            <!-- Navigation -->
            <nav class="sticky top-0 z-50 w-full border-b bg-background/95 backdrop-blur supports-[backdrop-filter]:bg-background/60">
                <div class="container mx-auto px-4 flex h-16 items-center justify-between">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('asset/logo.webp') }}" alt="Tilisho Logo" class="h-10 w-auto">
                        <span class="text-xl font-bold tracking-tight">Tilisho Parcel</span>
                    </div>
                </div>
            </nav>

            <main>
                {{ $slot }}
            </main>

            <!-- Footer / Contact Information -->
            <footer class="bg-primary text-white py-12 border-t border-white/10">
                <div class="container mx-auto px-4">
                    <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Huduma kwa Wateja</h3>
                            <ul class="space-y-2 text-sm text-slate-400">
                                <li>Moshi: +255 746 776 911</li>
                                <li>Arusha: +255 679 374 478</li>
                                <li>Riverside: +255 786 834 378</li>
                                <li>Tarakea: +255 744 034 532</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Linki Muhimu</h3>
                            <ul class="space-y-2 text-sm text-slate-400">
                                <li><a href="#" class="hover:text-yellow-400 transition-colors">Vigezo na Masharti</a></li>
                                <li><a href="#" class="hover:text-yellow-400 transition-colors">Sera ya Faragha</a></li>
                                <li><a href="#" class="hover:text-yellow-400 transition-colors">Sera ya Kughairisha</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-12 pt-8 border-t border-white/10 text-center text-sm text-slate-500">
                        <p>&copy; {{ date('Y') }} Tilisho Parcel Services. Haki zote zimehifadhiwa.</p>
                    </div>
                </div>
            </footer>
        </div>
        @livewireScripts
    </body>
</html>
