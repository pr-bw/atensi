@extends('layouts.admin.sbadmin2')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h2 class="h3 mb-0 text-gray-800">Laporan Presensi</h2>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="container-xl">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="/presensi/cetaklaporan" target="_blank" method="POST">
                                @csrf
                                <!-- Pilihan Bulan -->
                                <div class="mb-3">
                                    <label for="bulan" class="form-label">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-select w-100">
                                        <option value="">Pilih Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                                {{ $nama_bulan[$i] }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Pilihan Tahun -->
                                <div class="mb-3">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-select w-100">
                                        <option value="">Pilih Tahun</option>
                                        @php
                                            $tahun_mulai = 2022;
                                            $tahun_sekarang = date('Y');
                                        @endphp
                                        @for ($tahun = $tahun_mulai; $tahun <= $tahun_sekarang; $tahun++)
                                            <option value="{{ $tahun }}" {{ date('Y') == $tahun ? 'selected' : '' }}>
                                                {{ $tahun }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Pilihan Karyawan -->
                                <div class="mb-3">
                                    <label for="nip" class="form-label">Pilih Karyawan</label>
                                    <select name="nip" id="nip" class="form-select w-100">
                                        <option value="">Pilih Karyawan</option>
                                        @foreach ($karyawan as $d)
                                            <option value="{{ $d->nip }}">{{ $d->nama_lengkap }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <button type="submit" name="print" class="btn btn-primary w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icon-tabler-printer">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path
                                                        d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2">
                                                    </path>
                                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                                    <path
                                                        d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z">
                                                    </path>
                                                </svg>
                                                Print
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <button type="submit" name="exportToExcel" class="btn btn-success w-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icon-tabler-download">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                                    <path d="M7 11l5 5l5 -5"></path>
                                                    <path d="M12 4l0 12"></path>
                                                </svg>
                                                Export to Excel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container-xl mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="POST">
                            @csrf

                            <!-- Pilihan Bulan -->
                            <div class="mb-3">
                                <label for="bulan" class="form-label">Bulan</label>
                                <select name="bulan" id="bulan" class="form-select w-100">
                                    <option value="">Pilih Bulan</option>
                                    <!-- Tambahkan pilihan bulan di sini -->
                                </select>
                            </div>

                            <!-- Pilihan Tahun -->
                            <div class="mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <select name="tahun" id="tahun" class="form-select w-100">
                                    <option value="">Pilih Tahun</option>
                                    <!-- Tambahkan pilihan tahun di sini -->
                                </select>
                            </div>

                            <!-- Pilihan Karyawan -->
                            <div class="mb-3">
                                <label for="nip" class="form-label">Pilih Karyawan</label>
                                <select name="nip" id="nip" class="form-select w-100">
                                    <option value="">Pilih Karyawan</option>
                                    <!-- Tambahkan pilihan karyawan di sini -->
                                </select>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <button type="submit" name="print" class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icon-tabler-printer">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2">
                                            </path>
                                            <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                                            <path
                                                d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z">
                                            </path>
                                        </svg>
                                        Print
                                    </button>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <button type="submit" name="exportToExcel" class="btn btn-success w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icon-tabler-download">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                                            <path d="M7 11l5 5l5 -5"></path>
                                            <path d="M12 4l0 12"></path>
                                        </svg>
                                        Export to Excel
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
