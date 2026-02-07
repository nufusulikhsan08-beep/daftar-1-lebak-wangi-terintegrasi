@extends('layouts.app')

@section('title', 'Data Siswa - ' . $school->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-people"></i> Data Siswa - {{ $school->name }}
                </h4>
                <div>
                    <a href="{{ route('schools.students.create', $school->id) }}" class="btn btn-light">
                        <i class="bi bi-plus"></i> Tambah Siswa
                    </a>
                </div>
            </div>
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" 
                                   placeholder="Cari nama siswa..." value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end">
                            <select name="class" class="form-select me-2" onchange="window.location='?class='+this.value+'&search={{ request('search') }}'">
                                <option value="">Semua Kelas</option>
                                <option value="I" {{ request('class') == 'I' ? 'selected' : '' }}>Kelas I</option>
                                <option value="II" {{ request('class') == 'II' ? 'selected' : '' }}>Kelas II</option>
                                <option value="III" {{ request('class') == 'III' ? 'selected' : '' }}>Kelas III</option>
                                <option value="IV" {{ request('class') == 'IV' ? 'selected' : '' }}>Kelas IV</option>
                                <option value="V" {{ request('class') == 'V' ? 'selected' : '' }}>Kelas V</option>
                                <option value="VI" {{ request('class') == 'VI' ? 'selected' : '' }}>Kelas VI</option>
                            </select>
                            <a href="{{ route('schools.students.import.form', $school->id) }}" 
                               class="btn btn-success me-2">
                                <i class="bi bi-upload"></i> Import
                            </a>
                            <a href="{{ route('schools.students.export.form', $school->id) }}" 
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
                                <th>NIS</th>
                                <th>NISN</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                                <tr>
                                    <td>{{ $students->firstItem() + $index }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->nis ?? '-' }}</td>
                                    <td>{{ $student->nisn ?? '-' }}</td>
                                    <td>{{ $student->class }}</td>
                                    <td>
                                        <span class="badge bg-{{ $student->gender == 'L' ? 'primary' : 'danger' }}">
                                            {{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $student->status == 'Aktif' ? 'success' : 'warning' }}">
                                            {{ $student->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('schools.students.show', [$school->id, $student->id]) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('schools.students.edit', [$school->id, $student->id]) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('schools.students.destroy', [$school->id, $student->id]) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data siswa</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Menampilkan {{ $students->count() }} dari {{ $students->total() }} siswa
                    </div>
                    <div>
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection