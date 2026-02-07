<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\MonthlyReport;
use App\Services\CalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Statistics
        $totalSchools = School::count();
        $totalStudents = Student::where('status', 'Aktif')->count();
        $totalTeachers = Teacher::count();
        
        // Schools by Status
        $schoolsByStatus = School::select('status', DB::raw('count(*) as total'))
                                  ->groupBy('status')
                                  ->get()
                                  ->pluck('total', 'status');
        
        // Monthly Reports Statistics
        $currentMonth = date('n');
        $currentYear = date('Y');
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $currentMonthName = $months[$currentMonth - 1];
        
        $reportsThisMonth = MonthlyReport::where('month', $currentMonthName)
                                          ->where('year', $currentYear)
                                          ->count();
        
        $reportsByStatus = MonthlyReport::where('month', $currentMonthName)
                                         ->where('year', $currentYear)
                                         ->select('status', DB::raw('count(*) as total'))
                                         ->groupBy('status')
                                         ->get()
                                         ->pluck('total', 'status');
        
        // Top 5 Schools by Student Count
        $topSchools = School::withCount(['students' => function($query) {
            $query->where('status', 'Aktif');
        }])
        ->orderBy('students_count', 'desc')
        ->limit(5)
        ->get();
        
        // Recent Reports
        $recentReports = MonthlyReport::with(['school'])
                                       ->orderBy('created_at', 'desc')
                                       ->limit(10)
                                       ->get();
        
        // Compliance Rate
        $totalSchoolsReporting = MonthlyReport::where('month', $currentMonthName)
                                               ->where('year', $currentYear)
                                               ->distinct('school_id')
                                               ->count('school_id');
        
        $complianceRate = $totalSchools > 0 ? round(($totalSchoolsReporting / $totalSchools) * 100, 2) : 0;
        
        return view('admin.dashboard.index', compact(
            'totalSchools',
            'totalStudents',
            'totalTeachers',
            'schoolsByStatus',
            'reportsThisMonth',
            'reportsByStatus',
            'topSchools',
            'recentReports',
            'complianceRate',
            'currentMonthName',
            'currentYear'
        ));
    }
    
    /**
     * Get monitoring data for chart
     */
    public function getMonitoringData()
    {
        $currentYear = date('Y');
        $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                   'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        $data = [];
        
        foreach ($months as $month) {
            $submitted = MonthlyReport::where('month', $month)
                                      ->where('year', $currentYear)
                                      ->where('status', 'submitted')
                                      ->count();
            
            $approved = MonthlyReport::where('month', $month)
                                     ->where('year', $currentYear)
                                     ->where('status', 'approved')
                                     ->count();
            
            $data[] = [
                'month' => $month,
                'submitted' => $submitted,
                'approved' => $approved
            ];
        }
        
        return response()->json($data);
    }
    
    /**
     * School detail view for admin
     */
    public function schoolDetail($schoolId)
    {
        $school = School::with([
            'principal',
            'teachers',
            'students' => function($query) {
                $query->where('status', 'Aktif');
            },
            'landAsset',
            'buildings',
            'furniture',
            'facility',
            'monthlyReports' => function($query) {
                $query->orderBy('year', 'desc')->orderBy('month', 'desc')->limit(6);
            }
        ])->findOrFail($schoolId);

        // Use CalculationService to get student statistics
        $studentStats = CalculationService::calculateStudentStatistics($schoolId);

        // Teacher statistics
        $teacherStats = Teacher::where('school_id', $schoolId)
                                ->select('employment_status', DB::raw('count(*) as total'))
                                ->groupBy('employment_status')
                                ->get()
                                ->pluck('total', 'employment_status');

        return view('admin.schools.detail', compact('school', 'studentStats', 'teacherStats'));
    }

    /**
     * Send reminders to all schools that haven't submitted reports
     */
    public function sendAllReminders()
    {
        $sentCount = \App\Services\ReportDeadlineService::sendRemindersByMonthEnd();

        return redirect()->back()->with('success', "Berhasil mengirim {$sentCount} pengingat ke semua sekolah yang belum melapor.");
    }
}