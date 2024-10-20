<?php

namespace App\Tool\Presentation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Tạo một module mới theo cấu trúc ModuleName/Domain';

    public function handle()
    {
        $moduleName = $this->argument('name');
        $baseNamespace = $moduleName;

        $this->createDirectories($moduleName);
        $this->createFiles($moduleName, $baseNamespace);

        $this->info("Module $moduleName đã được tạo thành công.");
    }

    protected function createDirectories($moduleName)
    {
        $directories = [
            "app/$moduleName/Domain/Entities",
            "app/$moduleName/Domain/Repositories",
            "app/$moduleName/Application/Commands",
            "app/$moduleName/Application/Queries",
            "app/$moduleName/Infrastructure/Persistence/Models",
            "app/$moduleName/Infrastructure/Persistence/Repositories",
            "app/$moduleName/Infrastructure/Persistence/Migrations",
            "app/$moduleName/Infrastructure/Config",
            "app/$moduleName/Infrastructure/Providers",
            "app/$moduleName/Presentation/API/Routes",
            "app/$moduleName/Presentation/API/Controllers",
            "app/$moduleName/Presentation/API/Middleware",
            "app/$moduleName/Presentation/Console/Routes",
            "app/$moduleName/Presentation/Console/Controllers",
            "app/$moduleName/Presentation/Console/Middleware",
        ];

        foreach ($directories as $directory) {
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("Tạo thư mục: $directory");
            }
        }
    }

    protected function createFiles($moduleName, $namespace)
    {
        $stubFiles = [
            'api-route.stub' => "app/$moduleName/Presentation/API/Routes/api.php",
            'middleware.stub' => "app/$moduleName/Presentation/API/Middleware/{$moduleName}Middleware.php",
            'api-controller.stub' => "app/$moduleName/Presentation/API/Controllers/{$moduleName}Controller.php",
            'entity.stub' => "app/$moduleName/Domain/Entities/{$moduleName}.php",
            'repository.stub' => "app/$moduleName/Domain/Repositories/I{$moduleName}Repository.php",
            'usecase-command.stub' => "app/$moduleName/Application/Commands/Create{$moduleName}Command.php",
            'usecase-query.stub' => "app/$moduleName/Application/Queries/Get{$moduleName}Query.php",
            'eloquent-model.stub' => "app/$moduleName/Infrastructure/Persistence/Models/{$moduleName}.php",
            'infrastructure-repository.stub' => "app/$moduleName/Infrastructure/Persistence/Repositories/{$moduleName}RepositoryImpl.php",
            'migration.stub' => "app/$moduleName/Infrastructure/Persistence/Migrations/{{ timestamp }}_create_".  strtolower(Str::plural($moduleName)) ."_table.php",
            'config.stub' => "app/$moduleName/Infrastructure/Config/config.php",
            'provider.stub' => "app/$moduleName/Infrastructure/Providers/{$moduleName}ServiceProvider.php",
        ];

        foreach ($stubFiles as $stub => $file) {
            $stubPath = resource_path("stubs/$stub");
            $content = $this->getStubContent($stubPath, $moduleName, $namespace);
            if (strpos($file, 'Migrations') !== false) {
                $file = str_replace('{{ timestamp }}', now()->format('Y_m_d_His'), $file);
            }

            File::put($file, $content);
            $this->info("Tạo file: $file");
        }
    }

    protected function getStubContent($stubPath, $moduleName, $namespace)
    {
        $content = File::get($stubPath);
        return str_replace(
            ['{{ namespace }}', '{{ name }}', '{{ name_upper }}', '{{ route_prefix }}', '{{ table_name }}', '{{ fillable }}', '{{ columns }}'],
            [
                $namespace,
                $moduleName,
                strtoupper($moduleName),
                strtolower(Str::plural($moduleName)),
                strtolower(Str::plural($moduleName)),
                "'name', 'description', 'price'", // Hoặc sinh từ input
                '$table->string("name"); $table->text("description");' // Columns sinh động
            ],
            $content
        );
    }
}
