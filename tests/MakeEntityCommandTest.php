<?php

namespace WinAung\LaravelEntityGenerator\Tests;

use Illuminate\Support\Facades\File;
use WinAung\LaravelEntityGenerator\Console\Commands\MakeEntity;

class MakeEntityCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Clean up any generated files
        $this->cleanupGeneratedFiles();
    }

    protected function tearDown(): void
    {
        $this->cleanupGeneratedFiles();
        parent::tearDown();
    }

    public function test_it_can_generate_entity_files()
    {
        $this->artisan('make:entity', ['name' => 'TestEntity'])
            ->expectsOutput('Generating entity: TestEntity')
            ->expectsOutput('Service file \'TestEntityService.php\' created successfully!')
            ->expectsOutput('Controller \'TestEntityController.php\' created successfully!')
            ->expectsOutput('✅ TestEntity entity generated successfully!')
            ->assertExitCode(0);

        // Check if files were created
        $this->assertFileExists(app_path('Services/TestEntity/TestEntityService.php'));
        $this->assertFileExists(app_path('Http/Controllers/TestEntityController.php'));
    }

    public function test_it_creates_service_directory_structure()
    {
        $this->artisan('make:entity', ['name' => 'Product']);

        $this->assertDirectoryExists(app_path('Services/Product'));
        $this->assertFileExists(app_path('Services/Product/ProductService.php'));
    }

    public function test_it_generates_correct_service_content()
    {
        $this->artisan('make:entity', ['name' => 'Order']);

        $serviceContent = File::get(app_path('Services/Order/OrderService.php'));
        
        $this->assertStringContainsString('namespace App\\Services\\Order;', $serviceContent);
        $this->assertStringContainsString('class OrderService', $serviceContent);
        $this->assertStringContainsString('use App\\Models\\Order;', $serviceContent);
    }

    public function test_it_generates_correct_controller_content()
    {
        $this->artisan('make:entity', ['name' => 'Customer']);

        $controllerContent = File::get(app_path('Http/Controllers/CustomerController.php'));
        
        $this->assertStringContainsString('namespace App\\Http\\Controllers;', $controllerContent);
        $this->assertStringContainsString('class CustomerController extends Controller', $controllerContent);
        $this->assertStringContainsString('CustomerService $customerService', $controllerContent);
    }

    public function test_it_handles_force_option()
    {
        // Generate first time
        $this->artisan('make:entity', ['name' => 'Item']);
        
        // Generate again with force
        $this->artisan('make:entity', ['name' => 'Item', '--force' => true])
            ->expectsOutput('Generating entity: Item')
            ->assertExitCode(0);
    }

    private function cleanupGeneratedFiles()
    {
        $paths = [
            app_path('Services/TestEntity'),
            app_path('Services/Product'),
            app_path('Services/Order'),
            app_path('Services/Customer'),
            app_path('Services/Item'),
            app_path('Http/Controllers/TestEntityController.php'),
            app_path('Http/Controllers/ProductController.php'),
            app_path('Http/Controllers/OrderController.php'),
            app_path('Http/Controllers/CustomerController.php'),
            app_path('Http/Controllers/ItemController.php'),
        ];

        foreach ($paths as $path) {
            if (File::exists($path)) {
                if (is_dir($path)) {
                    File::deleteDirectory($path);
                } else {
                    File::delete($path);
                }
            }
        }
    }
}
