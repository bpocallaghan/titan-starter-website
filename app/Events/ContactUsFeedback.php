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
        $row->type = $row->contactable_name;
        $this->eloquent = $row;

        log_activity($row->contactable_name, "{$row->fullname} submitted a feedback form.", $row);
    }

}
