<?php

namespace App\Shared\Presentation\Console\Command;

use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{

    abstract public function handle();
}
