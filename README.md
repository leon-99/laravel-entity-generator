# Laravel Entity Generator

A powerful Laravel package that generates complete CRUD entities with controllers, models, services, requests, resources, and migrations using the service design pattern.

## Features

- 🚀 **Fast Entity Generation**: Generate complete CRUD entities with a single command
- 🏗️ **Service Pattern**: Built-in service layer for business logic separation
- 📝 **Auto-generated Files**: Controllers, Models, Services, Requests, Resources, and Migrations
- ⚡ **Laravel Best Practices**: Follows Laravel conventions and design patterns
- 🔧 **Customizable**: Easy to customize stubs and configuration
- 💪 **Production Ready**: Includes proper error handling and transactions

## Installation

### Via Composer

```bash
composer require win-aung/laravel-entity-generator:dev-main
```

## Usage

### Basic Usage

Generate a complete entity with all CRUD operations:

```bash
php artisan make:entity User
```

This will create:
- `app/Services/User/UserService.php` - Service layer for business logic
- `app/Http/Controllers/UserController.php` - RESTful controller with CRUD methods
- `app/Models/User.php` - Eloquent model
- `app/Http/Requests/UserRequest.php` - Form request validation
- `app/Http/Resources/UserResource.php` - API resource for JSON responses
- `database/migrations/*_users_table.php` - Database migration

### Force Overwrite

To overwrite existing files:

```bash
php artisan make:entity User --force
```

### Interactive Mode

If files already exist, the command will ask for confirmation:

```bash
php artisan make:entity User
# Will prompt: "File already exists: app/Http/Controllers/UserController.php. Overwrite?"
```

## Generated Files Structure

### Controller (`UserController.php`)

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\User\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->sendResponse($this->userService->getAll(), 200, 'User retrieved');
    }

    public function store(UserRequest $request)
    {
        $data = $this->userService->create($request->all());
        return $this->sendResponse($data, 201, 'User created');
    }

    // ... other CRUD methods
}
```

### Service (`UserService.php`)

```php
<?php

namespace App\Services\User;

use App\Models\User;

class UserService
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    // ... other methods
}
```

## Configuration

Publish the configuration file to customize the package:

```bash
php artisan vendor:publish --tag=config
```

This will create `config/laravel-entity-generator.php` with the following options:

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
];
```

## Customization

### Custom Stubs

You can customize the generated code by publishing and modifying the stub files:

1. Publish the stubs:
```bash
php artisan vendor:publish --tag=stubs
```

2. Modify the stub files in `resources/stubs/`

3. Update the configuration to use your custom stubs:
```php
'stub_paths' => [
    'controller' => resource_path('stubs/controller.crud.stub'),
    'service' => resource_path('stubs/service.stub'),
],
```

## API Endpoints

The generated controller provides these RESTful endpoints:

- `GET /users` - List all users
- `POST /users` - Create a new user
- `GET /users/{id}` - Show a specific user
- `PUT /users/{id}` - Update a user
- `DELETE /users/{id}` - Delete a user

## Response Format

All API responses follow a consistent format:

### Success Response
```json
{
    "success": true,
    "data": {...},
    "message": "User created"
}
```

### Error Response
```json
{
    "success": false,
    "message": "User not found"
}
```

## Requirements

- PHP >= 8.0
- Laravel >= 9.0

## Testing

```bash
composer test
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Support

If you encounter any issues or have questions, please open an issue on GitHub.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Win Aung](https://github.com/leon-99)
- All Contributors

---

**Made with ❤️ for the Laravel community** 
    
