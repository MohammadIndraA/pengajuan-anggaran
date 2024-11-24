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

                        {{-- alert --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-octagon me-1"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        {{-- end alert --}}

                        <h5 class="card-title">Tambah Data Baru</h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-2" action="{{ route('pengajuan-anggaran-import.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id" value="{{ $id }}">

                                <label for="program" class="form-label">Program</label>
                                <select id="program" class="form-select @error('program') is-invalid @enderror"
                                    name="program">
                                    <option value="">Pilih Item...</option>
                                    @foreach ($program as $item)
                                        <option value="{{ $item->program_name }}"
                                            {{ old('program') == $item->program_name ? 'selected' : '' }}>
                                            {{ $item->program_name }}
                                        </option>
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
                                        <option value="{{ $item->component_name }}"
                                            {{ old('component') == $item->component_name ? 'selected' : '' }}>
                                            {{ $item->component_name }}
                                        </option>
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
                                        <option value="{{ $item->kro_name }}"
                                            {{ old('kro') == $item->kro_name ? 'selected' : '' }}>{{ $item->kro_name }}
                                        </option>
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
                                        <option value="{{ $item->ro_name }}"
                                            {{ old('kro') == $item->kro_name ? 'selected' : '' }}>{{ $item->ro_name }}
                                        </option>
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
                                        <option value="{{ $item->activity_name }}"
                                            {{ old('activity') == $item->activity_name ? 'selected' : '' }}>
                                            {{ $item->activity_name }}</option>
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
                                        <option value="{{ $item->unit_name }}"
                                            {{ old('unit') == $item->unit_name ? 'selected' : '' }}>
                                            {{ $item->unit_name }}</option>
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
                                <input type="number" value="{{ old('qty') }}"
                                    class="form-control @error('qty') is-invalid @enderror" name="qty" min="1"
                                    placeholder="10">
                                @error('qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="subtotal" class="form-label">Subtotal</label>
                                <input type="number" value="{{ old('subtotal') }}"
                                    class="form-control @error('subtotal') is-invalid @enderror" name="subtotal"
                                    placeholder="100000" min="1000">
                                @error('subtotal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="text-between">
                                <button type="submit" class="btn btn-info" style="padding: 5px 50px">Submit</button>
                                <button type="reset" class="btn btn-secondary" style="padding: 5px 50px">Reset</button>
                            </div>
                        </form><!-- End Multi Columns Form -->

                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection
@section('script')
    <script>
        var settings = {};
        new TomSelect('#program', settings);
        new TomSelect('#component', settings);
        new TomSelect('#kro', settings);
        new TomSelect('#ro', settings);
        new TomSelect('#unit', settings);
        new TomSelect('#activity', settings);
    </script>
@endsection
