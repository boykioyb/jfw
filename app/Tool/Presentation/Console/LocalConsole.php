<?php

namespace App\Tool\Presentation\Console;


use App\Shared\Presentation\Console\BaseConsole;

class LocalConsole extends BaseConsole
{
    public $signature = 'local';

    public function handle()
    {
        dd(config());
    }
}
