<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
</head>
<style>
    @page {
        size: A4 landscape;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f8f8f8;
        margin: 20px;
    }

    .container {
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }
</style>

<body>
    <div class="container">
        <h1>Wilayah: 01 DKI JAKARTA</h1>
        <table>
            <thead>
                <tr>
                    <th style="background-color: yellow; color: black">Wilayah</th>
                    <th style="background-color: yellow; color: black">{{ $prov[0]['wilayah_name'] }}</th>
                    <th style="background-color: yellow; color: black"></th>
                    <th style="background-color: yellow; color: black"></th>
                    <th style="background-color: yellow; color: black"></th>
                    <th style="background-color: yellow; color: black">{{ $prov[0]['wilayah_total'] }}</th>
                </tr>
                <tr>
                    <th>Code</th>
                    <th>Wilayah/Satker/Program/Kegiatan/KRO/RO/Komponen</th>
                    <th colspan="2">Volume</th>
                    <th>Satuan Harga</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td>{{ $prov[0]['satker_name'] }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $prov[0]['satker_total'] }}</td>
                </tr>
                <tr>
                    <td>025.09.WA</td>
                    <td>{{ $prov[0]['program_name'] }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>27.986.065.000</td>
                </tr>
                <tr>
                    <td>2150</td>
                    <td>{{ $prov[0]['activity_name'] }}</td>
                    <td>7</td>
                    <td>Layanan</td>
                    <td></td>
                    <td>27.986.065.000</td>
                </tr>
                <tr>
                    <td>2150.EBA.956</td>
                    <td>{{ $prov[0]['kro_name'] }}</td>
                    <td>1</td>
                    <td>Layanan</td>
                    <td></td>
                    <td>681.484</td>
                </tr>
                <tr>
                    <td>051</td>
                    <td>{{ $prov[0]['ro_name'] }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>306.630.000</td>
                </tr>

                @foreach ($prov as $item)
                    @if (isset($item['component_name']))
                        <!-- Cek jika ada component_name -->
                        <tr>
                            <td>{{ $item['component_code'] }}</td>
                            <td>{{ $item['component_name'] }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>306.630.000</td>
                        </tr>
                    @endif
                    @if (isset($item->subKomponen))
                        <!-- Cek subKomponen -->
                        @foreach ($item->subKomponen as $itemsubKomponen)
                            <tr>
                                <td>{{ $itemsubKomponen->sub_component_code }}</td>
                                <td>{{ $itemsubKomponen->sub_component_name }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Rp. {{ $itemsubKomponen->total }}</td>
                            </tr>
                            @if (isset($itemsubKomponen->poinSubComponent))
                                <!-- Cek poinSubComponent -->
                                @foreach ($itemsubKomponen->poinSubComponent as $itemPointSubComponent)
                                    <tr>
                                        <td>{{ $itemPointSubComponent->point_sub_component_code }}</td>
                                        <td>{{ $itemPointSubComponent->point_sub_component_name }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>Rp .{{ $itemPointSubComponent->total }}</td>
                                    </tr>
                                    @if (isset($itemPointSubComponent->wilayah))
                                        <!-- Cek wilayah -->
                                        @foreach ($itemPointSubComponent->wilayah as $itemWilayah)
                                            <tr>
                                                <td></td>
                                                <td>{{ $itemWilayah->wilayah_name }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td> {{ $itemWilayah->total }}</td>
                                            </tr>
                                            @if (isset($itemWilayah->subWilayah))
                                                <!-- Cek subWilayah -->
                                                @foreach ($itemWilayah->subWilayah as $subWilayah)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $subWilayah->sub_wilayah_name }}</td>
                                                        <td>{{ $subWilayah->qty }}</td>
                                                        <td>{{ $subWilayah->satuan }}</td>
                                                        <td>Rp. {{ $subWilayah->sub_total }}</td>
                                                        <td>Rp. {{ $subWilayah->total }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                @endforeach
                <!-- Tambahkan baris lainnya sesuai kebutuhan -->
            </tbody>
        </table>
    </div>
</body>

</html>
