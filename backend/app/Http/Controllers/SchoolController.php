<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Principal;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SchoolController extends Controller
{
    /**
     * Display a listing of schools.
     */
    public function index(Request $request)
    {
        $query = School::with(['principal', 'users']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('npsn', 'like', '%' . $request->search . '%');
        }

        $schools = $query->orderBy('name')->paginate(15);

        return view('schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new school.
     */
    public function create()
    {
        return view('schools.create');
    }

    /**
     * Store a newly created school.
     */
    public function store(StoreSchoolRequest $request)
    {
        $validated = $request->validated();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('schools/logos', 'public');
        }

        $school = School::create($validated);

        // Create empty principal record
        Principal::create([
            'school_id' => $school->id,
            'name' => '',
            'nip' => '',
            'nuptk' => null,
        ]);

        return redirect()->route('schools.show', $school->id)
                        ->with('success', 'Data sekolah berhasil ditambahkan!');
    }

    /**
     * Display the specified school.
     */
    public function show($id)
    {
        $school = School::with([
            'principal',
            'teachers',
            'students',
            'landAsset',
            'buildings',
            'furniture',
            'facility',
            'monthlyReports'
        ])->findOrFail($id);

        return view('schools.show', compact('school'));
    }

    /**
     * Show the form for editing the specified school.
     */
    public function edit($id)
    {
        $school = School::findOrFail($id);
        return view('schools.edit', compact('school'));
    }

    /**
     * Update the specified school.
     */
    public function update(UpdateSchoolRequest $request, $id)
    {
        $school = School::findOrFail($id);

        $validated = $request->validated();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }
            $validated['logo'] = $request->file('logo')->store('schools/logos', 'public');
        }

        $school->update($validated);

        return redirect()->route('schools.show', $school->id)
                        ->with('success', 'Data sekolah berhasil diperbarui!');
    }

    /**
     * Remove the specified school.
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id);

        // Delete logo if exists
        if ($school->logo) {
            Storage::disk('public')->delete($school->logo);
        }

        $school->delete();

        return redirect()->route('schools.index')
                        ->with('success', 'Data sekolah berhasil dihapus!');
    }

    /**
     * Get schools for dropdown/select
     */
    public function getSchoolsDropdown()
    {
        $schools = School::orderBy('name')->get(['id', 'name', 'npsn', 'status']);
        
        return response()->json($schools);
    }
}