<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\MonthlyReport;
use App\Models\School;
use App\Models\User;
use App\Notifications\MonthlyReportReminder;

class ReportDeadlineService
{
    /**
     * Calculate days remaining for report submission
     */
    public static function calculateDaysRemaining($month = null, $year = null)
    {
        $currentMonth = $month ?: Carbon::now()->month;
        $currentYear = $year ?: Carbon::now()->year;

        // Assuming reports are due on the 5th of the following month
        $dueDate = Carbon::create($currentYear, $currentMonth, 5)->addMonth();

        // If we're already past the due date, calculate from today
        if ($dueDate->isPast()) {
            return 0;
        }

        return $dueDate->diffInDays();
    }

    /**
     * Get schools that haven't submitted reports
     */
    public static function getUnsubmittedReports($month = null, $year = null)
    {
        $currentMonth = $month ?: Carbon::now()->month;
        $currentYear = $year ?: Carbon::now()->year;
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $currentMonthName = $months[$currentMonth - 1];

        $schools = School::with(['users' => function($query) {
            $query->whereIn('role', ['kepala_sekolah', 'operator']);
        }])->get();

        $unsubmitted = [];

        foreach ($schools as $school) {
            $hasSubmitted = MonthlyReport::where('school_id', $school->id)
                                       ->where('month', $currentMonthName)
                                       ->where('year', $currentYear)
                                       ->where('status', 'submitted')
                                       ->exists();

            if (!$hasSubmitted) {
                $unsubmitted[] = [
                    'school' => $school,
                    'days_remaining' => self::calculateDaysRemaining($currentMonth, $currentYear),
                    'users' => $school->users
                ];
            }
        }

        return $unsubmitted;
    }

    /**
     * Send reminders to schools that haven't submitted reports
     */
    public static function sendReminders($daysThreshold = 3)
    {
        $unsubmitted = self::getUnsubmittedReports();
        $sentCount = 0;

        foreach ($unsubmitted as $item) {
            if ($item['days_remaining'] <= $daysThreshold) {
                foreach ($item['users'] as $user) {
                    if ($user->is_active) {
                        $user->notify(new MonthlyReportReminder($item['days_remaining']));
                        $sentCount++;
                    }
                }
            }
        }

        return $sentCount;
    }

    /**
     * Check if report is overdue
     */
    public static function isReportOverdue($month = null, $year = null)
    {
        $currentMonth = $month ?: Carbon::now()->month;
        $currentYear = $year ?: Carbon::now()->year;

        // Assuming reports are due on the 5th of the following month
        $dueDate = Carbon::create($currentYear, $currentMonth, 5)->addMonth();

        return $dueDate->isPast();
    }

    /**
     * Get report deadline for a specific month/year
     */
    public static function getReportDeadline($month = null, $year = null)
    {
        $currentMonth = $month ?: Carbon::now()->month;
        $currentYear = $year ?: Carbon::now()->year;

        // Reports are due on the 5th of the following month
        return Carbon::create($currentYear, $currentMonth, 5)->addMonth();
    }

    /**
     * Send reminders based on days to month end
     */
    public static function sendRemindersByMonthEnd()
    {
        $lastDayOfMonth = Carbon::now()->endOfMonth()->day;
        $today = Carbon::now()->day;
        $daysRemaining = $lastDayOfMonth - $today;

        if ($daysRemaining == 7 || $daysRemaining == 3 || $daysRemaining == 1) {
            $users = User::where('role', '!=', 'admin_dinas')
                        ->where('is_active', true)
                        ->get();

            $sentCount = 0;
            foreach ($users as $user) {
                $user->notify(new MonthlyReportReminder($daysRemaining));
                $sentCount++;
            }

            return $sentCount;
        }

        return 0;
    }

    /**
     * Send overdue notifications on 1st of month
     */
    public static function sendOverdueNotifications()
    {
        if (Carbon::now()->day == 1) {
            $users = User::where('role', '!=', 'admin_dinas')
                        ->where('is_active', true)
                        ->get();

            $sentCount = 0;
            foreach ($users as $user) {
                $user->notify(new MonthlyReportReminder(0)); // 0 means overdue
                $sentCount++;
            }

            return $sentCount;
        }

        return 0;
    }
}