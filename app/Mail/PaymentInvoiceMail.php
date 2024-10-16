<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Payment;

class PaymentInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $payment;
    public $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct(Payment $payment, $pdf){
        $this->payment = $payment;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this
            ->view('emails.payment_invoice')
            ->subject('Payment Invoice from Our Store')
            ->attachData($this->pdf, 'invoice.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
