<x-layouts.admin>
    @push('styles')
        <style>
            /* Native selects ignore many utilities in some browsers; force readable contrast */
            #web-artisan-migration-path,
            #web-artisan-migration-path option {
                color: #0f172a;
                background-color: #ffffff;
            }
        </style>
    @endpush
    <div class="min-h-screen bg-slate-50 p-6 md:p-10 max-w-3xl mx-auto space-y-8 text-slate-900">
        <div>
            <h1 class="text-2xl font-black text-slate-900">Artisan (web)</h1>
            <p class="text-sm text-slate-600 mt-1">
                Whitelisted commands only. Requires <code class="text-xs bg-slate-200 text-slate-900 px-1 rounded font-mono">ALLOW_WEB_COMMANDS=true</code> and local environment (or
                <code class="text-xs bg-slate-200 text-slate-900 px-1 rounded font-mono">ALLOW_WEB_COMMANDS_IN_PRODUCTION=true</code>).
            </p>
        </div>

        @if (session('command_output'))
            <div class="rounded-2xl border border-slate-200 bg-slate-900 text-slate-100 p-4 overflow-x-auto">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Last output</p>
                <pre class="text-xs font-mono whitespace-pre-wrap break-words">{{ session('command_output') }}</pre>
            </div>
        @endif

        <div class="space-y-6">
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest">Run command</h2>
                <div class="flex flex-col gap-3">
                    <form method="post" action="{{ route('command.migrate') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-bold hover:bg-slate-800">
                            php artisan migrate --force
                        </button>
                    </form>
                    <form method="post" action="{{ route('command.migrate-fresh') }}" class="inline" onsubmit="return confirm('migrate:fresh will drop all tables. Continue?');">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-red-700 text-white text-sm font-bold hover:bg-red-800">
                            php artisan migrate:fresh --force
                        </button>
                    </form>
                    <form method="post" action="{{ route('command.seed') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-emerald-700 text-white text-sm font-bold hover:bg-emerald-800">
                            php artisan db:seed --force
                        </button>
                    </form>
                    <form method="post" action="{{ route('command.optimize-clear') }}" class="inline">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto px-4 py-2 rounded-xl bg-indigo-700 text-white text-sm font-bold hover:bg-indigo-800">
                            php artisan optimize:clear
                        </button>
                    </form>
                </div>
            </section>

            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h2 class="text-sm font-black text-slate-900 uppercase tracking-widest">Migrate single file</h2>
                <p class="text-xs text-slate-600">Runs <code class="bg-slate-100 text-slate-900 px-1 rounded font-mono">php artisan migrate --path=… --force</code></p>
                <form method="post" action="{{ route('command.migrate-path') }}" class="space-y-3">
                    @csrf
                    <div>
                        <label for="web-artisan-migration-path" class="text-[10px] font-bold text-slate-700 uppercase">Path</label>
                        <select name="path" id="web-artisan-migration-path" class="mt-1 w-full rounded-xl border border-slate-300 bg-white py-2 px-3 text-sm font-semibold text-slate-900 shadow-sm" @disabled(count($migrationFiles) === 0)>
                            @forelse ($migrationFiles as $file)
                                <option value="{{ $file }}">{{ $file }}</option>
                            @empty
                                <option value="">No migration files found</option>
                            @endforelse
                        </select>
                        @error('path')
                            <p class="text-xs text-red-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 text-white text-sm font-bold hover:bg-slate-700">
                        Run migrate --path
                    </button>
                </form>
            </section>
        </div>

        <p class="text-xs text-slate-400">
            <a href="{{ route('dashboard') }}" class="text-blue-600 font-semibold hover:underline">← Back to dashboard</a>
        </p>
    </div>
</x-layouts.admin>
