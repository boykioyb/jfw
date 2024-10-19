<?php

namespace App\Shared\Infrastructure\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

abstract class BaseServiceProvider extends ServiceProvider
{
    protected function loadCommands($moduleName)
    {
        $module = 'app/' . $moduleName;
        $commandsPath = "$module/Presentation/Console";

        if (File::isDirectory($commandsPath)) {
            $commands = File::files($commandsPath);
            $commandActive = [];
            foreach ($commands as $command) {
                $commandClass = "App\\$moduleName\\Presentation\\Console\\" . $command->getFilenameWithoutExtension();
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
        $module = 'app/' . $moduleName;
        $repositoryInterfacesPath = "$module/Domain/Repositories";
        $repositoryClassesPath = "$module/Infrastructure/Persistence/Repositories";

        if (File::isDirectory($repositoryInterfacesPath) && File::isDirectory($repositoryClassesPath)) {
            $repositoryInterfaces = File::files($repositoryInterfacesPath);
            $repositoryClasses = File::files($repositoryClassesPath);

            foreach ($repositoryInterfaces as $repositoryInterface) {
                $interfaceName = $repositoryInterface->getFilenameWithoutExtension();
                $interfaceClass = "App\\$moduleName\\Domain\\Repositories\\" . $interfaceName;

                foreach ($repositoryClasses as $repositoryClass) {
                    $className = $repositoryClass->getFilenameWithoutExtension();
                    $class = "App\\$moduleName\\Infrastructure\\Persistence\\Repositories\\" . $className;

                    if (class_exists($interfaceClass) && class_exists($class)) {
                        $this->app->bind($interfaceClass, $class);
                    }
                }
            }
        }
    }

}
