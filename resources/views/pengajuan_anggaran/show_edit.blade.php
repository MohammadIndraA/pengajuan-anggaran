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
                        <h5 class="card-title">Form Edit Anggraran</h5>

                        <!-- Multi Columns Form -->
                        <form action="{{ route('pengajuan-anggaran.update-data', $id) }}" method="POST"
                            enctype="multipart/form-data" id="fileUploadForm">
                            @csrf
                            @method('POST')
                            <div class="col-md-12">
                                <input type="hidden" name="type" value="{{ Auth::user()->role }}">

                                <label for="submission_name" class="form-label">Nama Pengajuan</label>
                                <input type="text" class="form-control  @error('submission_name') is-invalid @enderror"
                                    value="{{ old('submission_name', $data->submission_name) }}" id="submission_name"
                                    name="submission_name" placeholder="Anggraran Pembayaran . . . .">
                                @error('submission_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-2">
                                <label for="submission_date" class="form-label">Tanggal Pengajuan</label>
                                <input type="date" class="form-control @error('submission_date') is-invalid @enderror"
                                    id="submission_date" name="submission_date"
                                    value="{{ old('submission_date', $data->submission_date) }}">
                                @error('submission_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- <div class="col-md-12">
                                <label for="sumber_dana" class="form-label">Sumber Dana</label>
                                <input type="text" class="form-control  @error('sumber_dana') is-invalid @enderror"
                                    disabled value="{{ old('sumber_dana', $data->sumber_dana) }}" id="sumber_dana"
                                    name="sumber_dana" placeholder="Anggraran Pembayaran . . . .">
                                @error('sumber_dana')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="program_name" class="form-label">Program</label>
                                <input type="text" class="form-control  @error('program_name') is-invalid @enderror"
                                    disabled value="{{ old('program_name', $data->program_name) }}" id="program_name"
                                    name="program_name" placeholder="Anggraran Pembayaran . . . .">
                                @error('program_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}
                            <div class="col-12 mb-2 mt-2">
                                <label for="evidence_file" class="form-label">Unggah Berkas Anggaran (Excel)</label>
                                <p class="mb-0" style="float: right; font-size: 12px">
                                    <a href="{{ asset('template/template.xlsx') }}" download target="_blank">Download
                                        template excel</a>
                                </p>

                                <input type="file" class="form-control @error('evidence_file') is-invalid @enderror"
                                    id="evidence_file" value="{{ old('evidence_file') }}" name="evidence_file" multiple
                                    placeholder="">
                                @error('evidence_file')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mb-2 mt-2">
                                <label for="proposal_file_id" class="form-label">Unggah Berkas (Proposal)</label>
                                <input type="file" class="form-control @error('proposal_file_id') is-invalid @enderror"
                                    id="proposal_file_id" value="{{ old('proposal_file_id') }}" name="proposal_file_id"
                                    multiple placeholder="">
                                @error('proposal_file_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- <div class="form-group my-2">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                                        style="width: 0%"></div>
                                </div>
                            </div> --}}
                            <button type="submit" class="btn btn-info w-100 mb-1">Submit</button>
                            <button type="reset" class="btn btn-secondary w-100">Reset</button>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

@section('script')
    <script>
        $("#funding_source_id").select2({
            theme: "bootstrap-5",
        });
        $("#program_id").select2({
            theme: "bootstrap-5",
        });
    </script>
@endsection

{{-- @section('script')
    <script>
        $(function() {
            $(document).ready(function() {
                $('#fileUploadForm').on('submit', function(e) {
                    e.preventDefault(); // Mencegah form submit secara default

                    const form = this;
                    const formData = new FormData(form); // Ambil semua data dari form

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', form.action, true);

                    // CSRF Token (jika menggunakan Laravel)
                    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr(
                        'content'));

                    // Progress Event
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            const percentage = Math.round((e.loaded * 100) / e.total);
                            $('.progress .progress-bar')
                                .css('width', percentage + '%')
                                .attr('aria-valuenow', percentage);
                        }
                    });

                    // Event saat selesai
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            alert('File has uploaded successfully!');
                            $('.progress .progress-bar').css('width', '0%').attr(
                                'aria-valuenow', 0); // Reset progres
                            form.reset(); // Reset form setelah sukses
                        } else {
                            alert('Failed to upload file. Please try again.');
                        }
                    };

                    // Event jika terjadi error
                    xhr.onerror = function() {
                        alert('An error occurred while uploading the file.');
                    };

                    // Kirim form data
                    xhr.send(formData);
                });
            });
        });
    </script>
@endsection --}}
