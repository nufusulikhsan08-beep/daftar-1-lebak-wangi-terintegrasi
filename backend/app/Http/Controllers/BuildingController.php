<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\School;
use App\Http\Requests\UpdateBuildingRequest;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of buildings for a school.
     */
    public function index($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $buildings = Building::where('school_id', $schoolId)->get();

        // Default building types if not exists
        $defaultTypes = [
            'Ruang Kelas',
            'Ruang Dinas Kepala',
            'Ruang Dinas Guru',
            'Ruang Dinas Penjaga',
            'Ruang Guru',
            'Perpustakaan',
            'Ruang Ibadah',
            'Ruang UKS',
        ];

        // Create default buildings if none exists
        if ($buildings->count() == 0) {
            foreach ($defaultTypes as $type) {
                Building::create([
                    'school_id' => $schoolId,
                    'room_type' => $type,
                    'quantity' => 0,
                ]);
            }
            $buildings = Building::where('school_id', $schoolId)->get();
        }

        return view('inventaris.buildings.index', compact('buildings', 'school'));
    }

    /**
     * Show the form for editing the specified building.
     */
    public function edit($schoolId, $buildingId)
    {
        $school = School::findOrFail($schoolId);
        $building = Building::findOrFail($buildingId);

        // Verify building belongs to school
        if ($building->school_id != $schoolId) {
            abort(403, 'Bangunan tidak terdaftar di sekolah ini.');
        }

        return view('inventaris.buildings.edit', compact('building', 'school'));
    }

    /**
     * Update the specified building.
     */
    public function update(UpdateBuildingRequest $request, $schoolId, $buildingId)
    {
        $building = Building::findOrFail($buildingId);

        // Verify building belongs to school
        if ($building->school_id != $schoolId) {
            abort(403, 'Bangunan tidak terdaftar di sekolah ini.');
        }

        $validated = $request->validated();

        $building->update($validated);

        return redirect()->route('schools.inventaris.buildings.index', $schoolId)
                        ->with('success', 'Data bangunan berhasil diperbarui!');
    }

    /**
     * Update all buildings at once (bulk update).
     */
    public function updateBulk(Request $request, $schoolId)
    {
        $validated = $request->validate([
            'buildings' => 'required|array',
        ]);

        foreach ($validated['buildings'] as $buildingId => $data) {
            $building = Building::findOrFail($buildingId);
            
            if ($building->school_id != $schoolId) {
                continue;
            }

            $building->update([
                'quantity' => $data['quantity'] ?? 0,
                'condition_non_standard' => $data['condition_non_standard'] ?? 0,
                'condition_good' => $data['condition_good'] ?? 0,
                'condition_light_damage' => $data['condition_light_damage'] ?? 0,
                'condition_medium_damage' => $data['condition_medium_damage'] ?? 0,
                'condition_heavy_damage' => $data['condition_heavy_damage'] ?? 0,
                'age_le_6' => $data['age_le_6'] ?? 0,
                'age_7' => $data['age_7'] ?? 0,
                'age_8' => $data['age_8'] ?? 0,
                'age_9' => $data['age_9'] ?? 0,
                'age_10' => $data['age_10'] ?? 0,
                'age_11' => $data['age_11'] ?? 0,
                'age_12' => $data['age_12'] ?? 0,
                'age_ge_13' => $data['age_ge_13'] ?? 0,
            ]);
        }

        return redirect()->route('schools.inventaris.buildings.index', $schoolId)
                        ->with('success', 'Data bangunan berhasil diperbarui!');
    }
}