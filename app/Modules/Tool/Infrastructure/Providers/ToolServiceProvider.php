<?php

namespace App\Modules\Tool\Infrastructure\Providers;

use App\Shared\Providers\BaseServiceProvider;
use Illuminate\Support\Facades\File;

class ToolServiceProvider extends BaseServiceProvider
{

    public function boot()
    {
        $this->loadCommands('Tool');
    }

}
