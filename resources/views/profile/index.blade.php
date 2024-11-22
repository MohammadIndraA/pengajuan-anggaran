@extends('layouts.main')

@section('breadcrumb')
<div class="pagetitle">
    <h1>Halaman Profil</h1>
</div>
@endsection

@section('content')
<section class="section profile">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-xl-4">

            <div class="card">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                    <!-- <img src="{{ asset('design/assets/img/profile-img.jpg') }}" alt="Profil" class="rounded-circle"> -->
                    <h2>{{$profile['username']}}</h2>
                    <h3>{{$profile['email']}}</h3>

                </div>
            </div>

        </div>

        <div class="col-xl-8">

            <div class="card">
                <div class="card-body pt-3">
                    <!-- Tab Terbatas -->
                    <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#profile-overview">Ringkasan</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profil</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Ganti
                                Kata Sandi</button>
                        </li>

                    </ul>
                    <div class="tab-content pt-2">

                        <div class="tab-pane fade show active profile-overview" id="profile-overview">

                            <h5 class="card-title">Detail Profil</h5>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Nama</div>
                                <div class="col-lg-9 col-md-8">{{$profile['name']}}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label ">Username</div>
                                <div class="col-lg-9 col-md-8">{{$profile['username']}}</div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-4 label">Email</div>
                                <div class="col-lg-9 col-md-8">{{$profile['email']}}</div>
                            </div>

                        </div>

                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                            <!-- Form Edit Profil -->
                            <form method="POST" action="{{ route('profile.update', ['id' => $profile['id']]) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <label for="Name" class="col-md-4 col-lg-3 col-form-label">Nama</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="name" type="text" class="form-control" id="Name" value="{{ old('name', $profile['name']) }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="username" class="col-md-4 col-lg-3 col-form-label">Username</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="username" type="text" class="form-control" id="username" value="{{ old('username', $profile['username']) }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="email" type="email" class="form-control" id="Email" value="{{ old('email', $profile['email']) }}">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                                </div>
                            </form>
                            <!-- akhir -->

                        </div>

                        <div class="tab-pane fade pt-3" id="profile-change-password">
                            <form method="POST" action="{{ route('profile.changePassword') }}">
                                @csrf

                                <div class="row mb-3">
                                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Kata Sandi Saat Ini</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="password" type="password" class="form-control" id="currentPassword" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Kata Sandi Baru</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword" type="password" class="form-control" id="newPassword" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="newpassword_confirmation" class="col-md-4 col-lg-3 col-form-label">Masukkan Kembali Kata Sandi Baru</label>
                                    <div class="col-md-8 col-lg-9">
                                        <input name="newpassword_confirmation" type="password" class="form-control" id="newpassword_confirmation" required>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-info">Ganti Kata Sandi</button>
                                </div>
                            </form>

                        </div>

                    </div><!-- End Tab Terbatas -->

                </div>
            </div>

        </div>
    </div>
</section>


@endsection

@section('script')

@endsection