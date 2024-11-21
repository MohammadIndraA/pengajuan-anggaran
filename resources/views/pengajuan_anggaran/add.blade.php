@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Pengajuan Anggaran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Pengajuan Anggaran</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Form</li>
            </ol>
        </nav>
    </div>
@endsection
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-6 mx-auto">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Form Tambah Anggraran</h5>

                        <!-- Multi Columns Form -->
                        <form action="{{ route('province-budget-requests.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="col-md-12">
                                <label for="submission_name" class="form-label">Nama Pengajuan</label>
                                <input type="text" class="form-control  @error('submission_name') is-invalid @enderror"
                                    value="{{ old('submission_name') }}" id="submission_name" name="submission_name"
                                    placeholder="Anggraran Pembayaran . . . .">
                                @error('submission_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="submission_date" class="form-label">Tanggal Pengajuan</label>
                                <input type="date" class="form-control @error('submission_date') is-invalid @enderror"
                                    id="submission_date" name="submission_date" value="{{ old('submission_date') }}">
                                @error('submission_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="funding_source_id" class="form-label">Sumber Dana</label>
                                <select id="funding_source_id"
                                    class="form-select .select2 @error('funding_source_id') is-invalid @enderror"
                                    name="funding_source_id">
                                    <option value="" disabled selected>Pilih Item...</option>
                                    @foreach ($funding_sources as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->funding_source_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('funding_source_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <label for="program_id" class="form-label">Program</label>
                                <select id="program_id"
                                    class="form-select .select2 @error('program_id') is-invalid @enderror"
                                    name="program_id">
                                    <option value="" disabled selected>Pilih Item...</option>
                                    @foreach ($programs as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('program_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->program_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('program_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label for="evidence_file" class="form-label">Unggah Berkas Anggaran</label>
                                <input type="file" class="form-control @error('evidence_file') is-invalid @enderror"
                                    id="evidence_file" value="{{ old('evidence_file') }}" name="evidence_file[]" multiple
                                    placeholder="">
                                @error('evidence_file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
