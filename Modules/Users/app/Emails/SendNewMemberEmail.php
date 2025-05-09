<?php

namespace Modules\Users\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewMemberEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
	
    public function __construct(string $name)
    {
        $this->name = $name;
    }
	
    public function build(): self
    {
        return $this->view('users::mail.new_member_email', [$this->name]);
    }
}
