<?php

namespace App\Listeners;

use App\Notifications\ContactUsSubmitted;
use App\Events\ContactUsFeedback;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class EmailContactUsToAdmin
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

        notify_admins(ContactUsSubmitted::class, $data);

        log_activity($data->contactable->name, $data->fullname . ' submitted feedback form.', $data);
    }
}
