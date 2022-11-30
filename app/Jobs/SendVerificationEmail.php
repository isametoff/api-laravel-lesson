<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\EmailVerification;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new EmailVerification($this->user);
        // Mail::to('isametoff@gmail.com')->send($email);
        // Mail::from('isametoff@gmail.com');
        Mail::send(['text' => 'mail'], $email, function ($message) {
            $message->to('isametoff@gmail.com', 'Tutorials Point')->subject('Laravel Basic Testing Mail');
            $message->from('isametoff@gmail.com', 'Virat Gandhi');
        });
    }
}