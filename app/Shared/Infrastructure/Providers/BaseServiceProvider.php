<?php

namespace App\Shared\Infrastructure\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

abstract class BaseServiceProvider extends ServiceProvider
{
    protected function loadCommands($moduleName): void
    {
        $module = 'app/' . $moduleName;
        $commandsPath = "$module/Presentation/Console/Commands";

        if (File::isDirectory($commandsPath)) {
            $commands = File::files($commandsPath);
            $commandActive = [];
            foreach ($commands as $command) {
                $commandClass = "App\\$moduleName\\Presentation\\Console\\Commands\\" . $command->getFilenameWithoutExtension();
                if (class_exists($commandClass)) {
                    $commandActive[] = $commandClass;
                }
            }

            if (!empty($commandActive)) {
                $this->commands($commandActive);
            }

        }
    }

    protected function loadRepositories($moduleName): void
    {
        $module = 'app/' . $moduleName;
        $repositoryInterfacesPath = "$module/Domain/Repositories";
        $repositoryClassesPath = "$module/Infrastructure/Persistence/Repositories";

        if (File::isDirectory($repositoryInterfacesPath) && File::isDirectory($repositoryClassesPath)) {
            $repositoryClasses = File::files($repositoryClassesPath);
            foreach ($repositoryClasses as $repositoryClass) {
                $repositoryName = $repositoryClass->getFilenameWithoutExtension();
                $interfaceName = str_replace('Impl', '', $repositoryName);
                $repositoryInterface = "App\\$moduleName\\Domain\\Repositories\\I$interfaceName";
                $repositoryClassPath = $repositoryClassesPath . '/' . $repositoryClass->getFilename();
                if (class_exists($repositoryInterface)) {
                    $this->app->bind($repositoryInterface, $repositoryClassPath);
                }
            }
        }
    }

    protected function loadRoutes($moduleName)
    {
        $routes = config($moduleName.'.routes');

        foreach ($routes as $route) {
            Route::middleware($route['middleware'])
                ->prefix($route['prefix'])
                ->namespace($route['namespace'])
                ->as($route['as'])
                ->group($route['path'])
                ->domain($route['domain'] ?? null);
        }
    }

}
