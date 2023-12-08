<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\SessionAboutToEnd ;
class ExpirySessionHandler implements ShouldQueue
{
     use InteractsWithQueue;
    public $loggedUser  = LoginUsers::class;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SessionAboutToEnd $event)
    {
    }
}
