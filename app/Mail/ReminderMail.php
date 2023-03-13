<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->data->reminder_type_id == 1) {
            return $this->subject('Reminder: ' . $this->data->title)
                ->view('emails.goal_settings')
                ->with([
                    'data' => $this->data,
                ]);
        }

        if ($this->data->reminder_type_id == 2) {
            return $this->subject('Reminder: ' . $this->data->title)
                ->view('emails.midyear_review')
                ->with([
                    'data' => $this->data,
                ]);
        }

        if ($this->data->reminder_type_id == 3) {
            return $this->subject('Reminder: ' . $this->data->title)
                ->view('emails.final_review')
                ->with([
                    'data' => $this->data,
                ]);
        } else {
            return $this->subject('Reminder: ' . $this->data->title)
                ->view('emails.goal_settings')
                ->with([
                    'data' => $this->data,
                ]);
        }
    }
}
