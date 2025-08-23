# Installation Guide

This guide will help you install and set up the Laravel Entity Generator package in your Laravel project.

## Prerequisites

- PHP >= 8.0
- Laravel >= 9.0
- Composer

## Installation Methods

### Method 1: Via Composer (Recommended)

1. **Install the package:**
   ```bash
   composer require win-aung/laravel-entity-generator
   ```

2. **Publish configuration (optional):**
   ```bash
   php artisan vendor:publish --tag=config
   ```

3. **Verify installation:**
   ```bash
   php artisan list | grep make:entity
   ```

### Method 2: Manual Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/laravel-entity-generator.git
   ```

2. **Add to composer.json:**
   ```json
   {
       "require": {
           "win-aung/laravel-entity-generator": "*"
       }
   }
   ```

3. **Update dependencies:**
   ```bash
   composer update
   ```

4. **Publish configuration:**
   ```bash
   php artisan vendor:publish --tag=config
   ```

## Quick Start

1. **Generate your first entity:**
   ```bash
   php artisan make:entity Product
   ```

2. **Check generated files:**
   ```bash
   ls app/Services/Product/
   ls app/Http/Controllers/
   ls app/Models/
   ls app/Http/Requests/
   ls app/Http/Resources/
   ls database/migrations/
   ```

3. **Add routes to `routes/api.php`:**
   ```php
   Route::apiResource('products', ProductController::class);
   ```

4. **Run migrations:**
   ```bash
   php artisan migrate
   ```

## Configuration

The package configuration file is located at `config/laravel-entity-generator.php` after publishing:

```php
return [
    'service_namespace' => 'App\\Services',
    'controller_namespace' => 'App\\Http\\Controllers',
    'model_namespace' => 'App\\Models',
    'request_namespace' => 'App\\Http\\Requests',
    'resource_namespace' => 'App\\Http\\Resources',
    'generate_repository' => false,
    'generate_tests' => false,
    'directory_permissions' => 0755,
    'auto_generate_routes' => false,
];
```

## Troubleshooting

### Command Not Found

If you get "Command not found" error:

1. **Clear cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. **Check if package is loaded:**
   ```bash
   composer dump-autoload
   ```

3. **Verify service provider:**
   Check if `WinAung\LaravelEntityGenerator\LaravelEntityGeneratorServiceProvider` is in `config/app.php`

### Permission Issues

If you get permission errors:

1. **Check directory permissions:**
   ```bash
   chmod -R 755 app/
   chmod -R 755 database/
   ```

2. **Run with proper user:**
   ```bash
   sudo -u www-data php artisan make:entity Product
   ```

### Stub Files Not Found

If stub files are missing:

1. **Reinstall package:**
   ```bash
   composer remove win-aung/laravel-entity-generator
   composer require win-aung/laravel-entity-generator
   ```

2. **Check stub paths in configuration**

## Development Installation

For development or local testing:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/your-username/laravel-entity-generator.git
   cd laravel-entity-generator
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Run tests:**
   ```bash
   composer test
   ```

4. **Link to your Laravel project:**
   ```bash
   # In your Laravel project
   composer config repositories.local path ../laravel-entity-generator
   composer require win-aung/laravel-entity-generator:dev-master
   ```

## Support

- **GitHub Issues:** [Create an issue](https://github.com/your-username/laravel-entity-generator/issues)
- **Documentation:** [README.md](README.md)
- **Examples:** Check the [examples](examples/) directory

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md) for contribution guidelines.
