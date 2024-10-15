<?php

namespace App\Shared\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadModules();
    }

    public function boot()
    {
        //
    }

    protected function loadModules()
    {
        $modulesPath = base_path('app/Modules');
        if (File::isDirectory($modulesPath)) {
            $modules = File::directories($modulesPath);

            foreach ($modules as $module) {
                $moduleName = basename($module);
                $providerClass = "\\App\\Modules\\$moduleName\\Infrastructure\\Providers\\{$moduleName}ServiceProvider";
                if (class_exists($providerClass)) {
                    $this->app->register($providerClass);
                }
            }
        }
    }
}
