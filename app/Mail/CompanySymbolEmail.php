<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanySymbolEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * The data object instance.
     *
     * @var Data
     */
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@application.com')
            ->subject('Requested information about prices of ' . $this->data->symbol)
            ->view('mails.symbol_report')
            ->text('mails.symbol_report_plain')
            ->with(
                [
                    'start_date' => $this->data->start_date,
                    'end_date' => $this->data->end_date,
                ]);
    }
}
