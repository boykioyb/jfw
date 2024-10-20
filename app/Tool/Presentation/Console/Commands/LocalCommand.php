<?php

namespace App\Tool\Presentation\Console\Commands;


use App\Shared\Presentation\Console\Command\BaseCommand;

class LocalCommand extends BaseCommand
{
    public $signature = 'local';

    public function handle()
    {
        dd(config());
    }
}
