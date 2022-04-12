<?php

namespace App\Mail;

use App\Models\Opening;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class application extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $post;
    public $fullname;
    public function __construct($o_id,$fullname)
    {
        $this->o_id = $o_id;
        $this->fullname = $fullname;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $o_id = $this->o_id;
        $job = Opening::where('id',$o_id)->first();
        $application['post']= $job['title'];
        $application['fullname'] = $this->fullname;
        return $this->markdown('emails.application')->with('data', $application);
    }
}
