<?php

namespace App\Lemon\Publishers\Resources\Config;

class FileResources
{
    const STANDARD = 'standard';
    const VIRTUAL_COLUMNS = 'virtual-columns';

    public function __invoke($type = self::STANDARD)
    {
        $stubs = [
            self::STANDARD => [
                'controller' => [
                    'type' => 'controller',
                    'stub' => 'stubs/standard/controller.stub',
                    'folder' => 'Controllers',
                    'suffix' => 'Controller.php',
                    'prefix' => '',
                    'has_columns' => 'false',
                ],
                'model' => [
                    'type' => 'model',
                    'stub' => 'stubs/standard/model.stub',
                    'folder' => 'Models',
                    'suffix' => '.php',
                    'prefix' => '',
                    'has_columns' => 'true'
                ],
                'contract' => [
                    'type' => 'contract',
                    'stub' => 'stubs/standard/contract.stub',
                    'folder' => 'Contracts',
                    'suffix' => 'Contract.php',
                    'prefix' => '',
                    'has_columns' => 'false'
                ],
                'factory' => [
                    'type' => 'factory',
                    'stub' => 'stubs/standard/factory.stub',
                    'folder' => 'Factories',
                    'suffix' => 'Factory.php',
                    'prefix' => '',
                    'has_columns' => 'true'
                ],
                'repository' => [
                    'type' => 'repository',
                    'stub' => 'stubs/standard/repository.stub',
                    'folder' => 'Repositories',
                    'suffix' => 'Repository.php',
                    'prefix' => '',
                    'has_columns' => 'false'
                ],
                'resource' => [
                    'type' => 'resource',
                    'stub' => 'stubs/standard/resource.stub',
                    'folder' => 'Resources',
                    'suffix' => 'Resource.php',
                    'prefix' => '',
                    'has_columns' => 'true'
                ],
                'seeder' => [
                    'type' => 'seeder',
                    'stub' => 'stubs/standard/seeder.stub',
                    'folder' => 'Seeders',
                    'suffix' => 'Seeder.php',
                    'prefix' => '',
                    'has_columns' => 'false'
                ],
                'request' => [
                    'type' => 'request',
                    'stub' => 'stubs/standard/form-request.stub',
                    'folder' => 'Requests',
                    'suffix' => 'FormRequest.php',
                    'prefix' => '',
                    'has_columns' => 'true'
                ],
                'create-data' => [
                    'type' => 'dto',
                    'stub' => 'stubs/standard/create-data.stub',
                    'folder' => 'DataTransferObjects',
                    'prefix' => 'Create',
                    'suffix' => 'Data.php',
                    'has_columns' => 'true'
                ],
                'update-data' => [
                    'type' => 'dto',
                    'stub' => 'stubs/standard/update-data.stub',
                    'folder' => 'DataTransferObjects',
                    'prefix' => 'Update',
                    'suffix' => 'Data.php',
                    'has_columns' => 'true'
                ],
            ],
            self::VIRTUAL_COLUMNS => [
                'request' => [
                    'type' => 'request',
                    'stub' => 'stubs/standard/form-request.stub',
                    'folder' => 'Requests',
                    'suffix' => 'FormRequest.php',
                    'prefix' => '',
                    'has_columns' => 'true'
                ],
                'controller' => [
                    'type' => 'controller',
                    'stub' => 'stubs/virtual-columns/controller.stub',
                    'folder' => 'Controllers',
                    'suffix' => 'Controller.php',
                    'prefix' => '',
                    'has_columns' => 'false',
                ],
                'model' => [
                    'type' => 'model',
                    'stub' => 'stubs/virtual-columns/model.stub',
                    'folder' => 'Models',
                    'suffix' => '.php',
                    'prefix' => '',
                    'has_columns' => 'true'
                ],
                'contract' => [
                    'type' => 'contract',
                    'stub' => 'stubs/virtual-columns/contract.stub',
                    'folder' => 'Contracts',
                    'suffix' => 'Contract.php',
                    'prefix' => '',
                    'has_columns' => 'false'
                ],
                'factory' => [
                    'type' => 'factory',
                    'stub' => 'stubs/standard/factory.stub',
                    'folder' => 'Factories',
                    'suffix' => 'Factory.php',
                    'prefix' => '',
                    'has_columns' => 'true'
                ],
                'repository' => [
                    'type' => 'repository',
                    'stub' => 'stubs/virtual-columns/repository.stub',
                    'folder' => 'Repositories',
                    'suffix' => 'Repository.php',
                    'prefix' => '',
                    'has_columns' => 'false'
                ],
                'resource' => [
                    'type' => 'resource',
                    'stub' => 'stubs/standard/resource.stub',
                    'folder' => 'Resources',
                    'suffix' => 'Resource.php',
                    'prefix' => '',
                    'has_columns' => 'true'
                ],
            ]
        ];

        return $stubs[$type];
    }
}
