<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>10 UNIVERSITAS FAVORIT DI INDONESIA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <style>
        @page {
            size: A4 landscape;
        }

        h1 {
            font-weight: bold;
            font-size: 20pt;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th {
            padding: 8px 8px;
            border: 1px solid #000000;
            text-align: center;
        }

        .table td {
            padding: 3px 3px;
            border: 1px solid #000000;
        }

        .text-center {
            text-align: center;
        }

        .letter_head {
            width: 100%;
            border-collapse: collapse;
            border: 0;
            margin: 0;
            font-family: Tahoma, Geneva, sans-serif;
            font-size: 1em;
        }

        .letter_head td {
            vertical-align: top;
            padding: 5px 1px;
            text-align: center;
        }

        .letter_head td.two {
            /* xxx : yyy; */
        }

        .letter_head td.line {
            border-top: 4px solid;
            border-bottom: 1px solid;
            padding: 1px 0;
        }

        .letter_head .title {
            margin-bottom: 1px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
        }

        .letter_head .title-1 {
            font-weight: bold;
        }

        .letter_head .title-2 {
            font-family: "Times New Roman", Times, serif;
            font-weight: bold;
            font-size: 1.7em;
            letter-spacing: 2px;
        }

        .letter_head .title-3 {
            font-size: 80%;
        }

        .letter_head .title-4 {
            font-weight: bold;
        }

        .logo {
            margin: 0 auto;
            display: block;
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body class="A4">
    <table class="letter_head">
        <tr>
            <td class="one">
                <img class="logo" alt="Logo"
                    src="https://3.bp.blogspot.com/-7WhUsOL-hGc/V7lLC6vayjI/AAAAAAAADcc/5qZLgen8HZEH_X2Wue4nOuAo2WZe5SMRwCLcB/s1600/Kalimantan_Tengah.png"
                    width="100" height="100" />
            </td>
            <td class="two">
                <div class="title title-1">
                    BADAN PENGELOLA KEUANGAN HAJI
                </div>
                <div class="title title-3">
                    Jalan Lapangan Banteng Barat No. 3-4, Jakarta 10710
                    <span>&#9742;</span> 021 348 3304-20 – 021 3811789 <br>
                </div>
                <div class="title title-4">
                    birohdi@kemenag.go.id
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="line"></td>
        </tr>
    </table>


    <section class="sheet padding-10mm">
        <h2 class="text-center" style="text-transform: uppercase">LAPORAN PENGAJUAN ANGGARAN <br>
            {{ $data[0]['province_name'] }}</h2>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NAMA WILAYAH</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @php
                    $total += $prov['budget'];
                @endphp
                <tr>
                    <td class="text-center" width="20">{{ 1 }}</td>
                    <td>{{ $prov['province']['name'] }}</td>
                    <td> Rp.{{ number_format($prov['budget'], 2, ',', '.') }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col" colspan="2">Total Semua </th>
                    <th scope="col"> Rp.{{ number_format($total, 2, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </section>


    <br>
    <br>
    <br>
    <br>
    @foreach ($regencys as $id => $items)
        <section class="sheet padding-10mm">
            <h2 class="text-center" style="text-transform: uppercase">LAPORAN PENGAJUAN {{ $regencys_name[$id - 1] }}
            </h2>
            <br>
            <table class="table">
                <thead>
                    <th>NO.</th>
                    <th>PROGRAM</th>
                    <th>KEGIATAN</th>
                    <th>KRO</th>
                    <th>RO</th>
                    <th>SATUAN</th>
                    <th>KOMPONEN</th>
                    <th>QTY</th>
                    <th>SUB TOTAL</th>
                    <th>TOTAL</th>
                    </tr>

                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($items as $data)
                        @php
                            $total += $data['total'];
                        @endphp
                        <tr>
                            <td class="text-center" width="20">{{ $loop->iteration }}</td>
                            {{-- <td>{{ $data['regency_name'] ?? $data['region_name'] }}</td> --}}
                            <td>{{ $data['program'] }}</td>
                            <td>{{ $data['activity'] }}</td>
                            <td>{{ $data['kro'] }}</td>
                            <td>{{ $data['ro'] }}</td>
                            <td>{{ $data['unit'] }}</td>
                            <td>{{ $data['component'] }}</td>
                            <td>{{ $data['qty'] }}</td>
                            <td>RP. {{ number_format($data['subtotal'], 2, ',', '') }}</td>
                            <td> Rp.{{ number_format($data['total'], 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col" colspan="9">Total Semua </th>
                        <th scope="col"> Rp.{{ number_format($total, 2, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </section>
        <br>
        <br>
        <br>
    @endforeach
</body>

</html>
