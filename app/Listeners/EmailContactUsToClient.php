<?php

namespace App\Listeners;

use App\Mail\ClientContactUs;
use App\Events\ContactUsFeedback;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailContactUsToClient
{

    /**
     * Handle the event.
     *
     * @param  ContactUsFeedback  $event
     * @return void
     */
    public function handle(ContactUsFeedback $event)
    {
        $data = $event->eloquent;

        \Mail::send(new ClientContactUs($data));
    }
}
