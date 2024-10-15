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
}
