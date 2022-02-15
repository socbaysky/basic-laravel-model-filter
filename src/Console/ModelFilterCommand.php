<?php

namespace Vitti\LaravelModelFilter\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class ModelFilterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter
                    {model : What model want to create filter}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic Query Filter for your Model';

    protected $modelClassName = '';
    protected $modelColumns = [];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $model = $this->argument('model');
        $this->modelClassName = $this->getClassName('App\\' . $model);

        $this->info("model class name: " . $this->modelClassName);

        $this->info($model);

        if($this->checkModelExists($model)) {
            $this->getColumnFromModel();

            $this->ensureDirectoriesExists();

            $this->exportBackend();
    
            $this->info('Model Filter generated successfully.');
        }
    }

    protected function getClassName($class) {
        $class = explode("\\",get_class(new $class()));
        return $class[count($class) - 1];

    }

    /**
     * Check model input exists
     *
     * @return void
     */
    protected function checkModelExists($model) {
        if (! is_file($path = app_path($model . '.php'))) {
            $this->error("Your model input not exists!");
            return false;
        }
        return true;
    }

    /**
     * Export the authentication backend.
     *
     * @return void
     */
    protected function exportBackend()
    {
        if(!$this->checkQueryFilterExists()) {
            file_put_contents(
                app_path('Filters/QueryFilter.php'),
                $this->compileQueryFilterStub()
            );
        }
        if(!$this->checkFilterableExists()) {
            file_put_contents(
                app_path('Traits/Filterable.php'),
                $this->compileFilterableTraitStub()
            );
        }

        if(!$this->checkModelFilterExists()) {
            file_put_contents(
                app_path('Filters/'. $this->modelClassName .'Filter.php'),
                $this->compileModelFilterStub()
            );
        }
    }

    private function checkModelFilterExists() {
        if (! is_file($path = app_path('Filters' . $this->argument('model') . 'Filter.php'))) {
            return false;
        }
        $this->error("Error: Filters\\" . $this->modelClassName . " exists!");
        return true;
    }

    private function checkQueryFilterExists() {
        if (! is_file($path = app_path('Filters/QueryFilter.php'))) {
            return false;
        }
        $this->error("Error: Filters/QueryFilter.php exists!");
        return true;
    }

    private function checkFilterableExists() {
        if (! is_file($path = app_path('Traits/Filterable.php'))) {
            return false;
        }
        $this->error("Error: Traits/Filterable.php exists!");
        return true;
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function ensureDirectoriesExists()
    {
        if (! is_dir($directory = app_path('Filters'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path('Traits'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Compiles the "Filterable" stub.
     *
     * @return string
     */
    protected function compileFilterableTraitStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->laravel->getNamespace(),
            file_get_contents(__DIR__.'/stubs/traits/Filterable.stub')
        );
    }

    /**
     * Compiles the "QueryFilter" stub.
     *
     * @return string
     */
    protected function compileQueryFilterStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->laravel->getNamespace(),
            file_get_contents(__DIR__.'/stubs/filters/QueryFilter.stub')
        );
    }

    protected function compileModelFilterStub()
    {
        // replace namespace
        $modelFilter = str_replace(
            '{{namespace}}',
            $this->laravel->getNamespace(),
            file_get_contents(__DIR__.'/stubs/filters/ModelFilter.stub')
        );

        // replace model_name
        $modelFilter = str_replace(
            '{{model_name}}',
            $this->modelClassName,
            $modelFilter
        );

        // replace filterable_column
        $modelFilter = str_replace(
            '{{filterable_column}}',
            "'" . implode("', '", $this->modelColumns) . "'",
            $modelFilter
        );

        // build model_method
        $modelFilter = str_replace(
            '{{filter_method}}',
            $this->compileModelMethodStub(),
            $modelFilter
        );

        return $modelFilter;
    }

    // Get column name from model in db
    protected function getColumnFromModel() {
        try {
            $class = 'App\\' . $this->argument('model');
            $model = new $class();
            $columns = Schema::getColumnListing($model->getTable());
            $this->modelColumns = $columns;
             
        } catch (\Throwable $th) {
            $this->error($class);
            throw new \Exception("Error class model!");
        }
        
    }

    protected function compileModelMethodStub() {
        $modelMethod = '';
        foreach ($this->modelColumns as $key => $column) {
            if($key == 0) {
                $modelMethod = str_replace(
                    '{{column_name_upper}}',
                    ucfirst($column),
                    file_get_contents(__DIR__.'/stubs/filters/FilterMethod.stub')
                );
            }
            $modelMethod .= str_replace(
                '{{column_name}}',
                $column,
                $modelMethod
            );
        }

        // $this->info($modelMethod);
        return $modelMethod;
    }
}
