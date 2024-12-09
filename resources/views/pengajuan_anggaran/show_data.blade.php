@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Pengajuan Anggraran</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Table</li>
            </ol>
        </nav>
    </div>
@endsection
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <section class="section">
                    <div class="card recent-sales overflow-auto">
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

                            <h5 class="card-title">Pengajuan Anggaran</h5>

                            {{-- select --}}
                            <div class="d-flex align-items-center justify-content-between">
                                <!-- Bagian 1: Dropdown Pilih Status -->
                                <div class="form-group col col-2 mb-3">
                                    <select class="form-select @error('status') is-invalid @enderror" name="status"
                                        id="status">
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="">Semua</option>
                                        <option value="rejected">Rejected</option>
                                        <option value="pending">Pending</option>
                                        <option value="proses">Proses</option>
                                        <option value="approved">Approved</option>
                                    </select>
                                </div>

                                <!-- Bagian 2: Dropdown Pilih Wilayah dan Tombol Unduh -->
                                <div class="d-flex justify-content-end">
                                    <!-- Dropdown Pilih Wilayah -->
                                    <div class="form-group mb-3">
                                        <select name="state" id="state" class="custom-select form-control"
                                            style="background: #fff; cursor: pointer; padding: 5px; border: 1px solid #ccc; 
                                                   width: 100%; text-align: center; border-radius: 4px;">
                                            <option value="" disabled selected>Pilih salah satu</option>
                                            <option value="" selected>Semua wilayah</option>
                                            @foreach ($name_regency as $item)
                                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Tombol Unduh Excel (Khusus untuk Role Province) -->
                                    @if (auth()->user()->role == 'province')
                                        <div class="form-group col col-4 mb-3 mx-2">
                                            <button type="button" class="btn btn-success btn-sm w-100"
                                                id="export-excel-button" style="padding: 6px;">
                                                <i class="ri ri-file-excel-2-fill me-1"></i>
                                                Excel</button>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            <!-- Default Table -->
                            <table class="table table-borderless" id="data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Wilayah</th>
                                        <th scope="col">Nama Pengajuan</th>
                                        <th scope="col">Jumlah Anggaran Keseluruhan</th>
                                        <th scope="col">Tanggal Pengajuan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Aksi</th>
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
        $("#state").select2({
            theme: "bootstrap-5",
        });

        var url = "";
        if (window.location.pathname === '/pengajuan-anggaran-departement/province') {
            url = 'pengajuan-anggaran-departement/province';
        } else if (window.location.pathname === '/pengajuan-anggaran-departement/regency') {
            url = 'pengajuan-anggaran-departement/regency';
        } else if (window.location.pathname === '/pengajuan-anggaran-departement/departement') {
            url = 'pengajuan-anggaran-departement/departement';
        } else if (window.location.pathname === '/pengajuan-anggaran-departement/division') {
            url = 'pengajuan-anggaran-departement/division';
        }
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ url('${url}') }}`,
                    data: function(d) {
                        d.status = $('#status').val();
                        d.state = $('#state').val();
                    }
                },
                columns: [{
                        targets: 0, // Kolom pertama (index 0)  
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Nomor urut  
                        }
                    },
                    {
                        data: null,
                        name: 'province_or_regency',
                        searchable: true,
                        render: function(data, type, row) {
                            return row.province ? row.province.name : row.regency_city.name;
                        }
                    },
                    {
                        data: 'submission_name',
                        name: 'submission_name',
                        searchable: true
                    },
                    {
                        data: 'budget',
                        name: 'budget',
                        render: function(data, type, row, meta) {
                            return number_format(data);
                        }
                    },
                    {
                        data: 'submission_date',
                        name: 'submission_date'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, row, meta) {
                            if (data == "pending") {
                                return `<span class="badge rounded-pill bg-secondary">pending</span>`
                            }
                            if (data == "proses") {
                                return `<span class="badge rounded-pill bg-warning">Proses</span>`
                            }
                            if (data == "approved") {
                                return `<span class="badge rounded-pill bg-success">Approved</span>`
                            }
                            if (data == "rejected") {
                                return `<span class="badge rounded-pill bg-danger">rejected</span>`
                            }
                            return data;
                        }
                    },
                    {
                        data: 'deskription',
                        name: 'deskription'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#status').on('change', function() {
                table.draw();
            });

            $('#state').on('change', function() {
                table.draw();
            });

        });
        $('#export-excel-button').on('click', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Menggunakan window.location untuk mengunduh file
            window.location.href = "/downloadExcelAsZip";
        });
    </script>
@endsection
