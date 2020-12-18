<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Contact;
use App\Summon;
use App\History;
use App\User;

class SummonMail extends Mailable
{
    use Queueable, SerializesModels;

    public Contact $contact;
    public Summon $summon;
    public User $user;
    public $history;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, Summon $summon, User $user, $history)
    {
        //
        $this->contact = $contact;
        $this->summon = $summon;
        $this->user = $user;
        $this->history_id = $history_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $location_name = $this->summon->location->name;
        $due_date_str = date("d/m/Y h:i A", strtotime($this->summon->end_date));
        $action_url = url('/summon/mail-response/', $this->history_id);

        return $this->from($this->user->email)
                    ->markdown('emails.summon', 
                        [
                            'location_name' => $location_name, 
                            'due_datetime' => $due_date_str, 
                            'action_url' => $action_url
                        ]
                    );
    }
}
