@extends('layouts.app')

@section('title', 'Export Data Guru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-download"></i> Export Data Guru
                </h4>
                <small class="text-white">Sekolah: {{ $school->name }}</small>
            </div>
            
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> 
                    <strong>Total Data:</strong> {{ $teachers->count() }} guru ditemukan
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>NUPTK</th>
                                <th>Jenis Kelamin</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $teacher)
                                <tr>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->nip ?? '-' }}</td>
                                    <td>{{ $teacher->nuptk ?? '-' }}</td>
                                    <td>{{ $teacher->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $teacher->position }}</td>
                                    <td>
                                        <span class="badge bg-{{ $teacher->employment_status == 'ASN' ? 'primary' : 'warning' }}">
                                            {{ $teacher->employment_status == 'ASN' ? 'ASN' : 'Sukwan' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data guru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('schools.teachers.index', $school->id) }}" 
                       class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('schools.teachers.export', $school->id) }}" 
                       class="btn btn-success">
                        <i class="bi bi-download"></i> Unduh Semua Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection