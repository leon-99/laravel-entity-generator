# Laravel Entity Generator Command

Easily generate all the necessary CRUD code for your entities in a clean service design pattern with this Laravel command. It automates the creation of controllers, services, and more, allowing you to focus on building your application.

## Features

- **Automatic Code Generation**: Generate complete CRUD operations in a service-based architecture.
- **Customizable Stubs**: Modify the stubs to tailor the generated code to your specific needs.
- **Seamless Integration**: Quickly integrate into any existing Laravel project with minimal setup.

## Installation

1. **Publish the Stubs**  
   First, publish the Laravel stubs by running the following command:

   > php artisan stub:publish

After running this command, a new folder named stubs will appear in your project.

   2. Place `service.stub` and `controller.crud.stub` files into the `stubs` folder.
   3. Next, place the MakeEntity.php file into the `app\Console\Commands` directory in your project. Create the directory if it doesn't exist.

---

## Usage

    To generate the necessary files for an entity, use the following command:
> php artisan make:entity {Name}

    {Name} could be an entity such as Car, Shop, User, etc.
    
