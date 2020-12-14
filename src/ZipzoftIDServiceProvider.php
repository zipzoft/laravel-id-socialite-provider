<?php

namespace Zipzoft\ID;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ZipzoftIDServiceProvider extends ServiceProvider
{
    /**
     * Register extended socialite provider
     *
     * @var \string[][]
     */
    protected $events = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            //
        ]
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->events as $event => $listeners) {
            foreach (array_unique($listeners) as $listener) {
                Event::listen($event, $listener);
            }
        }
    }
}
