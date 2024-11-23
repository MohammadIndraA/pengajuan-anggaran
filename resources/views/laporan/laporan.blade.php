@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Laporan Pengajuan Anggraran {{ auth()->user()->role == 'admin' ? null : auth()->user()->role }}</h1>
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
                        <div class="card-body">
                            <div class="card-header">
                                <div class="row">
                                    <h5 class="card-title col col-4">Laporan Pengajuan Anggaran</h5>
                                    <div class="form-group col col-2 mt-4">
                                        <select name="status" id="status" class="custom-select form-control"
                                            style="background: #fff; cursor: pointer; padding: 5px 5px; border: 1px solid #ccc; width: 100%; text-align:center">
                                            <option value="" disabled selected>Pilih salah satu</option>
                                            <option value="" selected>Semua</option>
                                            @foreach ($state as $item)
                                                <option value="{{ $item['location_id'] . ',' . $item['location_type'] }}">
                                                    {{ $item['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col col-4 mt-4">
                                        <div id="daterange" class="float-end"
                                            style="background: #fff; cursor: pointer; padding: 5px 5px; border: 1px solid #ccc; width: 100%; text-align:center">
                                            <i class="fa fa-calendar"></i>&nbsp;
                                            <span></span>
                                            <i class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <div class="col col-2 mt-4">
                                        <button type="button" class="btn btn-danger btn-sm w-100" id="export-pdf-button"
                                            style="padding: 5px;"><i class="bi bi-cloud-download me-1"></i> Download
                                            Laporan</button>
                                    </div>
                                </div>
                            </div>
                            <!-- Default Table -->
                            <table class="table table-responsive table-borderless" id="data-table">
                                <input type="hidden" id="selectedData" name="selectedData">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Wilayah</th>
                                        <th scope="col">Total Pengeluaran</th>
                                        <th scope="col">Tanggal Pengeluaran</th>
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


            var start_date = moment().subtract(1, 'M');

            var end_date = moment();

            $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format('MMMM D, YYYY'));

            $('#daterange').daterangepicker({
                autoUpdateInput: false,
                startDate: start_date,
                endDate: end_date
            }, function(start_date, end_date) {
                $('#daterange span').html(start_date.format('MMMM D, YYYY') + ' - ' + end_date.format(
                    'MMMM D, YYYY'));

                table.draw();
            });

            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('pengajuan-anggaran-laporan') }}",
                    data: function(data) {
                        data.from_date = $('#daterange').data('daterangepicker').startDate.format(
                            'YYYY-MM-DD');
                        data.to_date = $('#daterange').data('daterangepicker').endDate.format(
                            'YYYY-MM-DD');
                        data.status = $('[name=status]').val();

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
                        name: 'name',
                        searchable: true,
                        render: function(data, type, row) {
                            return row.province ? row.province.name : row.regency_city.name;
                        }
                    },
                    {
                        data: 'budget',
                        name: 'budget',
                        render: function(data, type, row, meta) {
                            return number_format(data);
                        }
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at',
                        render: function(data, type, row) {
                            if (data) {
                                const date = new Date(data);
                                const options = {
                                    day: '2-digit',
                                    month: 'long',
                                    year: 'numeric'
                                };
                                return date.toLocaleDateString('id-ID',
                                    options); // Format ke "20 Januari 2024"
                            }
                            return '-'; // Fallback jika data kosong
                        }
                    },

                ],
            });

            $('[name=status]').on('change', function() {
                table.ajax.reload();
            })

            $('#export-pdf-button').on('click', function() {

                var daterangepicker = $('#daterange').data('daterangepicker');
                var from_date = daterangepicker ? daterangepicker.startDate.format('YYYY-MM-DD') : null;
                var to_date = daterangepicker ? daterangepicker.endDate.format('YYYY-MM-DD') : null;
                var table = $('#data-table').DataTable();
                var rows = table.rows({
                    selected: true
                }).data();

                // Konversi data rows menjadi string JSON
                var data = JSON.stringify(rows.toArray());
                $('#selectedData').val(data); // Jika diperlukan, simpan di elemen input
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('generate-pdf') }}",
                    data: {
                        data: data, // Kirim data dalam format JSON
                        from_date: from_date,
                        to_date: to_date
                    },
                    success: function(res) {
                        // console.log(res.data);
                    }
                });
            });

        });
    </script>
@endsection
