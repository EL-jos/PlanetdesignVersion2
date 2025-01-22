<?php

namespace App\Mail;

use App\Models\Devis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DevisSend extends Mailable
{
    use Queueable, SerializesModels;

    public $devis;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($devis, $data)
    {
        $this->devis = $devis;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.devis.send', [
            'quotes' => $this->devis,
            'data' => $this->data
        ])->subject('Nouveau devis PLANETDESIGN')
        ->from($this->devis->first()->email, $this->devis->first()->lastname .' '. $this->devis->first()->firstname);
    }
}
