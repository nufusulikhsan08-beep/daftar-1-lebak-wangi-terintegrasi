<?php

namespace App\Http\Controllers;

use App\Models\Principal;
use App\Models\School;
use App\Http\Requests\UpdatePrincipalRequest;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    /**
     * Display the specified principal.
     */
    public function show($schoolId)
    {
        $principal = Principal::where('school_id', $schoolId)->firstOrFail();
        $school = School::findOrFail($schoolId);

        return view('principals.show', compact('principal', 'school'));
    }

    /**
     * Show the form for editing the specified principal.
     */
    public function edit($schoolId)
    {
        $principal = Principal::where('school_id', $schoolId)->firstOrFail();
        $school = School::findOrFail($schoolId);

        return view('principals.edit', compact('principal', 'school'));
    }

    /**
     * Update the specified principal.
     */
    public function update(UpdatePrincipalRequest $request, $schoolId)
    {
        $principal = Principal::where('school_id', $schoolId)->firstOrFail();

        $validated = $request->validated();

        $principal->update($validated);

        return redirect()->route('schools.show', $schoolId)
                        ->with('success', 'Data Kepala Sekolah berhasil diperbarui!');
    }
}