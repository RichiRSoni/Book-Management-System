<?php

namespace App\Mail;

use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $items;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    
    public function __construct($items)
    {
        $this->items=$items;
       // $this->orderItem=$orderItem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('emails.order-mail', $this->items);
        return $this->subject('Order Confirmation')->view('emails.order-mail')->attachData($this->pdf,'order_confirmation.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
