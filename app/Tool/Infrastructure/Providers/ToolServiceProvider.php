<?php

namespace App\Tool\Infrastructure\Providers;

use App\Shared\Infrastructure\Providers\BaseServiceProvider;

class ToolServiceProvider extends BaseServiceProvider
{

    public function boot()
    {
        $this->loadCommands('Tool');
    }

}
