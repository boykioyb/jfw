<?php

namespace App\Tool\Presentation\Console\Commands;

use App\Shared\Presentation\Console\Command\BaseCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModelCommand extends BaseCommand
{
    protected $signature = 'make:model {moduleName} {name}';

    public function handle()
    {
        // TODO: Implement handle() method.
        $moduleName = $this->argument('moduleName');
        $name = $this->argument('name');
        $directory = "app/$moduleName/Infrastructure/Persistence/Models";
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $fileName = "{$name}.php";
        $path = $directory . '/' . $fileName;
        if (!File::exists($path)) {
            File::put($path, $this->getStubContent($moduleName, $name));
            $this->info("Tạo model: $path");
        }

    }


    protected function getStubContent($moduleName,$name): array|string
    {
        $stubPath = resource_path("stubs/eloquent-model.stub");
        $content = File::get($stubPath);
        return str_replace(
            ['{{ name }}','{{ table_name }}', '{{ fillable }}', '{{ namespace }}'],
            [
                $name,
                strtolower(Str::plural($name)),
                "'name', 'description', 'price'",
                $moduleName
            ],
            $content
        );
    }
}
