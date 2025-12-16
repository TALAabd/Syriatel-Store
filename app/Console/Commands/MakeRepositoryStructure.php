<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeRepositoryStructure extends Command
{
    protected $signature = 'make:repository-structure {name}';
    protected $description = 'Create Interface and Repository classes for a given module';

    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $interfaceDir = app_path('Interfaces');
        $repositoryDir = app_path('Repositories');

        if (!File::exists($interfaceDir)) {
            File::makeDirectory($interfaceDir);
        }
        if (!File::exists($repositoryDir)) {
            File::makeDirectory($repositoryDir);
        }

        $interfacePath = "{$interfaceDir}/{$name}RepositoryInterface.php";
        $repositoryPath = "{$repositoryDir}/{$name}Repository.php";

        // Interface Template
        $interfaceContent = <<<PHP
        <?php

        namespace App\Interfaces;

        interface {$name}RepositoryInterface
        {
            public function all();
            public function find(\$id);
            public function create(array \$data);
            public function update(\$id, array \$data);
            public function delete(\$id);
        }
        PHP;

        // Repository Template
        $repositoryContent = <<<PHP
        <?php

        namespace App\Repositories;

        use App\Interfaces\\{$name}RepositoryInterface;
        use App\Models\\{$name};

        class {$name}Repository implements {$name}RepositoryInterface
        {
            public function all()
            {
                return {$name}::latest()->get();
            }

            public function find(\$id)
            {
                return {$name}::findOrFail(\$id);
            }

            public function create(array \$data)
            {
                return {$name}::create(\$data);
            }

            public function update(\$id, array \$data)
            {
                \$model = {$name}::findOrFail(\$id);
                \$model->update(\$data);
                return \$model;
            }

            public function delete(\$id)
            {
                \$model = {$name}::findOrFail(\$id);
                return \$model->delete();
            }
        }
        PHP;

        File::put($interfacePath, $interfaceContent);
        File::put($repositoryPath, $repositoryContent);

        $this->info("✅ Created: {$interfacePath}");
        $this->info("✅ Created: {$repositoryPath}");
    }
}
