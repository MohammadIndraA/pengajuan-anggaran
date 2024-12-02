@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Pengajuan Anggraran {{ auth()->user()->role == 'admin' ? null : auth()->user()->role }}</h1>
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
                    <div class="card">
                        <div class="card-body overflow-auto">
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
                            <a href="{{ route('pengajuan-anggaran.create') }}" class="btn btn-info mt-3"
                                style="border-radius: 0px"><i class="bi bi-plus me-1"></i> Tambah Pengajuan</a>
                            <h5 class="card-title">Pengajuan Anggaran
                                {{ auth()->user()->role == 'admin' ? null : auth()->user()->role }}</h5>
                            {{-- select wilayah --}}
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="form-group col col-2 mt-1 mb-3">
                                    <select class="form-select @error('status') is-invalid @enderror" name="status"
                                        id="status">
                                        <option value="" disabled selected>Pilih Status</option>
                                        <option value="">Semua</option>
                                        <option value="rejected">Rejected
                                        </option>
                                        <option value="pending">Pending
                                        </option>
                                        <option value="proses">Proses
                                        </option>
                                        <option value="approved">Approved
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- Default Table -->
                            <table class="table table-responsive table-borderless" id="data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Pengajuan</th>
                                        <th scope="col">Sumber Dana</th>
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


        $(document).ready(function() {

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: `{{ route('pengajuan-anggaran.index') }}`,
                    data: function(data) {
                        data.status = $('#status').val();
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
                        data: 'submission_name',
                        name: 'submission_name',
                        searchable: true
                    },
                    {
                        data: 'funding_source.funding_source_name',
                        name: 'funding_source.funding_source_name'
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
                                return `<span class="badge rounded-pill bg-warning">proces</span>`
                            }
                            if (data == "approved") {
                                return `<span class="badge rounded-pill bg-success">approved</span>`
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

            // cari status
            $('#status').on('change', function() {
                table.ajax.reload();
            })
        });
    </script>
@endsection
