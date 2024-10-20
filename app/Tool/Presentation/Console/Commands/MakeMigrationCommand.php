<?php

namespace App\Tool\Presentation\Console\Commands;

use App\Shared\Presentation\Console\Command\BaseCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeMigrationCommand extends BaseCommand
{
    public $signature = 'make:migration {moduleName} {tableName} {fileName}';
    public $description = 'Tạo migration cho module';

    public function handle()
    {
        // TODO: Implement handle() method.

        $moduleName = $this->argument('moduleName');
        $tableName = $this->argument('tableName');
        $migrationName = $this->argument('fileName');

        $directory = "app/$moduleName/Infrastructure/Persistence/Migrations";
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $timestamp = date('Y_m_d_His');
        $fileName = "create_$migrationName.php";
        $path = $directory . '/' . $timestamp . '_' . $fileName;
        if (!File::exists($path)) {
            File::put($path, $this->getStubContent($tableName));
            $this->info("Tạo migration: $path");
        }

    }

    protected function getStubContent($tableName): array|string
    {
        $stubPath = resource_path("stubs/migration.stub");
        $content = File::get($stubPath);
        return str_replace(
            ['{{ table_name }}'],
            [strtolower(Str::plural($tableName))],
            $content
        );
    }
}
