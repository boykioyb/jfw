<?php

namespace App\Tool\Presentation\Console\Commands;

use App\Shared\Presentation\Console\Command\BaseCommand;
use Illuminate\Support\Facades\File;

class MakeRepositoryCommand extends BaseCommand
{
    public $signature = 'make:repository {moduleName} {name} {--rm}';

    public function handle()
    {
        // TODO: Implement handle() method.

        $moduleName = $this->argument('moduleName');
        $name = $this->argument('name');
        $directory = "app/$moduleName/Infrastructure/Persistence/Repositories";
        $directoryInterface = "app/$moduleName/Domain/Repositories";
        $fileName = "{$name}RepositoryImpl.php";
        $interfaceFileName = "I{$name}Repository.php";
        $pathInterface = $directoryInterface . '/' . $interfaceFileName;
        $path = $directory . '/' . $fileName;

        if ($this->option('rm')) {
            if (File::exists($pathInterface)) {
                File::delete($pathInterface);
                $this->info("Xóa interface: $pathInterface");
            }
            if (File::exists($path)) {
                File::delete($path);
                $this->info("Xóa repository: $path");
            }
            return;
        }
        if (!File::isDirectory($directoryInterface)) {
            File::makeDirectory($directoryInterface, 0755, true);
        }

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        if (!File::exists($pathInterface)) {
            File::put($pathInterface, $this->getStubInterfaceContent($moduleName, $name));
            $this->info("Tạo interface: $pathInterface");
        }
        if (!File::exists($path)) {
            File::put($path, $this->getStubContent($moduleName, $name));
            $this->info("Tạo repository: $path");
        }
    }

    protected function getStubContent($moduleName, $name): array|string
    {
        $stubPath = resource_path("stubs/infrastructure-repository.stub");
        $content = File::get($stubPath);
        return str_replace(
            ['{{ name }}', '{{ namespace }}'],
            [
                $name,
                $moduleName
            ],
            $content
        );
    }

    protected function getStubInterfaceContent($moduleName, $name): array|string
    {
        $stubPath = resource_path("stubs/repository.stub");
        $content = File::get($stubPath);
        return str_replace(
            ['{{ name }}', '{{ namespace }}'],
            [
                $name,
                $moduleName
            ],
            $content
        );
    }
}
