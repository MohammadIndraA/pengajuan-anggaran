@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Tambah User Page</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">User Form</a></li>
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
                        <form class="row g-2" action="{{ url('/user-store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="col-md-6">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    placeholder="Masukan Username ..." value="{{ old('username') }}" name="username">
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Masukan Email ..." value="{{ old('email') }}" name="email">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukan name ..." value="{{ old('name') }}" name="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">password</label>
                                <input type="text" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukan password ..." value="{{ old('password') }}" name="password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="@if ($type !== 'province') col-md-6 @else col-md-4 @endif">
                                <label for="region" class="form-label">Wilayah</label>
                                <input type="text" class="form-control @error('region') is-invalid @enderror"
                                    placeholder="Masukan region ..." value="{{ old('region') }}" name="region">
                                @error('region')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="@if ($type !== 'province') col-md-6 @else col-md-4 @endif">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" class="form-select form-control @error('role') is-invalid @enderror"
                                    name="role">
                                    @if (Auth::user()->role === 'province')
                                        <option value="regency" {{ old('role') == 'regency' ? 'selected' : '' }}>Regency
                                        </option>
                                    @else
                                        <option disabled selected>Pilih Item...</option>
                                        <option value="pusat" {{ old('role') == 'pusat' ? 'selected' : '' }}>Pusat
                                        </option>
                                        <option value="division" {{ old('role') == 'division' ? 'selected' : '' }}>Divisi
                                        </option>
                                        <option value="province" {{ old('role') == 'province' ? 'selected' : '' }}>Province
                                        </option>
                                        <option value="regency" {{ old('role') == 'regency' ? 'selected' : '' }}>Regency
                                        </option>
                                        <option value="departement" {{ old('role') == 'depertement' ? 'selected' : '' }}>
                                            Depertement</option>
                                    @endif
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="@if ($type !== 'province') col-md-6 @else col-md-4 @endif">
                                <label for="province_id" class="form-label">Provinsi</label>
                                <select id="province_id"
                                    class="form-select form-control @error('province_id') is-invalid @enderror"
                                    name="province_id">
                                    <option value="" disabled selected>Pilih Item...</option>
                                    @foreach ($provinces as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('province_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            @if ($type != 'province')
                                <div class="col-md-6">
                                    <label for="regency_city_id" class="form-label">Kota Kabupaten</label>
                                    <select id="regency_city_id"
                                        class="form-select form-control @error('regency_city_id') is-invalid @enderror"
                                        name="regency_city_id">
                                        <option value="" disabled selected>Pilih Item...</option>
                                        @foreach ($regency_cities as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('regency_city_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('regency_city_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif

                            {{-- <div class="col-md-4">
                                <label for="departement_id" class="form-label">Departement</label>
                                <select id="departement_id"
                                    class="form-select form-control @error('departement_id') is-invalid @enderror"
                                    name="departement_id">
                                    <option value="" disabled selected>Pilih Item...</option>
                                    @foreach ($departement as $item)
                                        <option value="{{ $item->id }}"
                                            {{ old('departement_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->departement_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('departement_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}

                            <div class="text-between">
                                <button type="submit" class="btn btn-info" style="padding: 5px 50px">Simpan</button>
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
        $("#province_id").select2({
            theme: "bootstrap-5",
        });
        $("#departement_id").select2({
            theme: "bootstrap-5",
        });
        $("#regency_city_id").select2({
            theme: "bootstrap-5",
        });
    </script>
@endsection
