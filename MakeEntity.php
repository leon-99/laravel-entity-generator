<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Throwable;

class MakeEntity extends Command
{
    protected $signature = 'make:entity {name}';
    protected $description = 'Create controller with pre-written CRUD code in service design pattern, create requests, resource, model, and migrations.';

    public function handle()
    {
        try {
            $givenName = $this->argument('name');
            $this->makeService($givenName);
            $this->makeModel($givenName);
            // $this->makeRepo($givenName);

        } catch (Throwable $th) {
            $this->exit();
        }
    }

    private function makeModel($givenName)
    {
        $this->generateController($givenName);
        $this->generateModel($givenName);
        $this->generateRequest($givenName);
        $this->generateResource($givenName);
        $this->generateMigration($givenName);

        $this->info("{$givenName} model, controller, migration, request, and API resource created successfully.");
    }

    private function makeService($givenName)
    {
        $this->createDirectoryIfNotExists(app_path("Services/{$givenName}"));

        $this->generateFileFromStub(
            'service.stub',
            app_path("Services/{$givenName}/{$givenName}Service.php"),
            ['{{ClassName}}' => $givenName, '{{model}}' => $givenName]
        );

        $this->info("Service file '{$givenName}Service.php' created successfully in app/Services/{$givenName} folder!");
    }

    private function makeRepo($givenName)
    {
        $repoPath = app_path("Repositories/{$givenName}");
        $this->createDirectoryIfNotExists($repoPath);

        $this->generateFileFromStub(
            'repoInterface.stub',
            "{$repoPath}/{$givenName}RepositoryInterface.php",
            ['{{ClassName}}' => $givenName]
        );

        $this->generateFileFromStub(
            'repo.stub',
            "{$repoPath}/{$givenName}Repository.php",
            ['{{ClassName}}' => $givenName]
        );

        $this->info("'{$givenName}Repository.php' and '{$givenName}RepositoryInterface.php' created successfully in app/Repositories/{$givenName} folder!");
    }

    private function generateController($givenName)
    {
        $this->generateFileFromStub(
            'controller.crud.stub',
            app_path("Http/Controllers/{$givenName}Controller.php"),
            [
                '{{ model }}' => $givenName,
                '{{ namespace }}' => 'App\\Http\\Controllers',
                '{{ class }}' => "{$givenName}Controller"
            ]
        );
    }

    private function generateModel($givenName)
    {
        $this->call('make:model', [
            'name' => $givenName
        ]);
    }

    private function generateRequest($givenName)
    {
        $this->call('make:request', [
            'name' => $givenName . 'Request'
        ]);
    }

    private function generateResource($givenName)
    {
        $this->call('make:resource', [
            'name' => $givenName . 'Resource'
        ]);
    }

    private function generateMigration($givenName)
    {
        $tableName = Str::plural(strtolower($givenName));

        $this->call('make:migration', [
            'name' => "create_{$tableName}_table"
        ]);
    }

    private function generateFileFromStub($stubName, $outputPath, $replacements)
    {
        $stubPath = base_path("stubs/{$stubName}");

        if (!File::exists($stubPath)) {
            $this->error("Stub file '{$stubName}' not found!");
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
}
