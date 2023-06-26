<?php

namespace App\Listener;

use App\Events\ChatEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Event;

class ChatListener
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
     * @param  \App\Events\ChatEvent  $event
     * @return void
     */
    public function handle(ChatEvent $event)
    {
        //
    }
}
