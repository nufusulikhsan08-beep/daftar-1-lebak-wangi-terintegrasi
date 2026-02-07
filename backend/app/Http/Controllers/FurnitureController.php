<?php

namespace App\Http\Controllers;

use App\Models\Furniture;
use App\Models\School;
use App\Http\Requests\UpdateFurnitureRequest;
use Illuminate\Http\Request;

class FurnitureController extends Controller
{
    /**
     * Display a listing of furniture for a school.
     */
    public function index($schoolId)
    {
        $school = School::findOrFail($schoolId);
        $furniture = Furniture::where('school_id', $schoolId)->orderBy('item_name')->get();

        // Default furniture items if not exists
        $defaultItems = [
            'Meja Siswa',
            'Kursi Siswa',
            'Meja Guru',
            'Kursi Guru',
            'Bangku Murid',
            'Lemari',
            'Rak Buku',
            'Papan Tulis',
            'White Board',
            'Kursi Tamu',
            'Meja OPS/TU',
            'Kursi OPS/TU',
        ];

        // Create default furniture if none exists
        if ($furniture->count() == 0) {
            foreach ($defaultItems as $item) {
                Furniture::create([
                    'school_id' => $schoolId,
                    'item_name' => $item,
                    'quantity' => 0,
                ]);
            }
            $furniture = Furniture::where('school_id', $schoolId)->orderBy('item_name')->get();
        }

        return view('inventaris.furniture.index', compact('furniture', 'school'));
    }

    /**
     * Show the form for editing the specified furniture.
     */
    public function edit($schoolId, $furnitureId)
    {
        $school = School::findOrFail($schoolId);
        $furniture = Furniture::findOrFail($furnitureId);

        // Verify furniture belongs to school
        if ($furniture->school_id != $schoolId) {
            abort(403, 'Perkakas tidak terdaftar di sekolah ini.');
        }

        return view('inventaris.furniture.edit', compact('furniture', 'school'));
    }

    /**
     * Update the specified furniture.
     */
    public function update(UpdateFurnitureRequest $request, $schoolId, $furnitureId)
    {
        $furniture = Furniture::findOrFail($furnitureId);

        // Verify furniture belongs to school
        if ($furniture->school_id != $schoolId) {
            abort(403, 'Perkakas tidak terdaftar di sekolah ini.');
        }

        $validated = $request->validated();

        $furniture->update($validated);

        return redirect()->route('schools.inventaris.furniture.index', $schoolId)
                        ->with('success', 'Data perkakas berhasil diperbarui!');
    }

    /**
     * Update all furniture at once (bulk update).
     */
    public function updateBulk(Request $request, $schoolId)
    {
        $validated = $request->validate([
            'furniture' => 'required|array',
        ]);

        foreach ($validated['furniture'] as $furnitureId => $data) {
            $furniture = Furniture::findOrFail($furnitureId);
            
            if ($furniture->school_id != $schoolId) {
                continue;
            }

            $furniture->update([
                'quantity' => $data['quantity'] ?? 0,
                'condition_good' => $data['condition_good'] ?? 0,
                'condition_medium' => $data['condition_medium'] ?? 0,
                'condition_light_damage' => $data['condition_light_damage'] ?? 0,
                'condition_heavy_damage' => $data['condition_heavy_damage'] ?? 0,
            ]);
        }

        return redirect()->route('schools.inventaris.furniture.index', $schoolId)
                        ->with('success', 'Data perkakas berhasil diperbarui!');
    }
}