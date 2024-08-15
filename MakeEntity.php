<?php

// app/Console/Commands/CreateService.php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeEntity extends Command
{
    protected $signature = 'make:entity {name}';
    protected $description = 'Create controller with pre written CRUD code in service design pattern, create requests, resource, model, migrations.';

    public function handle()
    {
        try {
            $givenName = $this->argument('name');
            $this->makeService($givenName);
            $this->makeModel($givenName);


        } catch (Throwable $th) {
            $this->info($th->getMessage());
        }
    }

    private function makeModel($givenName)
    {

        $stubPath = base_path('stubs/controller.crud.stub');

        if (!File::exists($stubPath)) {
            $this->error("Stub file 'controller.crud.stub' not found!");
            return;
        }

        $controllerPath = app_path("Http/Controllers/");

        $controllerFilePath = "{$controllerPath}/{$givenName}Controller.php";

        $stubContents = File::get($stubPath);
        $stubContents = str_replace('{{ model }}', $givenName, $stubContents);
        // $stubContents = str_replace('{{ rootNamespace }}', 'App\\', $stubContents);
        $stubContents = str_replace('{{ namespace }}', 'App\\Http\\Controllers', $stubContents);
        $stubContents = str_replace('{{ class }}', $givenName . 'Controller', $stubContents);

        File::put($controllerFilePath, $stubContents);

        // $this->call('make:controller', [
        //     'name' => $givenName . 'Controller',
        //     '--type' => 'crud',
        // ]);

        $this->call('make:model', [
            'name' => $givenName
        ]);

        $this->call('make:request', [
            'name' => $givenName . 'Request'
        ]);

        $this->call('make:resource', [
            'name' => $givenName . 'Resource'
        ]);


       $tableName =  Str::plural(strtolower($givenName));

        $this->call('make:migration', [
            'name' => "create_{$tableName}_table"
        ]);




        $this->info("{$givenName} model, controller, migration, request and api resource created successfully.");
    }

    private function makeService($givenName)
    {

        if (!is_dir(app_path("Services"))) {
            mkdir(app_path("Services"), 0777, true);
        }

        $servicePath = app_path("Services/{$givenName}");
        if (File::exists($servicePath)) {
            $this->error("Service folder '{$givenName}' already exists!");
            return;
        }

        // Create the folder
        File::makeDirectory($servicePath);

        $stubPath = base_path('stubs/service.stub');

        if (!File::exists($stubPath)) {
            $this->error("Stub file 'service.stub' not found!");
            return;
        }

        $serviceFilePath = "{$servicePath}/{$givenName}Service.php";

        $stubContents = File::get($stubPath);
        $stubContents = str_replace('{{ClassName}}', $givenName, $stubContents);
        $stubContents = str_replace('{{model}}', $givenName, $stubContents);


        File::put($serviceFilePath, $stubContents);

        $this->info("Service file '{$givenName}Servive.php' created successfully in app/Services/{$givenName} folder!");
    }

    private function makeRepo($givenName)
    {

        if (!is_dir(app_path("Repositories"))) {
            mkdir(app_path("Repositories"), 0777, true);
        }

        $repoPath = app_path("Repositories/{$givenName}");

        if (File::exists($givenName)) {
            $this->error("Repo folder '{$givenName}' already exists!");
            return;
        }

        // Create the folder
        File::makeDirectory($repoPath);

        // interface
        $repoInterfacePath = base_path('stubs/repoInterface.stub');
        if (!File::exists($repoInterfacePath)) {
            $this->error("Stub file 'repoInterface.stub' not found!");
            return;
        }

        $serviceFilePath = "{$repoPath}/{$givenName}RepositoryInterface.php";

        $stubContents = File::get($repoInterfacePath);
        $stubContents = str_replace('{{ClassName}}', $givenName, $stubContents);

        File::put($serviceFilePath, $stubContents);

        $this->info("'{$givenName}RepositoryInterface.php' created successfully in app/Repositories/{$givenName} folder!");


        // repo file
        $repoStubPath = base_path('stubs/repo.stub');
        if (!File::exists($repoStubPath)) {
            $this->error("Stub file 'repo.stub' not found!");
            return;
        }


        $repoFilePath = "{$repoPath}/{$givenName}Repository.php";

        $repoStubContents = File::get($repoStubPath);
        $repoStubContents = str_replace('{{ClassName}}', $givenName, $repoStubContents);

        File::put($repoFilePath, $repoStubContents);

        $this->info("'{$givenName}Repository.php' created successfully in app/Repositories/{$givenName} folder!");
    }
}
