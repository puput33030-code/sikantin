<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct($order)
    {
        $this->order=$order;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject=match($this->order->status){
            'siap'=>'Status Pesanan Anda #' . $this->order->id,
            'selesai'=>'Status Pesanan Anda #' . $this->order->id,
        };
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view=match($this->order->status){
            'siap'=>'pages.email.orderstatussiap',
            'selesai'=>'pages.email.orderstatusselesai',
        };

        return new Content(
            view: $view,
            with: [
                'order' => $this->order
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
