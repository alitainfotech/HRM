<?php

namespace App\Mail;

use App\Models\Opening;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationApply extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $details = $this->details;
        // $o_id = $this->o_id;
        $job = Opening::where('id',$details['o_id'])->first();
        $details['post']= $job['title'];
        // $application['fullname'] = $this->fullname;
        return $this->markdown('emails.application-apply')->with('data', $details);
    }
}