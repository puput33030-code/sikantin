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
            'pending'=>'Status Pesanan Anda #' . $this->order->id . ' sedang menunggu konfirmasi',
            'diproses'=>'Status Pesanan Anda #' . $this->order->id . ' sedang diproses',
            'siap'=>'Status Pesanan Anda #' . $this->order->id . ' siap',
            'selesai'=>'Status Pesanan Anda #' . $this->order->id . ' selesai',
            'dibatalkan'=>'Status Pesanan Anda #' . $this->order->id . ' dibatalkan',
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
            'pending'=>'pages.email.orderstatuspending',
            'diproses'=>'pages.email.orderstatusdiproses',
            'siap'=>'pages.email.orderstatussiap',
            'selesai'=>'pages.email.orderstatusselesai',
            'dibatalkan'=>'pages.email.orderstatusdibatalkan',
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
