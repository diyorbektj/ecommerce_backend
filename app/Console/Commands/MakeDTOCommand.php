<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeDTOCommand extends GeneratorCommand
{
    protected $signature = 'make:dto {name}';

    protected $description = 'Generate a DTO class';

    public function handle()
    {
        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($name);

        if ((! $this->hasOption('force') || ! $this->option('force')) && $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }
        $this->makeDirectory($path);
        $this->files->put($path, $this->sortImports($this->buildClass($name)));
        $this->info($this->type.' created successfully.');

        return 0;
    }

    protected function getStub()
    {
        return $this->resolveStubPath('stubs/dto.stub');
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\DTO';
    }

    protected function resolveStubPath(string $stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }
}
