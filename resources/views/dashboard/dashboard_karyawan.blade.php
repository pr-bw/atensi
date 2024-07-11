@extends('layouts.presensi')

@section('content')
    <style>
        .clockDateContainer {
            margin-bottom: 0px;
        }

        .clock {
            font-size: 2rem;
            /* Adjust font size as needed */
        }

        #date {
            margin-top: 10px;
            font-size: 1.5rem;
            /* Adjust font size as needed */
        }
    </style>

    <div class="section" id="user-section" style="background-color: #FFC7ED">
        <div id="user-detail">
            <div class="avatar">
                @if (!empty(Auth::guard('karyawan')->user()->foto))
                    @php
                        $path = Storage::url('uploads/karyawan/' . Auth::guard('karyawan')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="imaged rounded" style="height: 70px; width: 70px;">
                @else
                    <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w64 rounded">
                @endif
            </div>

            <div id="user-info">
                <h2 id="user-name">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</h2>
                <span id="user-role">{{ Auth::guard('karyawan')->user()->jabatan }}</span>
            </div>
        </div>
    </div>

    <div class="section clockDateContainer" id="menu-section">
        <div class="card" style="background-color: #FFF8DB">
            <div class="card-body text-center">
                <div class="clock">
                    <div id="clock"></div>
                    <div id="date"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="section mt-1" id="presence-section" style="background-color: #7D8ABC">
        <div class="todaypresence">
            <div class="row">
                <div class="col-6">
                    <div class="card" style="background-color: #FFC7ED">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensi_hari_ini != null)
                                        @php
                                            $path = Storage::url('uploads/presensi/' . $presensi_hari_ini->foto_in);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>
                                <div class="presencedetail">
                                    <h4 class="presencetitle">Masuk</h4>
                                    <span>{{ $presensi_hari_ini != null ? $presensi_hari_ini->jam_in : 'Belum Presensi' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card" style="background-color: #FFC7ED">
                        <div class="card-body">
                            <div class="presencecontent">
                                <div class="iconpresence">
                                    @if ($presensi_hari_ini != null && $presensi_hari_ini->jam_out != null)
                                        @php
                                            $path = Storage::url('uploads/presensi/' . $presensi_hari_ini->foto_out);
                                        @endphp
                                        <img src="{{ url($path) }}" alt="" class="imaged w48">
                                    @else
                                        <ion-icon name="camera"></ion-icon>
                                    @endif
                                </div>

                                <div class="presencedetail">
                                    <h4 class="presencetitle">Pulang</h4>
                                    <br />
                                    <span>{{ $presensi_hari_ini != null && $presensi_hari_ini->jam_out != null ? $presensi_hari_ini->jam_out : 'Belum Presensi' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rekap-presensi">
            <h3 style="font-weight: bolder">
                Rekap Presensi Bulan {{ $nama_bulan[$bulan_ini] }} Tahun {{ $tahun_ini }}
            </h3>
            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:3px; right: 10px; font-size: 0.6rem; z-index: 999">
                                {{ $rekap_presensi->jumlah_hadir }}
                            </span>
                            <ion-icon name="accessibility" style="font-size: 1.6rem;" class="text-primary mb-1"></ion-icon>
                            <br />
                            <span style="font-size: 0.8rem; font-weight: 500">Hadir</span>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:3px; right: 10px; font-size: 0.6rem; z-index: 999">
                                {{ $rekap_izin->jumlah_izin }}
                            </span>
                            <ion-icon name="document-text" style="font-size: 1.6rem;" class="text-success mb-1"></ion-icon>
                            <br />
                            <span style="font-size: 0.8rem; font-weight: 500">Izin</span>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:3px; right: 10px; font-size: 0.6rem; z-index: 999">
                                {{ $rekap_izin->jumlah_sakit }}
                            </span>
                            <ion-icon name="medkit" style="font-size: 1.6rem;" class="text-warning mb-1"></ion-icon>
                            <br />
                            <span style="font-size: 0.8rem; font-weight: 500">Sakit</span>
                        </div>
                    </div>
                </div>

                <div class="col-3">
                    <div class="card">
                        <div class="card-body text-center" style="padding: 12px 12px !important; line-height: 0.8rem">
                            <span class="badge bg-danger"
                                style="position: absolute; top:3px; right: 10px; font-size: 0.6rem; z-index: 999">
                                {{ $rekap_presensi->jumlah_terlambat }}
                            </span>
                            <ion-icon name="time" style="font-size: 1.6rem;" class="text-danger mb-1"></ion-icon>
                            <br />
                            <span style="font-size: 0.8rem; font-weight: 500">Telat</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="presencetab mt-2">
            <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                <ul class="nav nav-tabs style1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                            Bulan Ini
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                            Leaderboard
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($history_bulan_ini as $d)
                            @php
                                $path = Storage::url('uploads/presensi/' . $d->foto_in);
                            @endphp
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date('d-m-Y', strtotime($d->tanggal_presensi)) }}</div>
                                        <span class="badge badge-success">{{ $d->jam_in }}</span>
                                        <span class="badge badge-danger">
                                            {{ $presensi_hari_ini != null && $d->jam_out != null ? $d->jam_out : 'Belum Presensi' }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel">
                    <ul class="listview image-listview">
                        @foreach ($leaderboard as $d)
                            <li>
                                <div class="item">
                                    <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="image"
                                        class="image">
                                    <div class="in">
                                        <div>
                                            <b>{{ $d->nama_lengkap }}</b>
                                            <br />
                                            <small class="text-muted">{{ $d->jabatan }}</small>
                                        </div>
                                        <span class="badge {{ $d->jam_in < '07:30' ? 'bg-success' : 'bg-danger' }}">
                                            {{ $d->jam_in }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        function updateTime() {
            // Get current date and time in WIB
            let now = new Date();
            let options = {
                timeZone: 'Asia/Jakarta',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric'
            };
            let time = now.toLocaleString('en-US', options);

            // Format date as DD-MM-YYYY
            let dateOptions = {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            };
            let date = now.toLocaleDateString('en-GB', dateOptions);

            // Update clock and date elements
            document.getElementById('clock').textContent = time;
            document.getElementById('date').textContent = date;
        }

        // Update time every second
        setInterval(updateTime, 1000);

        // Initial update
        updateTime();
    </script>
@endpush
