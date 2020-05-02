<?php

namespace App\Events;

use App\Models\FeedbackContactUs;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ContactUsFeedback
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     * @param FeedbackContactUs $row
     * @return void
     */
    public function __construct(FeedbackContactUs $row)
    {
        $row->type = 'Contact Us';
        $this->eloquent = $row;

        log_activity('Contact Us', "{$row->fullname} submitted a contact us.", $row);
    }

}
