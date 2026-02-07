<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\School;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\CalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /**
     * Display a listing of students by class for a school.
     */
    public function index($schoolId, Request $request)
    {
        $school = School::findOrFail($schoolId);
        
        $class = $request->get('class', 'I'); // Default class I
        $status = $request->get('status', 'Aktif');

        $students = Student::where('school_id', $schoolId)
                            ->where('class', $class)
                            ->where('status', $status)
                            ->orderBy('name')
                            ->paginate(30);

        // Get statistics per class
        $classStats = Student::where('school_id', $schoolId)
                            ->where('status', 'Aktif')
                            ->select('class', 'gender', DB::raw('count(*) as total'))
                            ->groupBy('class', 'gender')
                            ->get()
                            ->groupBy('class');

        return view('students.index', compact('students', 'school', 'class', 'classStats'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create($schoolId)
    {
        $school = School::findOrFail($schoolId);
        return view('students.create', compact('school'));
    }

    /**
     * Store a newly created student.
     */
    public function store(StoreStudentRequest $request, $schoolId)
    {
        $validated = $request->validated();
        $validated['school_id'] = $schoolId;

        Student::create($validated);

        return redirect()->route('schools.students.index', $schoolId)
                        ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    /**
     * Display the specified student.
     */
    public function show($schoolId, $studentId)
    {
        $school = School::findOrFail($schoolId);
        $student = Student::findOrFail($studentId);

        // Verify student belongs to school
        if ($student->school_id != $schoolId) {
            abort(403, 'Siswa tidak terdaftar di sekolah ini.');
        }

        return view('students.show', compact('student', 'school'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit($schoolId, $studentId)
    {
        $school = School::findOrFail($schoolId);
        $student = Student::findOrFail($studentId);

        // Verify student belongs to school
        if ($student->school_id != $schoolId) {
            abort(403, 'Siswa tidak terdaftar di sekolah ini.');
        }

        return view('students.edit', compact('student', 'school'));
    }

    /**
     * Update the specified student.
     */
    public function update(UpdateStudentRequest $request, $schoolId, $studentId)
    {
        $student = Student::findOrFail($studentId);

        // Verify student belongs to school
        if ($student->school_id != $schoolId) {
            abort(403, 'Siswa tidak terdaftar di sekolah ini.');
        }

        $validated = $request->validated();

        $student->update($validated);

        return redirect()->route('schools.students.index', ['schoolId' => $schoolId, 'class' => $student->class])
                        ->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Remove the specified student.
     */
    public function destroy($schoolId, $studentId)
    {
        $student = Student::findOrFail($studentId);

        // Verify student belongs to school
        if ($student->school_id != $schoolId) {
            abort(403, 'Siswa tidak terdaftar di sekolah ini.');
        }

        $student->delete();

        return redirect()->route('schools.students.index', $schoolId)
                        ->with('success', 'Data siswa berhasil dihapus!');
    }

    /**
     * Get student statistics for dashboard
     */
    public function statistics($schoolId)
    {
        $school = School::findOrFail($schoolId);

        $totalStudents = Student::where('school_id', $schoolId)
                                ->where('status', 'Aktif')
                                ->count();

        // Use CalculationService to get detailed statistics
        $byClass = CalculationService::calculateStudentStatistics($schoolId);

        $byEconomicStatus = Student::where('school_id', $schoolId)
                                   ->where('status', 'Aktif')
                                   ->select('economic_status', DB::raw('count(*) as total'))
                                   ->groupBy('economic_status')
                                   ->get()
                                   ->pluck('total', 'economic_status');

        return response()->json([
            'total' => $totalStudents,
            'by_class' => $byClass,
            'by_economic_status' => $byEconomicStatus,
        ]);
    }

    /**
     * Mutasi siswa (pindah/keluar/dropout)
     */
    public function mutasi(Request $request, $schoolId)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'status' => 'required|in:Pindah,Dropout,Lulus',
            'exit_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $student = Student::findOrFail($request->student_id);

        if ($student->school_id != $schoolId) {
            abort(403, 'Siswa tidak terdaftar di sekolah ini.');
        }

        $student->update([
            'status' => $request->status,
            'exit_date' => $request->exit_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('schools.students.index', $schoolId)
                        ->with('success', 'Mutasi siswa berhasil dilakukan!');
    }

    /**
     * Import students from Excel
     */
    public function import(Request $request, $schoolId)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $import = new StudentsImport($schoolId);
            Excel::import($import, $file);

            return redirect()->route('schools.students.index', $schoolId)
                            ->with('success', 'Data siswa berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris " . $failure->row() . ": " . implode(", ", $failure->errors());
            }

            return redirect()->route('schools.students.index', $schoolId)
                            ->with('error', 'Gagal mengimport data siswa: ' . implode("; ", $errors));
        } catch (\Exception $e) {
            return redirect()->route('schools.students.index', $schoolId)
                            ->with('error', 'Gagal mengimport data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Export students to Excel
     */
    public function export($schoolId)
    {
        $school = School::findOrFail($schoolId);

        return Excel::download(new StudentsExport($schoolId), 'data_siswa_' . $school->name . '.xlsx');
    }

    /**
     * Show the form for importing students.
     */
    public function showImportForm($schoolId)
    {
        $school = School::findOrFail($schoolId);
        return view('students.import', compact('school'));
    }

    /**
     * Show the exported students.
     */
    public function showExportForm($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $students = Student::where('school_id', $schoolId)->get();

        return view('students.export', compact('school', 'students'));
    }
}