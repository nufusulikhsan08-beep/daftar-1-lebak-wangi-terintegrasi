@extends('layouts.app')

@section('title', 'Export Data Siswa')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-download"></i> Export Data Siswa
                </h4>
                <small class="text-white">Sekolah: {{ $school->name }}</small>
            </div>
            
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    <strong>Total Data:</strong> {{ $students->count() }} siswa ditemukan
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->nis ?? '-' }}</td>
                                    <td>{{ $student->nisn ?? '-' }}</td>
                                    <td>{{ $student->class }}</td>
                                    <td>{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->status == 'Aktif' ? 'success' : 'warning' }}">
                                            {{ $student->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data siswa</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('schools.students.index', $school->id) }}" 
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('schools.students.export', $school->id) }}" 
                       class="btn btn-success">
                        <i class="bi bi-download"></i> Unduh Semua Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection