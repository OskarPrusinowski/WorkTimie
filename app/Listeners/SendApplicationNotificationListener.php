<?php

namespace App\Listeners;

use App\Events\ApplicationCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendApplicationNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ApplicationCreatedEvent  $event
     * @return void
     */
    public function handle(ApplicationCreatedEvent $event)
    {
        //
    }
}
