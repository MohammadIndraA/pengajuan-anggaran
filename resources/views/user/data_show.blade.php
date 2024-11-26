@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Page user</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Progam</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">user</li>
            </ol>
        </nav>
    </div>
@endsection
@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <section class="section">
                    <div class="card overflow-auto">
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

                            <a href="{{ url('user-create') }}" class="btn btn-info btn-sm mt-3 ml-0"><i
                                    class="bi bi-plus me-1"></i>
                                Tambah
                                user</a>
                            <h5 class="card-title">Tabel user
                                {{ auth()->user()->role == 'admin' ? null : auth()->user()->role }}</h5>

                            <!-- Default Table -->
                            <table class="table table-responsive table-borderless" id="data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Wilayah</th>
                                        <th scope="col">Nama Provinsi</th>
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
        var url = "";
        if (window.location.pathname === '/manage-account-province') {
            url = 'manage-account-province';
        } else if (window.location.pathname === '/manage-account-regency') {
            url = 'manage-account-regency';
        } else if (window.location.pathname === '/manage-account-departement') {
            url = 'manage-account-departement';
        } else if (window.location.pathname === '/manage-account-division') {
            url = 'manage-account-division';
        }

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ '${url}' }}`,
                columnDefs: [{
                    targets: 0, // Kolom pertama (index 0) 
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + 1; // Nomor urut 
                    }
                }],
                columns: [{
                        data: 'null',
                        name: 'id'
                    },
                    {
                        data: 'username',
                        name: 'username',

                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'regency_city.name',
                        name: 'regency_city.name'
                    },
                    {
                        data: 'province.name',
                        name: 'province.name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ],
                order: [
                    [0, 'asc']
                ]
            });


        });

        function deleteFunc(id) {
            if (confirm("Delete Record?") == true) {
                var id = id;

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('user-delete') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {

                        var oTable = $('#data-table').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }
    </script>
@endsection
