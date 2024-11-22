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
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tambah Data Baru</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-2" action="{{ route('province-imports.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id" value="{{ $id }}">

                                <label for="program" class="form-label">Program</label>
                                <select id="program" class="form-select @error('program') is-invalid @enderror"
                                    name="program">
                                    <option value="">Pilih Item...</option>
                                    @foreach ($program as $item)
                                        <option value="{{ $item->program_name }}">{{ $item->program_name }}</option>
                                    @endforeach
                                </select>
                                @error('program')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="component" class="form-label">Komponen</label>
                                <select id="component" class="form-select @error('component') is-invalid @enderror"
                                    name="component">
                                    <option value="">Pilih Item...</option>
                                    @foreach ($component as $item)
                                        <option value="{{ $item->component_name }}">{{ $item->component_name }}</option>
                                    @endforeach
                                </select>
                                @error('component')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kro" class="form-label">KRO</label>
                                <select id="kro" class="form-select @error('kro') is-invalid @enderror"
                                    name="kro">
                                    <option value="">Pilih Item...</option>
                                    @foreach ($kro as $item)
                                        <option value="{{ $item->kro_name }}">{{ $item->kro_name }}</option>
                                    @endforeach
                                </select>
                                @error('kro')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="ro" class="form-label">RO</label>
                                <select id="ro" class="form-select @error('ro') is-invalid @enderror" name="ro">
                                    <option value="">Pilih Item...</option>
                                    @foreach ($ro as $item)
                                        <option value="{{ $item->ro_name }}">{{ $item->ro_name }}</option>
                                    @endforeach
                                </select>
                                @error('ro')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="activity" class="form-label">Kegiatan</label>
                                <select id="activity" class="form-select @error('activity') is-invalid @enderror"
                                    name="activity">
                                    <option value="">Pilih Item...</option>
                                    @foreach ($activity as $item)
                                        <option value="{{ $item->activity_name }}">{{ $item->activity_name }}</option>
                                    @endforeach
                                </select>
                                @error('activity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="unit" class="form-label">Satuan</label>
                                <select id="unit" class="form-select @error('unit') is-invalid @enderror"
                                    name="unit">
                                    <option value="">Pilih Item...</option>
                                    @foreach ($unit as $item)
                                        <option value="{{ $item->unit_name }}">{{ $item->unit_name }}</option>
                                    @endforeach
                                </select>
                                @error('unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="qty" class="form-label">Qty</label>
                                <input type="text" class="form-control @error('qty') is-invalid @enderror"
                                    name="qty">
                                @error('qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="subtotal" class="form-label">Subtotal</label>
                                <input type="text" class="form-control @error('subtotal') is-invalid @enderror"
                                    name="subtotal">
                                @error('subtotal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="text-between">
                                <button type="submit" class="btn btn-info w-20">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
