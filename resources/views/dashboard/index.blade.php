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

                    @if (Auth::user()->role === 'pusat')
                        <!-- Provinsi Card -->
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
                                            <li><button type="submit" class="dropdown-item" name="type">Today</button>
                                            </li>
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
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            Rp.
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ number_format($expenditureProvince) }}</h6>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Provinsi Card -->

                        <!-- Departement Card -->
                        <div class="col-xxl-4 col-md-6">

                            <div class="card info-card customers-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <form method="GET">
                                            <li><button type="submit" class="dropdown-item" name="type">Today</button>
                                            </li>
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
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            Rp.
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ number_format($expenditureDep) }}</h6>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Departement Card -->

                        <!-- Division Card -->
                        <div class="col-xxl-4 col-md-6">

                            <div class="card info-card customers-card">

                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <form method="GET">
                                            <li><button type="submit" class="dropdown-item" name="type">Today</button>
                                            </li>
                                            <li><button type="submit" class="dropdown-item" value="division_monthly"
                                                    name="type">This
                                                    Month</button>
                                            </li>
                                            <li><button type="submit" class="dropdown-item" value="division_yearly"
                                                    name="type">This
                                                    Year</button>
                                            </li>
                                        </form>
                                    </ul>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">Divisi <span>| Today</span></h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            Rp.
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ number_format($expenditureDivision) }}</h6>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Departement Card -->

                        <div class="col-xxl-4 col-md-6">

                            <div class="card info-card customers-card">
                                <div class="card-body">
                                    <h5 class="card-title">Approved <span>| Semua</span></h5>

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



                    <!-- Kota Kabupaten -->
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
                                        <li><button type="submit" class="dropdown-item" name="type">Today</button>
                                        </li>
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
                    </div><!-- End Kota Kabupaten -->

                    @if (Auth::user()->role === 'pusat')
                        <!-- Chart Information Semua -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Budget <span>| This Year</span></h5>

                                    <!-- Line Chart -->
                                    <div id="reportsChart"></div>
                                    @php
                                        $regency_budget_chart_str = implode(', ', $regency_budget_chart);
                                        $province_budget_chart_str = implode(', ', $province_budget_chart);
                                        $departement_budget_chart_str = implode(', ', $departement_budget_chart);
                                        $division_budget_chart_str = implode(', ', $division_budget_chart);
                                    @endphp

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            new ApexCharts(document.querySelector("#reportsChart"), {
                                                series: [{
                                                    name: 'Kabupaten/Kota',
                                                    data: [{{ $regency_budget_chart_str }}]
                                                }, {
                                                    name: 'Provinsi',
                                                    data: [{{ $province_budget_chart_str }}]

                                                }, {
                                                    name: 'Departemen',
                                                    data: [{{ $departement_budget_chart_str }}]

                                                }, {
                                                    name: 'Divisi',
                                                    data: [{{ $division_budget_chart_str }}]

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
                                                colors: ['#4154f1', '#2eca6a', '#ff771d', '#ffbb44'],
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
                                                    type: 'month',
                                                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                                                        "Nov", "Dec"
                                                    ],

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
                        </div><!-- End Chart Information Semua -->
                        <!-- Table Information -->
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
                        </div><!-- End Table Information -->
                    @endif

                    @if (Auth::user()->role === 'departement')
                        <!-- Provinsi Card -->
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
                                            <li><button type="submit" class="dropdown-item"
                                                    name="type">Today</button>
                                            </li>
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
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            Rp.
                                        </div>
                                        <div class="ps-3">
                                            <h6>{{ number_format($expenditureProvince) }}</h6>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Provinsi Card -->

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Pengeluaran Provinsi</h5>

                                    <!-- Line Chart -->
                                    <div id="lineChart"></div>
                                    @php
                                        $province_budget_departemen_str = implode(
                                            ', ',
                                            $province_budget_departemen_chart,
                                        );
                                    @endphp

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            new ApexCharts(document.querySelector("#lineChart"), {
                                                series: [{
                                                    name: "Desktops",
                                                    data: [{{ $province_budget_departemen_str }}]
                                                }],
                                                chart: {
                                                    height: 350,
                                                    type: 'line',
                                                    zoom: {
                                                        enabled: false
                                                    }
                                                },
                                                dataLabels: {
                                                    enabled: false
                                                },
                                                stroke: {
                                                    curve: 'straight'
                                                },
                                                grid: {
                                                    row: {
                                                        colors: ['#f3f3f3',
                                                            'transparent'
                                                        ], // takes an array which will be repeated on columns
                                                        opacity: 0.5
                                                    },
                                                },
                                                xaxis: {
                                                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct",
                                                        "Nov", "Dec"
                                                    ],
                                                }
                                            }).render();
                                        });
                                    </script>
                                    <!-- End Line Chart -->

                                </div>
                            </div>
                        </div>
                    @endif


                    @if (Auth::user()->role === 'province')
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Pengeluaran Bulanan Kota Kabupaten </h5>

                                    <!-- Vertical Bar Chart -->
                                    <div id="verticalBarChart" style="min-height: 400px;" class="echart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                            echarts.init(document.querySelector("#verticalBarChart")).setOption({
                                                tooltip: {
                                                    trigger: 'axis',
                                                    axisPointer: {
                                                        type: 'shadow'
                                                    }
                                                },
                                                legend: {},
                                                grid: {
                                                    left: '3%',
                                                    right: '4%',
                                                    bottom: '3%',
                                                    containLabel: true
                                                },
                                                xAxis: {
                                                    type: 'value',
                                                    boundaryGap: [0, 0.01]
                                                },
                                                yAxis: {
                                                    type: 'category',
                                                    data: [{!! $name_regency_str !!}]
                                                },
                                                series: [{
                                                    name: '{{ now() }}',
                                                    type: 'bar',
                                                    data: [{{ $budget_per_regency_str }}]
                                                }, ]
                                            });
                                        });
                                    </script>
                                    <!-- End Vertical Bar Chart -->

                                </div>
                            </div>
                        </div>
                    @endif



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
