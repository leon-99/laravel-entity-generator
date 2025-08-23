<?php

namespace WinAung\LaravelEntityGenerator\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class MakeEntity extends Command
{
    protected $signature = 'make:entity {name} {--force : Overwrite existing files}';
    protected $description = 'Create controller with pre-written CRUD code in service design pattern, create requests, resource, model, and migrations.';

    public function handle()
    {
        try {
            $givenName = $this->argument('name');
            
            $this->info("Generating entity: {$givenName}");
            
            $this->makeService($givenName);
            $this->makeModel($givenName);
            $this->makeController($givenName);
            $this->makeRequest($givenName);
            $this->makeResource($givenName);
            $this->makeMigration($givenName);
            
            $this->info("✅ {$givenName} entity generated successfully!");
            $this->info("Files created:");
            $this->line("  - app/Services/{$givenName}/{$givenName}Service.php");
            $this->line("  - app/Http/Controllers/{$givenName}Controller.php");
            $this->line("  - app/Models/{$givenName}.php");
            $this->line("  - app/Http/Requests/{$givenName}Request.php");
            $this->line("  - app/Http/Resources/{$givenName}Resource.php");
            $this->line("  - database/migrations/*_{$givenName}_table.php");

        } catch (Throwable $th) {
            $this->error("Error generating entity: " . $th->getMessage());
            return 1;
        }
    }

    private function makeService($givenName)
    {
        $servicePath = app_path("Services/{$givenName}");
        $this->createDirectoryIfNotExists($servicePath);

        $stubPath = __DIR__ . '/../../Stubs/service.stub';
        $outputPath = "{$servicePath}/{$givenName}Service.php";

        if (!$this->shouldOverwrite($outputPath)) {
            return;
        }

        $this->generateFileFromStub(
            $stubPath,
            $outputPath,
            ['{{ClassName}}' => $givenName, '{{model}}' => $givenName]
        );

        $this->info("Service file '{$givenName}Service.php' created successfully!");
    }

    private function makeController($givenName)
    {
        $stubPath = __DIR__ . '/../../Stubs/controller.crud.stub';
        $outputPath = app_path("Http/Controllers/{$givenName}Controller.php");

        if (!$this->shouldOverwrite($outputPath)) {
            return;
        }

        $this->generateFileFromStub(
            $stubPath,
            $outputPath,
            [
                '{{ model }}' => $givenName,
                '{{ namespace }}' => 'App\\Http\\Controllers',
                '{{ class }}' => "{$givenName}Controller"
            ]
        );

        $this->info("Controller '{$givenName}Controller.php' created successfully!");
    }

    private function makeModel($givenName)
    {
        $this->call('make:model', [
            'name' => $givenName,
            '--force' => $this->option('force')
        ]);
    }

    private function makeRequest($givenName)
    {
        $this->call('make:request', [
            'name' => $givenName . 'Request',
            '--force' => $this->option('force')
        ]);
    }

    private function makeResource($givenName)
    {
        $this->call('make:resource', [
            'name' => $givenName . 'Resource',
            '--force' => $this->option('force')
        ]);
    }

    private function makeMigration($givenName)
    {
        $tableName = Str::plural(strtolower($givenName));

        $this->call('make:migration', [
            'name' => "create_{$tableName}_table",
            '--force' => $this->option('force')
        ]);
    }

    /**
     * Generate file from stub
     *
     * @param string $stubPath
     * @param string $outputPath
     * @param array $replacements array of keys that will be replace with the values.
     * @return void
     */
    private function generateFileFromStub($stubPath, $outputPath, $replacements)
    {
        if (!File::exists($stubPath)) {
            $this->error("Stub file not found: {$stubPath}");
            return;
        }

        $stubContents = File::get($stubPath);
        $stubContents = str_replace(array_keys($replacements), array_values($replacements), $stubContents);

        File::put($outputPath, $stubContents);
    }

    private function createDirectoryIfNotExists($path)
    {
        if (!is_dir($path)) {
            File::makeDirectory($path, 0777, true);
        }
    }

    private function shouldOverwrite($path)
    {
        if (File::exists($path) && !$this->option('force')) {
            if (!$this->confirm("File already exists: {$path}. Overwrite?")) {
                return false;
            }
        }
        return true;
    }
}
