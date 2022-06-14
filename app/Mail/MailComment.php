<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;
class MailComment extends Mailable
{
    use Queueable, SerializesModels;

    public $comments;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $comments = $this->comments;
        $pdf = PDF::loadView('comment.commentlist',compact('comments'));
        return $this->subject('test comment')
            ->view('comment.mail')
            ->attachData($pdf->output(),'testattachment.pdf',[
                'mime'=>'application/pdf'
            ]);
    }
}
