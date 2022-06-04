<?php

namespace App\Mail;

use App\Models\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendNewProductMail extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $message;
    private $total;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $name, $message, $total)
    {
        $this->name = $name;
        $this->message = $message;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject(ucfirst(__('new_articles_bought')))
        ->markdown('emails.order.confirmUser', [
            'name' => $this->name,
            'message' => $this->message,
            'total' => $this->total
        ]);
    }
}
