<!DOCTYPE html>
<html>

<head>
    <title>Laporan PDF DOMPDF Laravel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>

    <center>
        <h5> Laporan Data H2H</h4>
            <!-- <h5></h5> -->
            <hr>
            <h5>{{$data->no_pk}}</h5>
    </center>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="m-0">Informasi Registrasi</h5>
        </div>
        <div class="card-body">

            <table class="table">
                <tbody>
                    <tr>
                        <td>Nomor Registrasi</td>
                        <td>:</td>
                        <td> {{ $data->no_pk }} </td>
                    </tr>
                    <tr>
                        <td>Nomor Polis</td>
                        <td>:</td>
                        <td> {{ $data->no_polis }} </td>
                    </tr>
                    <tr>
                        <td>jenis_kredit</td>
                        <td>:</td>
                        <td>{{ $data->jenis_kredit }}</td>
                    </tr>
                    <tr>
                        <td>Periode Polis</td>
                        <td>:</td>
                        <td>{{ $data->periode_awal_asuransi . ' / ' .
$data->periode_akhir_asuransi }} </td>
                    </tr>
                    <tr>
                        <td>Jenis Cover</td>
                        <td>:</td>
                        <td> {{$data->jenis_cover}} </td>
                    </tr>
                    <tr>
                        <td>Nilai Harga Pertanggungan</td>
                        <td>:</td>
                        <td> Rp. {{ number_format($data->plafon_kredit , 0, ',', '.') }} </td>

                    </tr>
                    <tr>
                        <td>Status Pengajuan</td>
                        <td>:</td>
                        <td> <b>Accept</b> </td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="m-0">Informasi Klien</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Nama Client</td>
                        <td>:</td>
                        <td> {{ $data->customer->branch_name }} </td>
                    </tr>
                    <tr>
                        <td>No Identitas</td>
                        <td>:</td>
                        <td> {{ $data->customer->nomor_identitas }} </td>
                    </tr>
                    <tr>
                        <td>Nama Peserta</td>
                        <td>:</td>
                        <td> {{ $data->customer->nama_peserta }} </td>
                    </tr>
                    <tr>
                        <td>No Telepon</td>
                        <td>:</td>
                        <td>{{ $data->customer->no_telpon }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $data->customer->alamat }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <table id="table" class="table" style="width: 800px;">
        <thead>
            <tr role="row">
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 63px;">Rate Code</th>
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 118px;">Deskripsi</th>
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 80px;">Rate</th>
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 63px;">Unit</th>
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 63px;">Scaling</th>
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 63px;">Premium</th>
                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 276px;">Periode</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach($data->perluasan as $item)
                <td>{{ $item->rate_code }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->rate }}%</td>
                <td>C</td>
                <td>{{ $item->scaling }}</td>
                <td>{{ $item->premium }}</td>
                <td>{{ $data->periode_awal_asuransi . ' / ' .
$data->periode_akhir_asuransi }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>

</body>

</html>