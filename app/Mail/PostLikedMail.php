<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PostLikedMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($mailData)
  {
    $this->mailData = $mailData;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $from = $this->mailData->from;
    $name = $this->mailData->name;
    $subject = $this->mailData->subject; 

    return $this->markdown('emails.post.post_liked')
      ->from($from, $name)
      ->subject($subject)
      ->with(['data' => $this->mailData->data]);
  }
}
