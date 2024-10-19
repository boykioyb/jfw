<?php

namespace App\Shared\Presentation\Console;

use Illuminate\Console\Command;

abstract class BaseConsole extends Command
{

    abstract public function handle();
}
