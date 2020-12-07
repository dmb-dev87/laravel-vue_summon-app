<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Event;
use App\Summon;
use Carbon\Carbon;

class SummonOfTheCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'summon:calendar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to contacts at the indicated time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now_dt = Carbon::now();
        $now_dt = Carbon::parse($now_dt)->format('Y-m-d H:i:00');

        $send_dt = Carbon::now()->addMinutes(15);
        $send_dt = Carbon::parse($send_dt)->format('Y-m-d H:i:00');

        $events = Event::where('start_date', '=', $send_dt)->get();

        foreach($events as $event)
        {
            $summon = new Summon;

            $summon->user_id = $event->user_id;
            $summon->location_id = $event->location_id;
            $summon->contact_list = $event->contact_list;
            $summon->group_list = $event->group_list;
            $summon->start_date = $send_dt;
            $summon->end_date = $event->start_date;
            $summon->message = $event->message;
            $summon->is_sent = false;

            $summon->save();
        }
    }
}
