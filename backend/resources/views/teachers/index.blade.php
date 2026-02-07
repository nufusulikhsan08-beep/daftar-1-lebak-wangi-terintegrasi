@extends('layouts.app')

@section('title', 'Data Guru - ' . $school->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-person-workspace"></i> Data Guru - {{ $school->name }}
                </h4>
                <div>
                    <a href="{{ route('schools.teachers.create', $school->id) }}" class="btn btn-light">
                        <i class="bi bi-plus"></i> Tambah Guru
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" 
                                   placeholder="Cari nama guru..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end">
                            <a href="{{ route('schools.teachers.import.form', $school->id) }}" 
                               class="btn btn-success me-2">
                                <i class="bi bi-upload"></i> Import
                            </a>
                            <a href="{{ route('schools.teachers.export.form', $school->id) }}" 
                               class="btn btn-info">
                                <i class="bi bi-download"></i> Export
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>NUPTK</th>
                                <th>Jenis Kelamin</th>
                                <th>Jabatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($teachers as $index => $teacher)
                                <tr>
                                    <td>{{ $teachers->firstItem() + $index }}</td>
                                    <td>{{ $teacher->name }}</td>
                                    <td>{{ $teacher->nip ?? '-' }}</td>
                                    <td>{{ $teacher->nuptk ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $teacher->gender == 'L' ? 'primary' : 'danger' }}">
                                            {{ $teacher->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                    <td>{{ $teacher->position }}</td>
                                    <td>
                                        <span class="badge bg-{{ $teacher->employment_status == 'ASN' ? 'success' : 'warning' }}">
                                            {{ $teacher->employment_status == 'ASN' ? 'ASN' : 'Sukwan' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('schools.teachers.show', [$school->id, $teacher->id]) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('schools.teachers.edit', [$school->id, $teacher->id]) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('schools.teachers.destroy', [$school->id, $teacher->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus guru ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data guru</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Menampilkan {{ $teachers->count() }} dari {{ $teachers->total() }} guru
                    </div>
                    <div>
                        {{ $teachers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection