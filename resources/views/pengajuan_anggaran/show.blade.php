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
                <section class="section">
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
                            <div class="justify-content-beetwen">
                                <a href="{{ url('pengajuan-anggaran/edit/' . $id) }}" class="btn btn-info mt-3"><i
                                        class="bi bi-plus me-1"></i> Tambah Pengajuan</a>
                                <h5 class="card-title">Pengajuan Anggaran
                                    {{ auth()->user()->role == 'admin' ? null : auth()->user()->role }}</h5>
                            </div>

                            <!-- Default Table -->
                            <table class="table table-responsive table-borderless" id="data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Program</th>
                                        <th scope="col">Kegiatan</th>
                                        <th scope="col">KRO</th>
                                        <th scope="col">RO</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Komponen</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Total</th>
                                        <th scope="col"><i class="ri-settings-3-line"></i></th>
                                    </tr>
                                </thead>
                            </table>
                            <!-- End Default Table Example -->
                        </div>
                    </div>


            </div>

        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $id = {{ $id }};
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ route('pengajuan-anggaran-import.index', $id) }}`,
                columns: [{
                        data: 'no',
                        name: 'no',
                        searchable: true
                    },
                    {
                        data: 'program',
                        name: 'program'
                    },
                    {
                        data: 'activity',
                        name: 'activity',
                    },
                    {
                        data: 'kro',
                        name: 'kro'
                    },
                    {
                        data: 'ro',
                        name: 'ro'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                    {
                        data: 'component',
                        name: 'component'
                    }, {
                        data: 'qty',
                        name: 'qty'
                    }, {
                        data: 'subtotal',
                        name: 'subtotal',
                        render: function(data, type, row, meta) {
                            return number_format(data);
                        }
                    }, {
                        data: null,
                        name: 'total',
                        render: function(data, type, row) {
                            return number_format(parseFloat(row.qty) * parseFloat(row
                                .subtotal));
                        }
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });

        });
    </script>
@endsection
