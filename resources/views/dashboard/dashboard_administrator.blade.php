@extends('layouts.admin.sbadmin2')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        </div>

        <!-- Content Row -->
        <div class="row">

            <!-- Karyawan Hadir -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Karyawan Hadir</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rekap_presensi->jumlah_hadir }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x" style="color: #28a745;"></i> <!-- Hijau -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Karyawan Izin -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Karyawan Izin</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $rekap_izin->jumlah_izin != null ? $rekap_izin->jumlah_izin : 0 }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-file-alt fa-2x" style="color: #007bff;"></i> <!-- Biru -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Karyawan Sakit -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Karyawan Sakit
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            {{ $rekap_izin->jumlah_sakit != null ? $rekap_izin->jumlah_sakit : 0 }}
                                        </div>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 50%"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-stethoscope fa-2x" style="color: #dc3545;"></i> <!-- Merah -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Karyawan Terlambat -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Karyawan Terlambat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rekap_presensi->jumlah_terlambat }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x" style="color: #fd7e14;"></i> <!-- Oranye -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <!-- Chart content here -->
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-4 col-lg-5">
                <!-- Chart content here -->
            </div>
        </div>

        <!-- Content Row -->

    </div>
    <!-- /.container-fluid -->
@endsection
