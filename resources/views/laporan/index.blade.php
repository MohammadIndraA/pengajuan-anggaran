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
    </style>
</head>

<body class="A4">
    <section class="sheet padding-10mm">
        <h2 class="text-center" style="text-transform: uppercase">LAPORAN PENGAJUAN <br>
            {{ $data[0]['regency_name'] ?? '' }}</h2>
        <br>
        <br>
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
                @foreach ($regency as $item)
                    @php
                        $total += $item['total'];
                    @endphp
                    <tr>
                        <td class="text-center" width="20">{{ $loop->iteration }}</td>
                        {{-- <td>{{ $item['regency_name'] ?? $item['region_name'] }}</td> --}}
                        <td>{{ $item['program'] }}</td>
                        <td>{{ $item['activity'] }}</td>
                        <td>{{ $item['kro'] }}</td>
                        <td>{{ $item['ro'] }}</td>
                        <td>{{ $item['unit'] }}</td>
                        <td>{{ $item['component'] }}</td>
                        <td>{{ $item['qty'] }}</td>
                        <td>RP. {{ number_format($item['subtotal'], 2, ',', '') }}</td>
                        <td> Rp.{{ number_format($item['total'], 2, ',', '.') }}</td>
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
</body>

</html>
