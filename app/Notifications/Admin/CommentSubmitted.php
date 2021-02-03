<?php

namespace App\Notifications\Admin;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Comment
     */
    private $comment;

    /**
     * Create a new notification instance.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)->subject('Comment')
            ->greeting("Dear {$notifiable->firstname}")
            ->line("The following information was submitted from the <strong>Comments</strong>.")
            ->line('&nbsp;')
            ->line("<strong>Comment Details</strong>");
            if(isset($this->comment->name)){
                $mail->line("Name: {$this->comment->name}");
            }
            if(isset($this->comment->email)){
                $mail->line("Email: {$this->comment->email}");
            }
            $mail->line("Comment: {$this->comment->content}")
            ->action('View / Approve Comment', url('/admin/comments/edit/'.$this->comment->id));

            return $mail;
    }

    /**
     * Notify via Database
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->comment->name . ' submitted a comment.',
            'id'      => $this->comment->id,
            'type'    => get_class($this->comment),
        ];
    }
}
