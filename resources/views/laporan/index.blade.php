<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>10 UNIVERSITAS FAVORIT DI INDONESIA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <style>
        @page {
            size: A4
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
    </style>
</head>

<body class="A4">
    <section class="sheet padding-10mm">
        <h2 class="text-center">LAPORAN PENGAJUAN ANGGARAN PADA DARI {{ $from_date }} SAMPAI {{ $to_date }}</h2>
        <br>
        <br>
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
                @foreach ($data as $item)
                    @php
                        $total += $item['budget'];
                    @endphp
                    <tr>
                        <td class="text-center" width="20">{{ $loop->iteration }}</td>
                        <td>{{ $item['province']['name'] ?? $item['regency_city']['name'] }}</td>
                        <td> Rp.{{ number_format($item['budget'], 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col" colspan="2">Total Semua </th>
                    <th scope="col"> Rp.{{ number_format($total, 2, ',', '.') }}</th>
                </tr>
            </tfoot>
        </table>
    </section>
</body>

</html>
