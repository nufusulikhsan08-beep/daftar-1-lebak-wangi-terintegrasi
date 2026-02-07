<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\School;
use App\Http\Requests\UpdateFacilityRequest;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display the specified facility.
     */
    public function show($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $facility = Facility::where('school_id', $schoolId)->first();

        if (!$facility) {
            $facility = new Facility();
            $facility->school_id = $schoolId;
        }

        return view('inventaris.facilities.show', compact('facility', 'school'));
    }

    /**
     * Show the form for editing the specified facility.
     */
    public function edit($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $facility = Facility::where('school_id', $schoolId)->first();

        if (!$facility) {
            $facility = new Facility();
            $facility->school_id = $schoolId;
        }

        return view('inventaris.facilities.edit', compact('facility', 'school'));
    }

    /**
     * Update the specified facility.
     */
    public function update(UpdateFacilityRequest $request, $schoolId)
    {
        $validated = $request->validated();

        $facility = Facility::where('school_id', $schoolId)->first();

        if ($facility) {
            $facility->update($validated);
        } else {
            $validated['school_id'] = $schoolId;
            Facility::create($validated);
        }

        return redirect()->route('schools.inventaris.facilities.show', $schoolId)
                        ->with('success', 'Data fasilitas berhasil diperbarui!');
    }
}