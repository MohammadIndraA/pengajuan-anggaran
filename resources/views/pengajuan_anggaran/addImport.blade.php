@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Blank Page</h1>
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
                        <form class="row g-2" action="{{ route('province-import.store') }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="col-md-6">
                                <label for="program" class="form-label">Program</label>
                                <select id="program" class="form-select @error('program') is-invalid @enderror"
                                    name="program">
                                    <option>Choose...</option>
                                    <option>1...</option>
                                    {{-- @foreach ($product_categories as $item)
                                    <option class="dark:text-slate-700" value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach --}}
                                </select>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                </select>
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
