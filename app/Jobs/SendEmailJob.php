<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\MailComment;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comments;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //generate pdf (Situasi 1)
        Mail::to('kamalnorizan@gmail.com')
            ->send(new MailComment($this->comments));
    }
}
