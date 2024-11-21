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
                        <form action="{{ url('pengajuan-anggaran/update', $id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            @if (Request::is('pengajuan-anggaran-province/*'))
                                <input type="hidden" name="type" value="province">
                            @endif
                            @if (Request::is('pengajuan-anggaran-regency/*'))
                                <input type="hidden" name="type" value="regency">
                            @endif
                            @if (Request::is('pengajuan-anggaran-departement/*'))
                                <input type="hidden" name="type" value="departement">
                            @endif
                            @if (Request::is('pengajuan-anggaran-province/*'))
                                <div class="col-md-12">
                                    <label for="province_id" class="form-label">Nama Daerah Wilayah</label>
                                    <input type="text" class="form-control  @error('province_id') is-invalid @enderror"
                                        value="{{ old('province_id', $data->province->name) }}" id="province_id" disabled
                                        name="province_id" placeholder="Anggraran Pembayaran . . . .">
                                    @error('province_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @else
                                <div class="col-md-12">
                                    <label for="regency_city_id" class="form-label">Nama Daerah Wilayah</label>
                                    <input type="text"
                                        class="form-control  @error('regency_city_id') is-invalid @enderror"
                                        value="{{ old('regency_city_id', $data->regency_city->name) }}" id="regency_city_id"
                                        disabled name="regency_city_id" placeholder="Anggraran Pembayaran . . . .">
                                    @error('regency_city_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                            <div class="col-md-12">
                                <label for="submission_name" class="form-label">Nama Pengajuan</label>
                                <input type="text" class="form-control  @error('submission_name') is-invalid @enderror"
                                    value="{{ old('submission_name', $data->submission_name) }}" id="submission_name"
                                    disabled name="submission_name" placeholder="Anggraran Pembayaran . . . .">
                                @error('submission_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="submission_date" class="form-label">Tanggal Pengajuan</label>
                                <input type="date" class="form-control @error('submission_date') is-invalid @enderror"
                                    id="submission_date" name="submission_date" disabled
                                    value="{{ old('submission_date', $data->submission_date) }}">
                                @error('submission_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="funding_source" class="form-label">Sumber Dana</label>
                                <select id="funding_source"
                                    class="form-select @error('funding_source') is-invalid @enderror" disabled
                                    name="funding_source">
                                    @foreach ($funding_source as $item)
                                        @if (old('funding_source', $data->funding_source) == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->funding_source_name }}
                                            </option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->funding_source_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('funding_source')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" class="form-select @error('status') is-invalid @enderror"
                                    name="status">
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="rejected"
                                        {{ old('status', $data->status) == 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                    <option value="proses"
                                        {{ old('status', $data->status) == 'proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="approved"
                                        {{ old('status', $data->status) == 'approved' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="pending"
                                        {{ old('status', $data->status) == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description" class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                        style="height: 100px">{{ old('description', $data->deskription) }}</textarea>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-info w-100 mb-1">Submit</button>
                            <button type="reset" class="btn btn-secondary w-100">Reset</button>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
