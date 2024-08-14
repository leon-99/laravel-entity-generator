<?php

// app/Console/Commands/CreateService.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ServiceRepo extends Command
{
    protected $signature = 'make:serviceRepo {name}';
    protected $description = 'Create a new service file in app/Services folder with a subfolder';

    public function handle()
    {
        // Repo
        $repoName = $this->argument('name');

        if (!is_dir(app_path("Repositories"))) {
            mkdir(app_path("Repositories"), 0777, true);
        }

        $repoPath = app_path("Repositories/{$repoName}");

        if (File::exists($repoName)) {
            $this->error("Repo folder '{$repoName}' already exists!");
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

        $serviceFilePath = "{$repoPath}/{$repoName}RepositoryInterface.php";

        $stubContents = File::get($repoInterfacePath);
        $stubContents = str_replace('{{ClassName}}', $repoName, $stubContents);

        File::put($serviceFilePath, $stubContents);

        $this->info("'{$repoName}RepositoryInterface.php' created successfully in app/Repositories/{$repoName} folder!");


        // repo file
        $repoStubPath = base_path('stubs/repo.stub');
        if (!File::exists($repoStubPath)) {
            $this->error("Stub file 'repo.stub' not found!");
            return;
        }


        $repoFilePath = "{$repoPath}/{$repoName}Repository.php";

        $repoStubContents = File::get($repoStubPath);
        $repoStubContents = str_replace('{{ClassName}}', $repoName, $repoStubContents);

        File::put($repoFilePath, $repoStubContents);

        $this->info("'{$repoName}Repository.php' created successfully in app/Repositories/{$repoName} folder!");

        // ---------------------------------


        $serviceName = $this->argument('name');

        if (!is_dir(app_path("Services"))) {
            mkdir(app_path("Services"), 0777, true);
        }

        $servicePath = app_path("Services/{$serviceName}");

        if (File::exists($servicePath)) {
            $this->error("Service folder '{$serviceName}' already exists!");
            return;
        }

        // Create the folder
        File::makeDirectory($servicePath);

        $stubPath = base_path('stubs/service.stub');

        if (!File::exists($stubPath)) {
            $this->error("Stub file 'service.stub' not found!");
            return;
        }

        $serviceFilePath = "{$servicePath}/{$repoName}Service.php";

        $stubContents = File::get($stubPath);
        $stubContents = str_replace('{{ClassName}}', $repoName, $stubContents);

        File::put($serviceFilePath, $stubContents);

        $this->info("Service file '{$repoName}.php' created successfully in app/Services/{$serviceName} folder!");

        // ----------------------------------------------

        // Other files

        $this->call('make:model', [
            'name' => $repoName,
            '--resource' => true,
            '--controller' =>'Api/' . $repoName . 'Controller',
            '--requests' => true,
            '--migration' => true
        ]);


        $this->info("{$repoName} model, controller, migration, request and api resource created successfully.");
    }
}


