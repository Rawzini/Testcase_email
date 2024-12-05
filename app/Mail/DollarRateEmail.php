<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DollarRateEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $dollarRubleRate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rate)
    {
        $this->dollarRubleRate = $rate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Курс доллара на текущий час')
                    ->view('emails.usd_rub_rate')
                    ->with(['dollarRubleRate' => $this->dollarRubleRate]);
    }
}
