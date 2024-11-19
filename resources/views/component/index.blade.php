@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Page Komponent</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Komponent</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Komponent</li>
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
                            <a href="" onClick="add()" href="javascript:void(0)" class="btn btn-info mt-3 ml-0"
                                data-bs-toggle="modal" data-bs-target="#component-modal"><i class="bi bi-plus me-1"></i>
                                Tambah
                                Komponent</a>
                            <h5 class="card-title">Tabel Komponent
                                {{ auth()->user()->role == 'admin' ? null : auth()->user()->role }}</h5>

                            <!-- Default Table -->
                            <table class="table table-responsive table-borderless" id="data-table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Code Uniq</th>
                                        <th scope="col">Nama Komponent</th>
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
    <div class="modal fade" id="component-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="componentText"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="javascript:void(0)" id="componentForm">
                    <div class="modal-body">
                        {{-- alert --}}
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>
                        {{-- end --}}
                        <input type="hidden" name="id" id="id">
                        <div class="col-12">
                            <label for="component_name" class="form-label">Nama Component</label>
                            <input type="text" class="form-control" name="component_name" id="component_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info" id="component-simpan">Simpan</button>
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
                ajax: "{{ url('component') }}",
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
                        data: 'component_code',
                        name: 'component_code',

                    },
                    {
                        data: 'component_name',
                        name: 'component_name'
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

            $('#componentForm').trigger("reset");
            $('#componentText').html("Tambah Data Component");
            $('#component-modal').modal('show');
            $('#id').val('');

        }

        function editFunc(id) {

            $.ajax({
                type: "POST",
                url: "{{ url('component-edit') }}",
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(res) {
                    $('#componentText').html("Edit Data Component");
                    $('#component-modal').modal('show');
                    $('#id').val(res.id);
                    $('#component_name').val(res.component_name);
                }
            });
        }

        function deleteFunc(id) {
            if (confirm("Delete Record?") == true) {
                var id = id;

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('component-delete') }}",
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

        $('#componentForm').submit(function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('component-store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#component-modal").modal('hide');
                    var oTable = $('#data-table').dataTable();
                    oTable.fnDraw(false);
                    $("#component-simpan").html('Submit');
                    $("#component-simpan").attr("disabled", false);
                },
                error: function(data) {
                    $('#componentForm').find(".print-error-msg").find("ul").html('');
                    $('#componentForm').find(".print-error-msg").css('display', 'block');
                    $.each(response.responseJSON.errors, function(key, value) {
                        $('#componentForm').find(".print-error-msg").find("ul").append('<li>' +
                            value + '</li>');
                    });
                    console.log(data);
                }
            });
        });
    </script>
@endsection
