@extends('layouts.main')

@section('breadcrumb')
    <div class="pagetitle">
        <h1>Page Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
@endsection
@section('content')
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <form method="GET">
                                        <li><button type="submit" class="dropdown-item" name="type">Today</button></li>
                                        <li><button type="submit" class="dropdown-item" value="province_monthly"
                                                name="type">This
                                                Month</button>
                                        </li>
                                        <li><button type="submit" class="dropdown-item" value="province_yearly"
                                                name="type">This
                                                Year</button>
                                        </li>
                                    </form>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Provinsi <span>| Today</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        Rp.
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ number_format($expenditureProvince) }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Sales Card -->

                    <!-- Revenue Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <form method="GET">
                                        <li><button type="submit" class="dropdown-item" name="type">Today</button></li>
                                        <li><button type="submit" class="dropdown-item" value="regency_monthly"
                                                name="type">This
                                                Month</button>
                                        </li>
                                        <li><button type="submit" class="dropdown-item" value="regency_yearly"
                                                name="type">This
                                                Year</button>
                                        </li>
                                    </form>

                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Koba/Kabupaten <span>| Today</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        Rp.
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ number_format($expenditureRegency) }}</h6>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Revenue Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <form method="GET">
                                        <li><button type="submit" class="dropdown-item" name="type">Today</button></li>
                                        <li><button type="submit" class="dropdown-item" value="departement_monthly"
                                                name="type">This
                                                Month</button>
                                        </li>
                                        <li><button type="submit" class="dropdown-item" value="departement_yearly"
                                                name="type">This
                                                Year</button>
                                        </li>
                                    </form>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Departemen <span>| Today</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        Rp.
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ number_format($expenditureDep) }}</h6>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->
                    @if (Auth::user()->role === 'departement')
                        <div class="col-xxl-4 col-xl-12">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Approved <span>| Today</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            Rp.
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ number_format($amount) }}</h6>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->
                    @endif

                    <!-- Reports -->
                    <div class="col-12">
                        <div class="card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>

                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Departement <span>/Today</span></h5>

                                <!-- Line Chart -->
                                <div id="reportsChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        new ApexCharts(document.querySelector("#reportsChart"), {
                                            series: [{
                                                name: 'Sales',
                                                data: [31, 40, 28, 51, 42, 82, 56],
                                            }, {
                                                name: 'Revenue',
                                                data: [11, 32, 45, 32, 34, 52, 41]
                                            }, {
                                                name: 'Customers',
                                                data: [15, 11, 32, 18, 9, 24, 11]
                                            }],
                                            chart: {
                                                height: 350,
                                                type: 'area',
                                                toolbar: {
                                                    show: false
                                                },
                                            },
                                            markers: {
                                                size: 4
                                            },
                                            colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                            fill: {
                                                type: "gradient",
                                                gradient: {
                                                    shadeIntensity: 1,
                                                    opacityFrom: 0.3,
                                                    opacityTo: 0.4,
                                                    stops: [0, 90, 100]
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                curve: 'smooth',
                                                width: 2
                                            },
                                            xaxis: {
                                                type: 'datetime',
                                                categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z",
                                                    "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z",
                                                    "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                                                    "2018-09-19T06:30:00.000Z"
                                                ]
                                            },
                                            tooltip: {
                                                x: {
                                                    format: 'dd/MM/yy HH:mm'
                                                },
                                            }
                                        }).render();
                                    });
                                </script>
                                <!-- End Line Chart -->

                            </div>

                        </div>
                    </div><!-- End Reports -->

                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="card-body">
                                <h5 class="card-title">Pengajuan Laporan<span></span></h5>

                                <table class="table table-borderless" id="data-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Wilayah</th>
                                            <th scope="col">Nama Pengajuan</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Recent Sales -->


                </div>
            </div><!-- End Left side columns -->

        </div>
    </section>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: `{{ route('dashboard') }}`,
                columns: [{
                        targets: 0, // Kolom pertama (index 0)  
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Nomor urut  
                        }
                    },
                    {
                        data: null,
                        name: 'row.province',
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
                ]
            });

        });
    </script>
@endsection
