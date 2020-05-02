<?php

namespace App\Notifications\Admin;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProductsPurchased extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * Create a new notification instance.
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    /**
     * Notify via Database
     * @param $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'type'    => 'products_purchased',
            'message' => "{$this->transaction->user->fullname} successfully purchased products. " . "Total: <strong>R" . number_format($this->transaction->amount, 2) . "</strong>",
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $mail = (new MailMessage)->subject("Products Purchased")
            ->greeting("Dear {$notifiable->firstname}")
            ->line("{$this->transaction->user->fullname} successfully purchased products.")
            ->line("&nbsp;")
            ->line("<strong>Product Details:</strong>")
            ->line("&nbsp;");

        $totalItems = 0;
        foreach ($this->transaction->products as $k => $product) {
            $totalItems += $product->pivot->quantity;
            $mail = add_product_to_mail($mail, $product)->line("&nbsp;");
        }

        //$mail->line("{$totalItems} Items Total: <strong>R" . number_format_decimal($this->transaction->amount_items) . "</strong>");
        //$mail->line("Handling Fee: <strong>R" . number_format_decimal($this->transaction->amount_handling) . "</strong>");
        //$mail->line("Subtotal: <strong>R" . number_format_decimal($this->transaction->amount_items + $this->transaction->amount_handling) . "</strong>");
        //$mail->line("Output Tax: <strong>R" . number_format_decimal($this->transaction->amount_tax) . "</strong>");
        $mail->line("<strong style='font-size: 110%;'>Grand Total: R" . number_format_decimal($this->transaction->amount) . "</strong>");

        if ($this->transaction->shippingAddress) {
            $mail->line("&nbsp;")
                ->line("Delivery Address: " . $this->transaction->shippingAddress->label);
        }

        $mail->action("View Transaction", url("/admin/shop/transactions/{$this->transaction->id}"));

        return $mail;
    }
}
