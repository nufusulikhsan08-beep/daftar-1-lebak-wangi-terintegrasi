<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\School;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Services\CalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\TeachersExport;
use App\Imports\TeachersImport;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    /**
     * Display a listing of teachers for a school.
     */
    public function index($schoolId, Request $request)
    {
        $school = School::findOrFail($schoolId);
        
        $query = Teacher::where('school_id', $schoolId);

        // Filter by employment status
        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%')
                  ->orWhere('nuptk', 'like', '%' . $request->search . '%');
        }

        $teachers = $query->orderBy('name')->paginate(15);

        return view('teachers.index', compact('teachers', 'school'));
    }

    /**
     * Show the form for creating a new teacher.
     */
    public function create($schoolId)
    {
        $school = School::findOrFail($schoolId);
        return view('teachers.create', compact('school'));
    }

    /**
     * Store a newly created teacher.
     */
    public function store(StoreTeacherRequest $request, $schoolId)
    {
        $validated = $request->validated();
        $validated['school_id'] = $schoolId;

        // Auto-calculate masa kerja if dates provided
        if ($validated['tmt_school'] ?? null || $validated['tmt_pns'] ?? null || $validated['tmt_golongan'] ?? null) {
            $calculatedData = CalculationService::calculateTeacherExperience((object)$validated);
            $validated = array_merge($validated, $calculatedData);
        }

        Teacher::create($validated);

        return redirect()->route('schools.teachers.index', $schoolId)
                        ->with('success', 'Data guru berhasil ditambahkan!');
    }

    /**
     * Display the specified teacher.
     */
    public function show($schoolId, $teacherId)
    {
        $school = School::findOrFail($schoolId);
        $teacher = Teacher::findOrFail($teacherId);

        // Verify teacher belongs to school
        if ($teacher->school_id != $schoolId) {
            abort(403, 'Guru tidak terdaftar di sekolah ini.');
        }

        return view('teachers.show', compact('teacher', 'school'));
    }

    /**
     * Show the form for editing the specified teacher.
     */
    public function edit($schoolId, $teacherId)
    {
        $school = School::findOrFail($schoolId);
        $teacher = Teacher::findOrFail($teacherId);

        // Verify teacher belongs to school
        if ($teacher->school_id != $schoolId) {
            abort(403, 'Guru tidak terdaftar di sekolah ini.');
        }

        return view('teachers.edit', compact('teacher', 'school'));
    }

    /**
     * Update the specified teacher.
     */
    public function update(UpdateTeacherRequest $request, $schoolId, $teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        // Verify teacher belongs to school
        if ($teacher->school_id != $schoolId) {
            abort(403, 'Guru tidak terdaftar di sekolah ini.');
        }

        $validated = $request->validated();

        // Auto-calculate masa kerja if dates provided
        if ($validated['tmt_school'] ?? null || $validated['tmt_pns'] ?? null || $validated['tmt_golongan'] ?? null) {
            $calculatedData = CalculationService::calculateTeacherExperience((object)$validated);
            $validated = array_merge($validated, $calculatedData);
        }

        $teacher->update($validated);

        return redirect()->route('schools.teachers.index', $schoolId)
                        ->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Remove the specified teacher.
     */
    public function destroy($schoolId, $teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        // Verify teacher belongs to school
        if ($teacher->school_id != $schoolId) {
            abort(403, 'Guru tidak terdaftar di sekolah ini.');
        }

        $teacher->delete();

        return redirect()->route('schools.teachers.index', $schoolId)
                        ->with('success', 'Data guru berhasil dihapus!');
    }

    /**
     * Show the form for importing teachers.
     */
    public function showImportForm($schoolId)
    {
        $school = School::findOrFail($schoolId);
        return view('teachers.import', compact('school'));
    }

    /**
     * Show the exported teachers.
     */
    public function showExportForm($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $teachers = Teacher::where('school_id', $schoolId)->get();

        return view('teachers.export', compact('school', 'teachers'));
    }

    /**
     * Import teachers from Excel
     */
    public function import(Request $request, $schoolId)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $import = new TeachersImport($schoolId);
            Excel::import($import, $file);

            return redirect()->route('schools.teachers.index', $schoolId)
                            ->with('success', 'Data guru berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris " . $failure->row() . ": " . implode(", ", $failure->errors());
            }

            return redirect()->route('schools.teachers.index', $schoolId)
                            ->with('error', 'Gagal mengimport data guru: ' . implode("; ", $errors));
        } catch (\Exception $e) {
            return redirect()->route('schools.teachers.index', $schoolId)
                            ->with('error', 'Gagal mengimport data guru: ' . $e->getMessage());
        }
    }

    /**
     * Export teachers to Excel
     */
    public function export($schoolId)
    {
        $school = School::findOrFail($schoolId);

        return Excel::download(new TeachersExport($schoolId), 'data_guru_' . $school->name . '.xlsx');
    }
}