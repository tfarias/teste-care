<?php

namespace LaravelMetronic\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
		'Illuminate\Auth\Events\Login'  => [
            'LaravelMetronic\Events\UsuarioEventHandler@onLogin',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'LaravelMetronic\Events\UsuarioEventHandler@onLogout',
        ],
        'LaravelMetronic\Events\Event' => [
            'LaravelMetronic\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
