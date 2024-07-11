<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>A4</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css for happy printing -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
        @page {
            size: A4
        }

        #title {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
            font-size: 18px;
        }

        .tabeldatakaryawan {
            margin-top: 40px;
        }

        .tabeldatakaryawan td {
            padding: 5px;
        }

        .tabelpresensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            text-align: center;
        }

        .tabelpresensi tr th {
            border: 1px solid #131212;
            padding: 8px;
            background-color: #dbdbdb;
        }

        .tabelpresensi tr td {
            border: 1px solid #131212;
            padding: 5px;
            font-size: 12px;
        }

        .foto {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->

<body class="A4">
    @php
        function selisih($jam_masuk, $jam_keluar)
        {
            [$h, $m, $s] = explode(':', $jam_masuk);
            $dtAwal = mktime($h, $m, $s, '1', '1', '1');
            [$h, $m, $s] = explode(':', $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode('.', $totalmenit / 60);
            $sisamenit = $totalmenit / 60 - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ':' . round($sisamenit2);
        }
    @endphp

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm">
        <table style="width: 100%">
            <tr>
                <td style="width: 30px">
                    <img src="{{ asset('assets/img/logo_smp_islam_parung.png') }}" width="110" height="110"
                        alt="">
                </td>

                <td>
                    <span id="title">
                        LAPORAN PRESENSI KARYAWAN<br />
                        PERIODE {{ strtoupper($nama_bulan[$bulan]) }} {{ $tahun }}<br />
                        SMP ISLAM PARUNG<br />
                    </span>
                    <span>Jl. Raya Parung No. 648, Parung, Kec. Parung, Kab. Bogor Prov. Jawa Barat</span>
                </td>
            </tr>
        </table>

        <table class="tabeldatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('uploads/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="Foto Karyawan" width="110" height="150">
                </td>
            </tr>
            <tr>
                <td>NIP</td>
                <td> : </td>
                <td>{{ $karyawan->nip }}</td>
            </tr>

            <tr>
                <td>Nama Karyawan</td>
                <td> : </td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>

            <tr>
                <td>Pendidikan</td>
                <td> : </td>
                <td>{{ $karyawan->pendidikan }}</td>
            </tr>

            <tr>
                <td>Jabatan</td>
                <td> : </td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>

            <tr>
                <td>Nomor Telepon</td>
                <td> : </td>
                <td>{{ $karyawan->nomor_hp }}</td>
            </tr>
        </table>

        <table class="tabelpresensi">
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto</th>
                <th>Jam Pulang</th>
                <th>Foto</th>
                <th>Keterangan</th>
                <th>Jumlah Jam</th>
            </tr>

            @foreach ($presensi as $d)
                @php
                    $path_in = Storage::url('uploads/presensi/' . $d->foto_in);
                    $path_out = Storage::url('uploads/presensi/' . $d->foto_out);
                    $jam_terlambat = selisih('07:30:00', $d->jam_in);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->tanggal_presensi)) }}</td>
                    <td>{{ $d->jam_in }}</td>
                    <td><img src="{{ url($path_in) }}" alt="Foto Karyawan Masuk" class="foto"></td>
                    <td>{{ $d->jam_out != null ? $d->jam_out : 'Belum Presensi' }}</td>
                    <td>
                        @if ($d->jam_out != null)
                            <img src="{{ url($path_out) }}" alt="" class="foto">
                        @else
                            <img src="{{ asset('assets/img/photo-camera.png') }}" alt="" class="foto">
                        @endif
                    </td>
                    <td>
                        @if ($d->jam_in > '07:30')
                            Terlambat {{ $jam_terlambat }}
                        @else
                            Tepat Waktu
                        @endif
                    </td>

                    <td>
                        @if ($d->jam_out != null)
                            @php
                                $jmljamkerja = selisih($d->jam_in, $d->jam_out);
                            @endphp
                        @else
                            @php
                                $jmljamkerja = 0;
                            @endphp
                        @endif
                        {{ $jmljamkerja }}
                    </td>
                </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top:100px">
            <tr>
                <td colspan="2" style="text-align: right">Bogor, {{ date('d-m-Y') }}</td>
            </tr>

            <tr>
                <td style="text-align:center; vertical-align: bottom;" height="100px">
                    <u>Rahmat Hermawan, S.Pd</u>
                    <br />
                    <i><b>Kepala Sekolah</b></i>
                </td>

                <td style="text-align: center; vertical-align: bottom">
                    <u>Liliani Hamim</u>
                    <br />
                    <i><b>Staff Tata Usaha</b></i>
                </td>
            </tr>

        </table>
    </section>

</body>

</html>
