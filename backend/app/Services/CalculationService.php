<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\MonthlyReport;
use Carbon\Carbon;

class CalculationService
{
    /**
     * Auto calculate teacher's work experience based on dates
     */
    public static function calculateTeacherExperience($teacher)
    {
        $data = [];
        
        // Calculate MK di Sekolah
        if ($teacher->tmt_school) {
            $tmtSchool = Carbon::parse($teacher->tmt_school);
            $now = Carbon::now();
            $diff = $now->diff($tmtSchool);
            
            $data['mk_school_years'] = $diff->y;
            $data['mk_school_months'] = $diff->m;
        }
        
        // Calculate MK Seluruh (from TMT PNS)
        if ($teacher->tmt_pns) {
            $tmtPns = Carbon::parse($teacher->tmt_pns);
            $now = Carbon::now();
            $diff = $now->diff($tmtPns);
            
            $data['mk_total_years'] = $diff->y;
            $data['mk_total_months'] = $diff->m;
        }
        
        // Calculate MK Golongan
        if ($teacher->tmt_golongan) {
            $tmtGolongan = Carbon::parse($teacher->tmt_golongan);
            $now = Carbon::now();
            $diff = $now->diff($tmtGolongan);
            
            $data['mk_golongan_years'] = $diff->y;
            $data['mk_golongan_months'] = $diff->m;
        }
        
        return $data;
    }
    
    /**
     * Calculate student statistics per class and gender
     */
    public static function calculateStudentStatistics($schoolId)
    {
        $stats = Student::where('school_id', $schoolId)
                        ->where('status', 'Aktif')
                        ->select('class', 'gender', \DB::raw('count(*) as total'))
                        ->groupBy('class', 'gender')
                        ->get()
                        ->groupBy('class');
        
        // Initialize all classes
        $kelasList = ['I', 'II', 'III', 'IV', 'V', 'VI'];
        $result = [];
        
        foreach ($kelasList as $kelas) {
            $result[$kelas] = [
                'L' => 0,
                'P' => 0,
                'total' => 0
            ];
            
            if (isset($stats[$kelas])) {
                foreach ($stats[$kelas] as $item) {
                    $result[$kelas][$item->gender] = $item->total;
                    $result[$kelas]['total'] += $item->total;
                }
            }
        }
        
        return $result;
    }
    
    /**
     * Calculate total absences
     */
    public static function calculateTotalAbsences($report)
    {
        $data = [];
        
        // Student absences
        $data['student_absent_total'] = 
            ($report->student_absent_sick ?? 0) + 
            ($report->student_absent_permit ?? 0) + 
            ($report->student_absent_alpha ?? 0);
        
        // Teacher absences
        $data['teacher_absent_total'] = 
            ($report->teacher_absent_sick ?? 0) + 
            ($report->teacher_absent_permit ?? 0) + 
            ($report->teacher_absent_alpha ?? 0);
        
        // Non-PNS absences
        $data['non_pns_absent_total'] = 
            ($report->non_pns_absent_sick ?? 0) + 
            ($report->non_pns_absent_permit ?? 0) + 
            ($report->non_pns_absent_alpha ?? 0);
        
        return $data;
    }
    
    /**
     * Validate report completeness before submission
     */
    public static function validateReportCompleteness($schoolId, $month, $year)
    {
        $errors = [];
        
        // Check if school data is complete
        $school = \App\Models\School::with(['principal', 'landAsset', 'buildings', 'furniture'])->find($schoolId);
        
        if (!$school->principal || empty($school->principal->name)) {
            $errors[] = 'Data Kepala Sekolah belum lengkap.';
        }
        
        if (!$school->landAsset) {
            $errors[] = 'Data Tanah belum diisi.';
        }
        
        if ($school->buildings->count() == 0) {
            $errors[] = 'Data Bangunan belum diisi.';
        }
        
        if ($school->furniture->count() == 0) {
            $errors[] = 'Data Perkakas belum diisi.';
        }
        
        // Check if teachers exist
        $teacherCount = Teacher::where('school_id', $schoolId)->count();
        if ($teacherCount == 0) {
            $errors[] = 'Belum ada data guru.';
        }
        
        // Check if students exist
        $studentCount = Student::where('school_id', $schoolId)->where('status', 'Aktif')->count();
        if ($studentCount == 0) {
            $errors[] = 'Belum ada data siswa aktif.';
        }
        
        return $errors;
    }
    
    /**
     * Generate report summary
     */
    public static function generateReportSummary($reportId)
    {
        $report = MonthlyReport::with(['school'])->findOrFail($reportId);
        $school = $report->school;
        
        $summary = [
            'school_name' => $school->name,
            'period' => $report->month . ' ' . $report->year,
            'total_students' => Student::where('school_id', $school->id)->where('status', 'Aktif')->count(),
            'total_teachers' => Teacher::where('school_id', $school->id)->count(),
            'total_teachers_asn' => Teacher::where('school_id', $school->id)->where('employment_status', 'ASN')->count(),
            'total_teachers_sukwan' => Teacher::where('school_id', $school->id)->where('employment_status', 'Sukwan')->count(),
            'student_absences' => $report->student_absent_total,
            'teacher_absences' => $report->teacher_absent_total + $report->non_pns_absent_total,
            'effective_days' => $report->effective_days,
            'attendance_rate' => $report->effective_days > 0 ? round((($report->effective_days - ($report->student_absent_total / max(1, $report->effective_days))) / $report->effective_days) * 100, 2) : 0,
        ];
        
        return $summary;
    }
}