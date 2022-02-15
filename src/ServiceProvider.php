<?php

namespace Vitti\LaravelModelFilter;

use Vitti\LaravelModelFilter\Console\ModelFilterCommand;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(Factory $view, Dispatcher $events, Repository $config)
    {
        $this->publishCommands();
    }

    private function publishCommands(): void
    {
        $this->commands(ModelFilterCommand::class);
    }
}
