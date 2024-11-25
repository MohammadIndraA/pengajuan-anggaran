@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Page Departement</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Departement</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Departement</li>
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
                            <a href="" onClick="add()" href="javascript:void(0)" class="btn btn-info mt-3 ml-0"
                                data-bs-toggle="modal" data-bs-target="#departement-modal"><i class="bi bi-plus me-1"></i>
                                Tambah
                                Departement</a>
                            <h5 class="card-title">Tabel Departement
                                {{ auth()->user()->role == 'admin' ? null : auth()->user()->role }}</h5>

                            <!-- Default Table -->
                            <table class="table table-responsive table-borderless" id="data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Code Uniq</th>
                                        <th scope="col">Nama Departement</th>
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

    <!-- Basic Modal -->
    <div class="modal fade" id="departement-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="departementText"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="javascript:void(0)" id="departementForm">
                    <div class="modal-body">
                        {{-- alert --}}
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        {{-- end --}}
                        <input type="hidden" name="id" id="id">
                        <div class="col-12">
                            <label for="departement_name" class="form-label">Nama Departement</label>
                            <input type="text" class="form-control" name="departement_name" id="departement_name"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info" id="departement-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- End Basic Modal-->
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('departement') }}",
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
                        data: 'departement_code',
                        name: 'departement_code',

                    },
                    {
                        data: 'departement_name',
                        name: 'departement_name'
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

        function add() {

            $('#departementForm').trigger("reset");
            $('#departementText').html("Tambah Data Departement");
            $('#departement-modal').modal('show');
            $('#id').val('');

        }

        function editFunc(id) {

            $.ajax({
                type: "POST",
                url: "{{ url('departement-edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#departementText').html("Edit Data Departement");
                    $('#departement-modal').modal('show');
                    $('#id').val(res.id);
                    $('#departement_name').val(res.departement_name);
                }
            });
        }

        function deleteFunc(id) {
            if (confirm("Delete Record?") == true) {
                var id = id;

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('departement-delete') }}",
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

        $('#departementForm').submit(function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('departement-store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#departement-modal").modal('hide');
                    var oTable = $('#data-table').dataTable();
                    oTable.fnDraw(false);
                    $("#departement-simpan").html('Submit');
                    $("#departement-simpan").attr("disabled", false);
                },
                error: function(data) {
                    $('#departementForm').find(".print-error-msg").find("ul").html('');
                    $('#departementForm').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#departementForm').find(".print-error-msg").find("ul").append(
                            '<li>' +
                            value + '</li>');
                    });
                    console.log(data);
                }
            });
        });
    </script>
@endsection
