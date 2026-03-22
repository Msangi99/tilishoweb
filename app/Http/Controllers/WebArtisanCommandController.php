<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class WebArtisanCommandController extends Controller
{
    public function index(): Response
    {
        $migrationFiles = collect(File::files(database_path('migrations')))
            ->map(fn (\SplFileInfo $f) => 'database/migrations/'.$f->getFilename())
            ->sort()
            ->values()
            ->all();

        return response()->view('web-artisan.index', [
            'migrationFiles' => $migrationFiles,
            'lastOutput' => session('command_output'),
        ]);
    }

    public function migrate(): Response
    {
        Artisan::call('migrate', ['--force' => true]);

        return $this->backWithOutput();
    }

    public function migrateFresh(): Response
    {
        Artisan::call('migrate:fresh', ['--force' => true]);

        return $this->backWithOutput();
    }

    public function seed(): Response
    {
        Artisan::call('db:seed', ['--force' => true]);

        return $this->backWithOutput();
    }

    public function optimizeClear(): Response
    {
        Artisan::call('optimize:clear');

        return $this->backWithOutput();
    }

    public function migratePath(Request $request): Response
    {
        $validated = $request->validate([
            'path' => ['required', 'string', 'max:500'],
        ]);

        $relative = $this->validatedMigrationPath($validated['path']);

        Artisan::call('migrate', [
            '--path' => $relative,
            '--force' => true,
        ]);

        return $this->backWithOutput();
    }

    protected function validatedMigrationPath(string $path): string
    {
        $path = str_replace(["\0", '..'], '', $path);
        $path = str_replace('\\', '/', $path);
        $path = ltrim($path, '/');

        if (! str_starts_with($path, 'database/migrations/')) {
            throw ValidationException::withMessages([
                'path' => 'Path must be under database/migrations/.',
            ]);
        }

        if (! str_ends_with($path, '.php')) {
            throw ValidationException::withMessages([
                'path' => 'Migration path must be a .php file.',
            ]);
        }

        $full = base_path($path);
        if (! is_file($full)) {
            throw ValidationException::withMessages([
                'path' => 'Migration file not found.',
            ]);
        }

        $migrationsReal = realpath(database_path('migrations'));
        $fileReal = realpath($full);
        if ($migrationsReal === false || $fileReal === false || ! str_starts_with($fileReal, $migrationsReal)) {
            throw ValidationException::withMessages([
                'path' => 'Invalid migration path.',
            ]);
        }

        return $path;
    }

    protected function backWithOutput(): Response
    {
        $output = Artisan::output();
        if (strlen($output) > 50000) {
            $output = substr($output, 0, 50000)."\n… (truncated)";
        }

        return redirect()
            ->route('command.index')
            ->with('command_output', $output);
    }
}
