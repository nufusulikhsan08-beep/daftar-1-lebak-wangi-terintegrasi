<?php

namespace App\Http\Controllers;

use App\Models\MonthlyReport;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Http\Requests\StoreMonthlyReportRequest;
use App\Http\Requests\UpdateMonthlyReportRequest;
use App\Services\CalculationService;
use App\Services\ReportDeadlineService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class MonthlyReportController extends Controller
{
    /**
     * Display a listing of monthly reports for a school.
     */
    public function index($schoolId, Request $request)
    {
        $school = School::findOrFail($schoolId);
        
        $query = MonthlyReport::where('school_id', $schoolId);

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $reports = $query->orderBy('year', 'desc')
                        ->orderBy('month', 'desc')
                        ->paginate(12);

        return view('reports.monthly.index', compact('reports', 'school'));
    }

    /**
     * Show the form for creating a new monthly report.
     */
    public function create($schoolId)
    {
        $school = School::findOrFail($schoolId);
        
        // Get current month and year
        $currentMonth = date('n'); // 1-12
        $currentYear = date('Y');
        
        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Check if report already exists for current month
        $existingReport = MonthlyReport::where('school_id', $schoolId)
                                        ->where('month', $months[$currentMonth - 1])
                                        ->where('year', $currentYear)
                                        ->first();

        return view('reports.monthly.create', compact('school', 'months', 'currentMonth', 'currentYear', 'existingReport'));
    }

    /**
     * Store a newly created monthly report.
     */
    public function store(StoreMonthlyReportRequest $request, $schoolId)
    {
        $validated = $request->validated();

        // Auto calculate totals using CalculationService
        $absenceTotals = CalculationService::calculateTotalAbsences((object)$validated);
        $validated = array_merge($validated, $absenceTotals);

        $validated['school_id'] = $schoolId;

        // Check if report already exists
        $existingReport = MonthlyReport::where('school_id', $schoolId)
                                        ->where('month', $validated['month'])
                                        ->where('year', $validated['year'])
                                        ->first();

        if ($existingReport) {
            $existingReport->update($validated);
            $report = $existingReport;
        } else {
            $report = MonthlyReport::create($validated);
        }

        if ($validated['status'] === 'submitted') {
            $report->update(['submitted_at' => now()]);
        }

        return redirect()->route('schools.reports.monthly.show', [$schoolId, $report->id])
                        ->with('success', 'Laporan bulanan berhasil disimpan!');
    }

    /**
     * Display the specified monthly report.
     */
    public function show($schoolId, $reportId)
    {
        $school = School::with(['principal', 'landAsset', 'buildings', 'furniture', 'facility'])->findOrFail($schoolId);
        $report = MonthlyReport::findOrFail($reportId);

        // Verify report belongs to school
        if ($report->school_id != $schoolId) {
            abort(403, 'Laporan tidak terdaftar di sekolah ini.');
        }

        // Get current student statistics
        $studentStats = Student::where('school_id', $schoolId)
                                ->where('status', 'Aktif')
                                ->select('class', 'gender', DB::raw('count(*) as total'))
                                ->groupBy('class', 'gender')
                                ->get()
                                ->groupBy('class');

        // Get teacher statistics
        $teacherStats = Teacher::where('school_id', $schoolId)
                                ->select('employment_status', DB::raw('count(*) as total'))
                                ->groupBy('employment_status')
                                ->get()
                                ->pluck('total', 'employment_status');

        $totalASN = $teacherStats['ASN'] ?? 0;
        $totalSukwan = $teacherStats['Sukwan'] ?? 0;

        // Get deadline information
        $deadlineInfo = [
            'is_overdue' => ReportDeadlineService::isReportOverdue(null, null),
            'days_remaining' => ReportDeadlineService::calculateDaysRemaining(),
            'deadline_date' => ReportDeadlineService::getReportDeadline()
        ];

        return view('reports.monthly.show', compact(
            'report',
            'school',
            'studentStats',
            'totalASN',
            'totalSukwan',
            'deadlineInfo'
        ));
    }

    /**
     * Show the form for editing the specified monthly report.
     */
    public function edit($schoolId, $reportId)
    {
        $school = School::findOrFail($schoolId);
        $report = MonthlyReport::findOrFail($reportId);

        // Verify report belongs to school
        if ($report->school_id != $schoolId) {
            abort(403, 'Laporan tidak terdaftar di sekolah ini.');
        }

        $months = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return view('reports.monthly.edit', compact('report', 'school', 'months'));
    }

    /**
     * Update the specified monthly report.
     */
    public function update(UpdateMonthlyReportRequest $request, $schoolId, $reportId)
    {
        $report = MonthlyReport::findOrFail($reportId);

        // Verify report belongs to school
        if ($report->school_id != $schoolId) {
            abort(403, 'Laporan tidak terdaftar di sekolah ini.');
        }

        $validated = $request->validated();

        // Auto calculate totals using CalculationService
        $absenceTotals = CalculationService::calculateTotalAbsences((object)$validated);
        $validated = array_merge($validated, $absenceTotals);

        $report->update($validated);

        if ($validated['status'] === 'submitted' && !$report->submitted_at) {
            $report->update(['submitted_at' => now()]);
        }

        return redirect()->route('schools.reports.monthly.show', [$schoolId, $reportId])
                        ->with('success', 'Laporan bulanan berhasil diperbarui!');
    }

    /**
     * Submit the report to dinas.
     */
    public function submit($schoolId, $reportId)
    {
        $report = MonthlyReport::findOrFail($reportId);

        if ($report->school_id != $schoolId) {
            abort(403, 'Laporan tidak terdaftar di sekolah ini.');
        }

        $report->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return redirect()->route('schools.reports.monthly.show', [$schoolId, $reportId])
                        ->with('success', 'Laporan berhasil dikirim ke Dinas Pendidikan!');
    }

    /**
     * Generate PDF Daftar 1.
     */
    public function generatePDF($schoolId, $reportId)
    {
        $school = School::with(['principal', 'landAsset', 'buildings', 'furniture', 'facility'])->findOrFail($schoolId);
        $report = MonthlyReport::findOrFail($reportId);

        if ($report->school_id != $schoolId) {
            abort(403, 'Laporan tidak terdaftar di sekolah ini.');
        }

        // Get current student statistics
        $studentStats = Student::where('school_id', $schoolId)
                                ->where('status', 'Aktif')
                                ->select('class', 'gender', DB::raw('count(*) as total'))
                                ->groupBy('class', 'gender')
                                ->get()
                                ->groupBy('class');

        // Get teacher statistics
        $teachers = Teacher::where('school_id', $schoolId)->get();
        $totalASN = $teachers->where('employment_status', 'ASN')->count();
        $totalSukwan = $teachers->where('employment_status', 'Sukwan')->count();

        // Load view and convert to PDF
        $pdf = PDF::loadView('reports.monthly.pdf', compact(
            'report', 
            'school', 
            'studentStats', 
            'teachers', 
            'totalASN', 
            'totalSukwan'
        ));

        $pdf->setPaper('a4', 'portrait');

        // Download or stream
        return $pdf->download('DAFTAR_1_' . $school->name . '_' . $report->month . '_' . $report->year . '.pdf');
    }

    /**
     * Admin: Approve monthly report.
     */
    public function approve($reportId)
    {
        $report = MonthlyReport::findOrFail($reportId);

        $report->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.reports.monthly.index')
                        ->with('success', 'Laporan berhasil disetujui!');
    }

    /**
     * Send reminder to a specific school
     */
    public function sendReminder($schoolId)
    {
        $school = School::findOrFail($schoolId);

        // Get users from the school who can receive reminders
        $users = $school->users()->whereIn('role', ['kepala_sekolah', 'operator'])->get();

        $sentCount = 0;
        foreach ($users as $user) {
            if ($user->is_active) {
                $daysRemaining = ReportDeadlineService::calculateDaysRemaining();
                $user->notify(new \App\Notifications\MonthlyReportReminder($daysRemaining));
                $sentCount++;
            }
        }

        return redirect()->back()->with('success', "Berhasil mengirim {$sentCount} pengingat ke sekolah {$school->name}");
    }

    /**
     * Admin: Get all reports for monitoring.
     */
    public function adminIndex(Request $request)
    {
        $query = MonthlyReport::with(['school'])->orderBy('year', 'desc')->orderBy('month', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        $reports = $query->paginate(20);

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Admin: Generate consolidated report for all schools.
     */
    public function adminConsolidatedReport(Request $request)
    {
        $request->validate([
            'month' => 'required|in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $reports = MonthlyReport::with(['school'])
                                ->where('month', $request->month)
                                ->where('year', $request->year)
                                ->where('status', 'approved')
                                ->get();

        // Consolidate data
        $consolidated = [
            'total_schools' => $reports->count(),
            'total_students' => 0,
            'total_teachers_asn' => 0,
            'total_teachers_sukwan' => 0,
            'total_absent_students' => 0,
            'total_absent_teachers' => 0,
        ];

        foreach ($reports as $report) {
            $school = $report->school;
            $studentCount = Student::where('school_id', $school->id)->where('status', 'Aktif')->count();
            $teacherASN = Teacher::where('school_id', $school->id)->where('employment_status', 'ASN')->count();
            $teacherSukwan = Teacher::where('school_id', $school->id)->where('employment_status', 'Sukwan')->count();

            $consolidated['total_students'] += $studentCount;
            $consolidated['total_teachers_asn'] += $teacherASN;
            $consolidated['total_teachers_sukwan'] += $teacherSukwan;
            $consolidated['total_absent_students'] += $report->student_absent_total;
            $consolidated['total_absent_teachers'] += ($report->teacher_absent_total + $report->non_pns_absent_total);
        }

        return view('admin.reports.consolidated', compact('consolidated', 'reports', 'request'));
    }
}