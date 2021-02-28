<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RecitalPlanNotification extends Mailable
{
    use Queueable, SerializesModels;

	protected $title;
    protected $text;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title='テスト', $text='テストです。')
    {
      //$this->title = sprintf('%sさん、ありがとうございます。', $name);
      $this->title = $title;
      $this->text = $text;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->text('emails.recital_plan_notification_plain')
                    ->subject($this->title)
                    ->with([
                        'text' => $this->text,
                      ]);
    }
}
