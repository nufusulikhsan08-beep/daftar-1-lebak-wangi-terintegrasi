<?php

namespace App\Http\Controllers;

use App\Models\LandAsset;
use App\Models\School;
use App\Http\Requests\UpdateLandAssetRequest;
use Illuminate\Http\Request;

class LandAssetController extends Controller
{
    /**
     * Display the specified land asset.
     */
    public function show($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $landAsset = LandAsset::where('school_id', $schoolId)->first();

        if (!$landAsset) {
            $landAsset = new LandAsset();
            $landAsset->school_id = $schoolId;
        }

        return view('inventaris.land.show', compact('landAsset', 'school'));
    }

    /**
     * Show the form for editing the specified land asset.
     */
    public function edit($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $landAsset = LandAsset::where('school_id', $schoolId)->first();

        if (!$landAsset) {
            $landAsset = new LandAsset();
            $landAsset->school_id = $schoolId;
        }

        return view('inventaris.land.edit', compact('landAsset', 'school'));
    }

    /**
     * Update the specified land asset.
     */
    public function update(UpdateLandAssetRequest $request, $schoolId)
    {
        $validated = $request->validated();

        $landAsset = LandAsset::where('school_id', $schoolId)->first();

        if ($landAsset) {
            $landAsset->update($validated);
        } else {
            $validated['school_id'] = $schoolId;
            LandAsset::create($validated);
        }

        return redirect()->route('schools.inventaris.land.show', $schoolId)
                        ->with('success', 'Data tanah berhasil diperbarui!');
    }
}