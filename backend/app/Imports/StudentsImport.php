<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StudentsImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    protected $schoolId;
    
    public function __construct($schoolId)
    {
        $this->schoolId = $schoolId;
    }
    
    public function model(array $row)
    {
        // Map Excel columns to database fields
        return new Student([
            'school_id' => $this->schoolId,
            'nis' => $row['nis'] ?? null,
            'nisn' => $row['nisn'] ?? null,
            'name' => $row['nama'] ?? $row['name'] ?? '',
            'gender' => $row['jenis_kelamin'] ?? $row['gender'] ?? 'L',
            'class' => $row['kelas'] ?? 'I',
            'birth_date' => $row['tanggal_lahir'] ?? null,
            'birth_place' => $row['tempat_lahir'] ?? null,
            'address' => $row['alamat'] ?? null,
            'father_name' => $row['nama_ayah'] ?? null,
            'mother_name' => $row['nama_ibu'] ?? null,
            'guardian_name' => $row['nama_wali'] ?? null,
            'economic_status' => $row['status_ekonomi'] ?? 'Sedang',
            'status' => $row['status_siswa'] ?? 'Aktif',
            'entry_date' => $row['tanggal_masuk'] ?? null,
            'exit_date' => $row['tanggal_keluar'] ?? null,
            'notes' => $row['keterangan'] ?? null,
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