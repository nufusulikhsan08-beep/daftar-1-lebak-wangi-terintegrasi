<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\MonthlyReportReminder;
use App\Services\ReportDeadlineService;
use Carbon\Carbon;

class SendMonthlyReportReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:send-reminders {--days-ahead=3 : Number of days before deadline to send reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to schools about monthly report deadlines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $daysAhead = $this->option('days-ahead');

        // Use the ReportDeadlineService to send reminders
        $sentCount = ReportDeadlineService::sendReminders($daysAhead);

        $this->info("Successfully sent {$sentCount} reminder notifications.");
    }
}