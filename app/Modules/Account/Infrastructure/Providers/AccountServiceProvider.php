<?php

namespace App\Modules\Account\Infrastructure\Providers;

use App\Shared\Providers\BaseServiceProvider;
use App\Modules\Account\Domains\Repositories\AccountRepository;
use App\Modules\Account\Infrastructure\Persistence\Repositories\AccountRepositoryImpl;

class AccountServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        // Đăng ký các dịch vụ
        $this->app->bind(AccountRepository::class, AccountRepositoryImpl::class);

        $this->mergeConfigFrom(
           __DIR__ . '/../Config/config.php', 'Account'
        );
    }

    public function boot()
    {
        // Khởi tạo các thành phần khác

        // Load migration
        $this->loadMigrationsFrom(__DIR__ . '/../Persistence/Migrations');

        // Load route API
        $this->loadRoutesFrom(__DIR__ . '/../../Presentation/API/Routes/api.php');


        // Publish config file khi dùng `php artisan vendor:publish`
        $this->publishes([
          __DIR__ . '/../Config/config.php' => config_path('Account.php'),
        ], 'config');

        $this->loadCommands('Account');
        $this->loadRepositories('Account');

    }
}
