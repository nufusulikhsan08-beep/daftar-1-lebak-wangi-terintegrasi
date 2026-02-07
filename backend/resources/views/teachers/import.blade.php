@extends('layouts.app')

@section('title', 'Import Data Guru')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-upload"></i> Import Data Guru
                </h4>
                <small class="text-white">Sekolah: {{ $school->name }}</small>
            </div>
            
            <div class="card-body">
                <form action="{{ route('schools.teachers.import', $school->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> 
                        <strong>Format File:</strong> Silakan unduh template Excel terlebih dahulu untuk memastikan format data yang benar.
                        <br><br>
                        <a href="{{ route('schools.teachers.export', $school->id) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-download"></i> Unduh Template Kosong
                        </a>
                    </div>
                    
                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" 
                               id="file" name="file" accept=".xlsx,.xls" required>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-muted">
                        <small>Format yang didukung: .xlsx, .xls<br>
                        Ukuran maksimal: 10MB</small>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('schools.teachers.index', $school->id) }}" 
                           class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-upload"></i> Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection