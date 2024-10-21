<?php

namespace App\Shared\Infrastructure\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadModules();

        // load file helpers
        $helpers = base_path('app/Shared/Infrastructure/helpers.php');
        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }

    public function boot()
    {

        $this->app['router']->aliasMiddleware('tracing', \App\Shared\Infrastructure\Middleware\TraceMiddleware::class);

    }

    protected function loadModules()
    {
        $modulesPath = base_path('app');
        if (File::isDirectory($modulesPath)) {
            $modules = File::directories($modulesPath);

            foreach ($modules as $module) {
                $moduleName = basename($module);
                if ($moduleName === 'Shared') {
                    continue;
                }

                $providerClass = "\\App\\$moduleName\\Infrastructure\\Providers\\{$moduleName}ServiceProvider";
                if (class_exists($providerClass)) {
                    $this->app->register($providerClass);
                }
            }
        }
    }
}
