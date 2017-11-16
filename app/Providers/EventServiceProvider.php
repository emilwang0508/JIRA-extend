<?php

namespace App\Providers;

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
        'App\Events\Event' => [
            'App\Listeners\EventListener',
            \AtlassianConnectCore\Events\Installed::class => [
                \AtlassianConnectCore\Listeners\CreateOrUpdateTenant::class
            ],
            \AtlassianConnectCore\Events\Uninstalled::class => [
                \AtlassianConnectCore\Listeners\DeleteTenant::class
            ]
        ],
    ];
    protected $subscribe = [
        \AtlassianConnectCore\Listeners\PluginEventSubscriber::class
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
