<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;
use App\Models\Principal;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\LandAsset;
use App\Models\Building;
use App\Models\Furniture;
use App\Models\Facility;
use App\Models\MonthlyReport;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample schools
        $schools = [
            [
                'npsn' => '12345678',
                'nss' => '987654',
                'name' => 'SDN Lebak Wangi 1',
                'status' => 'negeri',
                'accreditation' => 'A',
                'address' => 'Jl. Raya Lebak Wangi No. 1',
                'village' => 'Lebak Wangi',
                'district' => 'Lebak Wangi',
                'regency' => 'Serang',
                'province' => 'Banten',
                'postal_code' => '42185',
                'phone' => '021-123456',
                'email' => 'sdn1lebakwangi@sch.id',
                'website' => 'https://sdn1lebakwangi.sch.id',
            ],
            [
                'npsn' => '87654321',
                'nss' => '456789',
                'name' => 'SDN Lebak Wangi 2',
                'status' => 'negeri',
                'accreditation' => 'A',
                'address' => 'Jl. Pemuda Lebak Wangi No. 2',
                'village' => 'Lebak Wangi',
                'district' => 'Lebak Wangi',
                'regency' => 'Serang',
                'province' => 'Banten',
                'postal_code' => '42185',
                'phone' => '021-654321',
                'email' => 'sdn2lebakwangi@sch.id',
                'website' => 'https://sdn2lebakwangi.sch.id',
            ],
            [
                'npsn' => '11223344',
                'nss' => '556677',
                'name' => 'SD Swasta Harapan Bangsa',
                'status' => 'swasta',
                'accreditation' => 'B',
                'address' => 'Jl. Merdeka Lebak Wangi No. 3',
                'village' => 'Lebak Wangi',
                'district' => 'Lebak Wangi',
                'regency' => 'Serang',
                'province' => 'Banten',
                'postal_code' => '42185',
                'phone' => '021-789012',
                'email' => 'harapanbangsa@sch.id',
                'website' => 'https://harapanbangsa.sch.id',
            ],
        ];

        foreach ($schools as $schoolData) {
            $school = School::create($schoolData);

            // Create principal for the school
            Principal::create([
                'school_id' => $school->id,
                'name' => 'Kepala Sekolah ' . $school->name,
                'nip' => '19700101' . rand(101, 999),
                'nuptk' => '1234567890123456',
                'gender' => 'L',
                'religion' => 'Islam',
                'marital_status' => 'K',
                'birth_date' => '1970-01-01',
                'birth_place' => 'Serang',
                'education_initial' => 'S1 Pendidikan',
                'education_current' => 'S2 Pendidikan',
                'major' => 'Pendidikan Dasar',
                'rank' => 'Penata Tk.I',
                'golongan' => 'III/d',
                'tmt_golongan' => '2015-01-01',
                'tmt_cpns' => '1995-01-01',
                'tmt_pns' => '1997-01-01',
                'tmt_school' => '2010-01-01',
            ]);

            // Create some teachers for the school
            for ($i = 0; $i < 5; $i++) {
                Teacher::create([
                    'school_id' => $school->id,
                    'name' => 'Guru ' . ($i + 1) . ' ' . $school->name,
                    'nip' => '19750101' . rand(101, 999),
                    'nuptk' => '123456789012345' . $i,
                    'gender' => $i % 2 == 0 ? 'L' : 'P',
                    'religion' => 'Islam',
                    'marital_status' => 'K',
                    'birth_date' => '1975-01-01',
                    'birth_place' => 'Serang',
                    'education_initial' => 'S1 Pendidikan',
                    'education_current' => 'S2 Pendidikan',
                    'major' => 'Pendidikan Dasar',
                    'position' => $i == 0 ? 'GK' : ($i == 1 ? 'G PAI' : 'G PJOK'),
                    'tmt_cpns' => '2000-01-01',
                    'tmt_pns' => '2002-01-01',
                    'tmt_school' => '2010-01-01',
                    'teaching_class' => 'I',
                    'golongan' => 'III/c',
                    'tmt_golongan' => '2015-01-01',
                    'mk_school_years' => 13,
                    'mk_school_months' => 6,
                    'mk_total_years' => 23,
                    'mk_total_months' => 6,
                    'mk_golongan_years' => 8,
                    'mk_golongan_months' => 6,
                    'employment_status' => $i < 3 ? 'ASN' : 'Sukwan',
                ]);
            }

            // Create some students for the school
            for ($i = 0; $i < 30; $i++) {
                Student::create([
                    'school_id' => $school->id,
                    'nis' => 'NIS' . str_pad($school->id, 2, '0', STR_PAD_LEFT) . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'nisn' => 'NISN' . str_pad($school->id, 2, '0', STR_PAD_LEFT) . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                    'name' => 'Siswa ' . ($i + 1) . ' ' . $school->name,
                    'gender' => $i % 2 == 0 ? 'L' : 'P',
                    'class' => ['I', 'II', 'III', 'IV', 'V', 'VI'][rand(0, 5)],
                    'birth_date' => '2015-01-01',
                    'birth_place' => 'Serang',
                    'address' => 'Alamat siswa ' . ($i + 1),
                    'father_name' => 'Ayah Siswa ' . ($i + 1),
                    'mother_name' => 'Ibu Siswa ' . ($i + 1),
                    'guardian_name' => 'Wali Siswa ' . ($i + 1),
                    'economic_status' => ['Mampu', 'Sedang', 'Tidak Mampu'][rand(0, 2)],
                    'status' => 'Aktif',
                    'entry_date' => '2023-07-01',
                ]);
            }

            // Create land asset for the school
            LandAsset::create([
                'school_id' => $school->id,
                'government_owned' => 1,
                'foundation_owned' => 0,
                'individual_owned' => 0,
                'other_owned' => 0,
                'area_size' => 1000.00,
                'purchase_year' => 1990,
                'ownership_proof' => 'Sertifikat',
                'proof_number' => '123/Sertifikat/' . date('Y'),
                'proof_description' => 'Sertifikat hak milik atas tanah sekolah',
            ]);

            // Create some buildings for the school
            $buildingTypes = ['Ruang Kelas', 'Ruang Dinas Kepala', 'Ruang Dinas Guru', 'Ruang Dinas Penjaga', 'Ruang Guru', 'Perpustakaan', 'Ruang Ibadah', 'Ruang UKS'];
            foreach ($buildingTypes as $type) {
                Building::create([
                    'school_id' => $school->id,
                    'room_type' => $type,
                    'quantity' => rand(1, 3),
                    'condition_non_standard' => 0,
                    'condition_good' => rand(1, 2),
                    'condition_light_damage' => rand(0, 1),
                    'condition_medium_damage' => rand(0, 1),
                    'condition_heavy_damage' => 0,
                    'age_le_6' => rand(0, 1),
                    'age_7' => rand(0, 1),
                    'age_8' => rand(0, 1),
                    'age_9' => rand(0, 1),
                    'age_10' => rand(0, 1),
                    'age_11' => rand(0, 1),
                    'age_12' => rand(0, 1),
                    'age_ge_13' => rand(0, 2),
                ]);
            }

            // Create some furniture for the school
            $furnitureTypes = ['Meja Siswa', 'Kursi Siswa', 'Meja Guru', 'Kursi Guru', 'Bangku Murid', 'Lemari', 'Rak Buku', 'Papan Tulis', 'White Board', 'Kursi Tamu', 'Meja OPS/TU', 'Kursi OPS/TU'];
            foreach ($furnitureTypes as $type) {
                Furniture::create([
                    'school_id' => $school->id,
                    'item_name' => $type,
                    'quantity' => rand(10, 30),
                    'condition_good' => rand(5, 20),
                    'condition_medium' => rand(0, 5),
                    'condition_light_damage' => rand(0, 3),
                    'condition_heavy_damage' => rand(0, 2),
                ]);
            }

            // Create facility for the school
            Facility::create([
                'school_id' => $school->id,
                'water_well' => true,
                'water_pump' => true,
                'pam' => false,
                'river' => false,
                'other_water' => false,
                'other_water_desc' => null,
                'toilet_count' => 4,
                'is_borrowed' => false,
                'borrowed_from' => null,
            ]);

            // Create a monthly report for the school
            MonthlyReport::create([
                'school_id' => $school->id,
                'month' => 'Januari',
                'year' => date('Y'),
                'student_absent_sick' => rand(0, 5),
                'student_absent_permit' => rand(0, 3),
                'student_absent_alpha' => rand(0, 2),
                'student_absent_total' => rand(0, 10),
                'teacher_absent_sick' => rand(0, 2),
                'teacher_absent_permit' => rand(0, 1),
                'teacher_absent_alpha' => rand(0, 1),
                'teacher_absent_total' => rand(0, 4),
                'non_pns_absent_sick' => rand(0, 1),
                'non_pns_absent_permit' => rand(0, 1),
                'non_pns_absent_alpha' => rand(0, 1),
                'non_pns_absent_total' => rand(0, 3),
                'effective_days' => 22,
                'student_changes' => json_encode([]),
                'status' => 'submitted',
                'submitted_at' => now(),
                'approved_at' => now(),
            ]);
        }
    }
}