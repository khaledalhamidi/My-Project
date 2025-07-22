<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class CreateServiceCommand extends GeneratorCommand
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class';
    protected $type = 'Service';

    protected function getStub()
    {
        return base_path('stubs/service.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Services';// here the folder stored in
    }
}


//step 1.create command php artisan make:command CreateServiceCommand set  getStub() this for path and  getDefaultNamespace this for new folder
//step 2.create file inside stubs by the name  inside   return $rootNamespace . '\Services';
//step 3.run  php artisan make:service PaymentService it will create new folder called services and the payment will be inside the folder
