<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Tilisho Admin') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @stack('styles')
        
        <!-- Select2 assets -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <style>
            .select2-container--default .select2-selection--single {
                height: 44px;
                background-color: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 0.75rem;
                display: flex;
                align-items: center;
            }
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: #0f172a;
                font-size: 0.875rem;
                font-weight: 700;
                padding-left: 1rem;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 42px;
            }
            .select2-dropdown {
                border-radius: 0.75rem;
                border: 1px solid #e2e8f0;
                box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
                overflow: hidden;
            }
            .select2-search__field {
                border-radius: 0.5rem !important;
                border: 1px solid #e2e8f0 !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 overflow-y-scroll">
        {{ $slot }}
        @stack('scripts')
        @livewireScripts
    </body>
</html>
