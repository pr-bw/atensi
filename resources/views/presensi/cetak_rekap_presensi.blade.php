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
            font-size: 7px;
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

<body class="A4 landscape">
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

        <table class="tabelpresensi">
            <tr>
                <th rowspan="2">NIP</th>
                <th rowspan="2">Nama Karyawan</th>
                <th colspan="31">Tanggal</th>
                {{-- total hadir --}}
                <th rowspan="2">TH</th>
                {{-- total terlambat --}}
                <th rowspan="2">TT</th>
            </tr>

            <tr>
                <?php
                    for ($i=1; $i <=31; $i++) { 
                    ?>
                <th>{{ $i }}</th>
                <?php
                    }
                ?>
            </tr>

            @foreach ($rekap as $d)
                <tr>
                    <td>{{ $d->nip }}</td>
                    <td>{{ $d->nama_lengkap }}</td>

                    <?php
                    $totalhadir = 0;
                    $totalterlambat = 0;
                for ($i = 1; $i <= 31; $i++) { // Memperbaiki batas loop hingga 30 hari
                    $tgl = "tanggal_" . $i;
                    if (empty($d->$tgl)) {
                        $hadir = ['', ''];
                        $totalhadir += 0;
                    } else {
                        $hadir = explode("-", $d->$tgl);
                        $totalhadir += 1;

                        if ($hadir[0] > "07:30:00") {
                            $totalterlambat += 1;
                        }
                    }
                ?>
                    <td>
                        <span style="color: {{ $hadir[0] > '07:30:00' ? 'red' : '' }}">{{ $hadir[0] }}</span>
                        <br />
                        <span style="color: {{ $hadir[1] < '13:00:00' ? 'red' : '' }}">{{ $hadir[0] }}</span>
                    </td>
                    <?php 
                } // Menutup for loop
                ?>
                    <td> {{ $totalhadir }} </td>

                    <td> {{ $totalterlambat }} </td>
                </tr>
            @endforeach
        </table>

        <table width="100%" style="margin-top:100px">
            <tr>
                <td></td>
                <td colspan="2" style="text-align: center">Parung, Bogor, {{ date('d-m-Y') }}</td>
            </tr>

            <tr>
                <td style="text-align:center; vertical-align: bottom;" height="100px">
                    <u>Liliani Hamim</u>
                    <br />
                    <i><b>Staff Tata Usaha</b></i>
                </td>

                <td style="text-align: center; vertical-align: bottom">
                    <u>Rahmat Hermawan, S.Pd</u>
                    <br />
                    <i><b>Kepala Sekolah</b></i>
                </td>
            </tr>

        </table>
    </section>

</body>

</html>
