<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $password;
    public function __construct($email,$password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['email'] = $this->email;
        $data['password'] = $this->password;
        $user = Admin::where('email',$data['email'])->first();
        $data['fullname'] = $user->full_name;
        return $this->markdown('emails.PasswordReset')->with('data',$data);
    }
}
