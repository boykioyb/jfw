<?php

namespace App\Shared\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

abstract class BaseServiceProvider extends ServiceProvider
{
    protected function loadCommands($moduleName)
    {
        $module = 'app/Modules/' . $moduleName;
        $commandsPath = "$module/Presentation/Console/Commands";

        if (File::isDirectory($commandsPath)) {
            $commands = File::files($commandsPath);
            $commandActive = [];
            foreach ($commands as $command) {
                $commandClass = "App\\Modules\\$moduleName\\Presentation\\Console\\Commands\\" . $command->getFilenameWithoutExtension();
                if (class_exists($commandClass)) {
                    $commandActive[] = $commandClass;
                }
            }

            if (!empty($commandActive)) {
                $this->commands($commandActive);
            }

        }
    }

    protected function loadRepositories($moduleName)
    {
        $module = 'app/Modules/' . $moduleName;
        $repositoriesPath = "$module/Domains/Repositories";

        if (File::isDirectory($repositoriesPath)) {
            $repositories = File::files($repositoriesPath);
            foreach ($repositories as $repository) {
                $repositoryInterface = "App\\Modules\\$moduleName\\Domains\\Repositories\\" . $repository->getFilenameWithoutExtension();
                $repositoryClass = "App\\Modules\\$moduleName\\Infrastructure\\Persistence\\Repositories\\" . $repository->getFilenameWithoutExtension();

                if (class_exists($repositoryInterface) && class_exists($repositoryClass)) {
                    $this->app->bind($repositoryInterface, $repositoryClass);
                }
            }
        }
    }
}
