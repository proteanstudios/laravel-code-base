<?php

namespace Pros\CodeBase\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RemoseMakeCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'make:remose {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Model and Repository and Service classes';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $factory = Str::studly($this->argument('name'));
        
        $this->call('make:repo', ['name' => "{$factory}Repository"]);
        $this->call('make:service', ['name' => "{$factory}Service"]);
        $this->call('make:model', ['name' => $factory]);
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory()
    {
        $factory = Str::studly($this->argument('name'));

        $this->call('make:factory', [
            'name'    => "{$factory}Factory",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }
}
