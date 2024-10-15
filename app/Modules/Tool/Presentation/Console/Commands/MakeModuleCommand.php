<?php

namespace App\Modules\Tool\Presentation\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Tạo một module mới theo cấu trúc ModuleName/Domains';

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
            "app/Modules/$moduleName/Domains/Entities",
            "app/Modules/$moduleName/Domains/Repositories",
            "app/Modules/$moduleName/Application/Commands",
            "app/Modules/$moduleName/Application/Queries",
            "app/Modules/$moduleName/Infrastructure/Persistence/Models",
            "app/Modules/$moduleName/Infrastructure/Persistence/Repositories",
            "app/Modules/$moduleName/Infrastructure/Persistence/Migrations",
            "app/Modules/$moduleName/Infrastructure/Config",
            "app/Modules/$moduleName/Infrastructure/Middleware",
            "app/Modules/$moduleName/Infrastructure/Providers",
            "app/Modules/$moduleName/Presentation/API/Routes",
            "app/Modules/$moduleName/Presentation/API/Controllers",
            "app/Modules/$moduleName/Presentation/Console",
            "app/Modules/$moduleName/Presentation/Task",
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
            'api-route.stub' => "app/Modules/$moduleName/Presentation/API/Routes/api.php",
            'api-controller.stub' => "app/Modules/$moduleName/Presentation/API/Controllers/{$moduleName}Controller.php",
            'entity.stub' => "app/Modules/$moduleName/Domains/Entities/{$moduleName}.php",
            'repository.stub' => "app/Modules/$moduleName/Domains/Repositories/{$moduleName}Repository.php",
            'usecase-command.stub' => "app/Modules/$moduleName/Application/Commands/Create{$moduleName}Command.php",
            'usecase-query.stub' => "app/Modules/$moduleName/Application/Queries/Get{$moduleName}Query.php",
            'middleware.stub' => "app/Modules/$moduleName/Infrastructure/Middleware/{$moduleName}Middleware.php",
            'eloquent-model.stub' => "app/Modules/$moduleName/Infrastructure/Persistence/Models/{$moduleName}.php",
            'infrastructure-repository.stub' => "app/Modules/$moduleName/Infrastructure/Persistence/Repositories/{$moduleName}RepositoryImpl.php",
            'migration.stub' => "app/Modules/$moduleName/Infrastructure/Persistence/Migrations/{{ timestamp }}_create_".  strtolower(Str::plural($moduleName)) ."_table.php",
            'config.stub' => "app/Modules/$moduleName/Infrastructure/Config/config.php",
            'provider.stub' => "app/Modules/$moduleName/Infrastructure/Providers/{$moduleName}ServiceProvider.php",
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
            ['{{ namespace }}', '{{ name }}', '{{ route_prefix }}', '{{ table_name }}', '{{ fillable }}', '{{ columns }}'],
            [
                $namespace,
                $moduleName,
                strtolower(Str::plural($moduleName)),
                strtolower(Str::plural($moduleName)),
                "'name', 'description', 'price'", // Hoặc sinh từ input
                '$table->string("name"); $table->text("description");' // Columns sinh động
            ],
            $content
        );
    }
}
