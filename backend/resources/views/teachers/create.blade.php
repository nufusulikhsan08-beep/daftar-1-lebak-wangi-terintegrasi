@extends('layouts.app')

@section('title', 'Tambah Guru - ' . $school->name)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-person-add"></i> Tambah Guru Baru
                </h4>
                <small class="text-white">Sekolah: {{ $school->name }}</small>
            </div>
            
            <div class="card-body">
                <form action="{{ route('schools.teachers.store', $school->id) }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                       id="nip" name="nip" value="{{ old('nip') }}">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="nuptk" class="form-label">NUPTK</label>
                                <input type="text" class="form-control @error('nuptk') is-invalid @enderror" 
                                       id="nuptk" name="nuptk" value="{{ old('nuptk') }}">
                                @error('nuptk')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" 
                                        id="gender" name="gender" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="religion" class="form-label">Agama</label>
                                <input type="text" class="form-control @error('religion') is-invalid @enderror" 
                                       id="religion" name="religion" value="{{ old('religion') }}">
                                @error('religion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="marital_status" class="form-label">Status Perkawinan</label>
                                <select class="form-select @error('marital_status') is-invalid @enderror" 
                                        id="marital_status" name="marital_status">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="K" {{ old('marital_status') == 'K' ? 'selected' : '' }}>Kawin</option>
                                    <option value="TK" {{ old('marital_status') == 'TK' ? 'selected' : '' }}>Tidak Kawin</option>
                                </select>
                                @error('marital_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="birth_place" class="form-label">Tempat Lahir</label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror" 
                                       id="birth_place" name="birth_place" value="{{ old('birth_place') }}">
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="education_initial" class="form-label">Pendidikan Awal</label>
                                <input type="text" class="form-control @error('education_initial') is-invalid @enderror" 
                                       id="education_initial" name="education_initial" 
                                       value="{{ old('education_initial') }}">
                                @error('education_initial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="education_current" class="form-label">Pendidikan Sekarang</label>
                                <input type="text" class="form-control @error('education_current') is-invalid @enderror" 
                                       id="education_current" name="education_current" 
                                       value="{{ old('education_current') }}">
                                @error('education_current')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="major" class="form-label">Jurusan</label>
                                <input type="text" class="form-control @error('major') is-invalid @enderror" 
                                       id="major" name="major" value="{{ old('major') }}">
                                @error('major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="position" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <select class="form-select @error('position') is-invalid @enderror" 
                                        id="position" name="position" required>
                                    <option value="">-- Pilih Jabatan --</option>
                                    <option value="GK" {{ old('position') == 'GK' ? 'selected' : '' }}>Guru Kelas (GK)</option>
                                    <option value="G PAI" {{ old('position') == 'G PAI' ? 'selected' : '' }}>Guru Pendidikan Agama (G PAI)</option>
                                    <option value="G PJOK" {{ old('position') == 'G PJOK' ? 'selected' : '' }}>Guru Penjas Olahraga dan Kesehatan (G PJOK)</option>
                                    <option value="OP" {{ old('position') == 'OP' ? 'selected' : '' }}>Operator (OP)</option>
                                    <option value="TU" {{ old('position') == 'TU' ? 'selected' : '' }}>Tata Usaha (TU)</option>
                                    <option value="Lainnya" {{ old('position') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="position_detail" class="form-label">Detail Jabatan</label>
                                <input type="text" class="form-control @error('position_detail') is-invalid @enderror" 
                                       id="position_detail" name="position_detail" 
                                       value="{{ old('position_detail') }}">
                                @error('position_detail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="employment_status" class="form-label">Status Kepegawaian <span class="text-danger">*</span></label>
                                <select class="form-select @error('employment_status') is-invalid @enderror" 
                                        id="employment_status" name="employment_status" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="ASN" {{ old('employment_status') == 'ASN' ? 'selected' : '' }}>ASN (Aparatur Sipil Negara)</option>
                                    <option value="Sukwan" {{ old('employment_status') == 'Sukwan' ? 'selected' : '' }}>Sumber Daya Pendamping (Sukwan)</option>
                                </select>
                                @error('employment_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="tmt_cpns" class="form-label">TMT CPNS</label>
                                <input type="date" class="form-control @error('tmt_cpns') is-invalid @enderror" 
                                       id="tmt_cpns" name="tmt_cpns" value="{{ old('tmt_cpns') }}">
                                @error('tmt_cpns')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="tmt_pns" class="form-label">TMT PNS</label>
                                <input type="date" class="form-control @error('tmt_pns') is-invalid @enderror" 
                                       id="tmt_pns" name="tmt_pns" value="{{ old('tmt_pns') }}">
                                @error('tmt_pns')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="tmt_school" class="form-label">TMT di Sekolah Ini</label>
                                <input type="date" class="form-control @error('tmt_school') is-invalid @enderror" 
                                       id="tmt_school" name="tmt_school" value="{{ old('tmt_school') }}">
                                @error('tmt_school')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="teaching_class" class="form-label">Kelas Mengajar</label>
                                <input type="text" class="form-control @error('teaching_class') is-invalid @enderror" 
                                       id="teaching_class" name="teaching_class" 
                                       value="{{ old('teaching_class') }}">
                                @error('teaching_class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="golongan" class="form-label">Golongan</label>
                                <input type="text" class="form-control @error('golongan') is-invalid @enderror" 
                                       id="golongan" name="golongan" value="{{ old('golongan') }}">
                                @error('golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="tmt_golongan" class="form-label">TMT Golongan</label>
                                <input type="date" class="form-control @error('tmt_golongan') is-invalid @enderror" 
                                       id="tmt_golongan" name="tmt_golongan" value="{{ old('tmt_golongan') }}">
                                @error('tmt_golongan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mk_school_years" class="form-label">Masa Kerja di Sekolah (Tahun)</label>
                                <input type="number" class="form-control @error('mk_school_years') is-invalid @enderror" 
                                       id="mk_school_years" name="mk_school_years" 
                                       value="{{ old('mk_school_years', 0) }}" min="0">
                                @error('mk_school_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mk_school_months" class="form-label">Masa Kerja di Sekolah (Bulan)</label>
                                <input type="number" class="form-control @error('mk_school_months') is-invalid @enderror" 
                                       id="mk_school_months" name="mk_school_months" 
                                       value="{{ old('mk_school_months', 0) }}" min="0" max="11">
                                @error('mk_school_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mk_total_years" class="form-label">Masa Kerja Total (Tahun)</label>
                                <input type="number" class="form-control @error('mk_total_years') is-invalid @enderror" 
                                       id="mk_total_years" name="mk_total_years" 
                                       value="{{ old('mk_total_years', 0) }}" min="0">
                                @error('mk_total_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mk_total_months" class="form-label">Masa Kerja Total (Bulan)</label>
                                <input type="number" class="form-control @error('mk_total_months') is-invalid @enderror" 
                                       id="mk_total_months" name="mk_total_months" 
                                       value="{{ old('mk_total_months', 0) }}" min="0" max="11">
                                @error('mk_total_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mk_golongan_years" class="form-label">Masa Kerja Golongan (Tahun)</label>
                                <input type="number" class="form-control @error('mk_golongan_years') is-invalid @enderror" 
                                       id="mk_golongan_years" name="mk_golongan_years" 
                                       value="{{ old('mk_golongan_years', 0) }}" min="0">
                                @error('mk_golongan_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="mk_golongan_months" class="form-label">Masa Kerja Golongan (Bulan)</label>
                                <input type="number" class="form-control @error('mk_golongan_months') is-invalid @enderror" 
                                       id="mk_golongan_months" name="mk_golongan_months" 
                                       value="{{ old('mk_golongan_months', 0) }}" min="0" max="11">
                                @error('mk_golongan_months')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('schools.teachers.index', $school->id) }}" 
                           class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Guru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection