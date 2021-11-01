<?php

namespace App\Console\Commands;

use App\Mail\SendMailReminder;
use App\Models\Events;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class EmailReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will execute email remainder to send email to participants';

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
        $events = Events::where('event_status', 'Open')->get();
        foreach ($events as $event) {
            if(date("Y-m-d") == date("Y-m-d", strtotime("-3 days", strtotime($event->start_date)))) {
                foreach ($event->users as $user) {
                    Mail::to($user->email)->send(new SendMailReminder($event, $user));
                }
                echo "Email sent successfully";
            }
        }
    }
}
