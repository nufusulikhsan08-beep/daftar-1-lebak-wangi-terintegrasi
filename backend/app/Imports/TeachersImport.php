<?php

namespace App\Imports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TeachersImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    protected $schoolId;
    
    public function __construct($schoolId)
    {
        $this->schoolId = $schoolId;
    }
    
    public function model(array $row)
    {
        // Map Excel columns to database fields
        return new Teacher([
            'school_id' => $this->schoolId,
            'name' => $row['nama'] ?? $row['name'] ?? '',
            'nip' => $row['nip'] ?? null,
            'nuptk' => $row['nuptk'] ?? null,
            'gender' => $row['jenis_kelamin'] ?? $row['gender'] ?? 'L',
            'religion' => $row['agama'] ?? null,
            'marital_status' => $row['status_kawin'] ?? $row['marital_status'] ?? 'TK',
            'birth_date' => $row['tanggal_lahir'] ?? null,
            'birth_place' => $row['tempat_lahir'] ?? null,
            'education_initial' => $row['ijazah_awal'] ?? null,
            'education_current' => $row['ijazah_sekarang'] ?? null,
            'major' => $row['jurusan'] ?? null,
            'position' => $row['jabatan'] ?? 'GK',
            'tmt_cpns' => $row['tmt_cpns'] ?? null,
            'tmt_pns' => $row['tmt_pns'] ?? null,
            'tmt_school' => $row['tmt_di_sekolah'] ?? null,
            'teaching_class' => $row['mengajar_di_kelas'] ?? null,
            'golongan' => $row['golongan'] ?? null,
            'tmt_golongan' => $row['tmt_golongan'] ?? null,
            'mk_school_years' => $row['mk_di_sekolah_thn'] ?? 0,
            'mk_school_months' => $row['mk_di_sekolah_bln'] ?? 0,
            'mk_total_years' => $row['mk_seluruh_thn'] ?? 0,
            'mk_total_months' => $row['mk_seluruh_bln'] ?? 0,
            'mk_golongan_years' => $row['mk_golongan_thn'] ?? 0,
            'mk_golongan_months' => $row['mk_golongan_bln'] ?? 0,
            'employment_status' => $row['status_kepegawaian'] ?? 'ASN',
        ]);
    }
    
    public function batchSize(): int
    {
        return 1000;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}