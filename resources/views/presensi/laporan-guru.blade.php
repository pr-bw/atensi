@extends('layouts.admin.sbadmin2')

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="/administrator/presensi/laporan/guru/cetak" method="POST" target="_blank">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-3">
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

                                    <div class="col-12 col-md-6 mb-3">
                                        <label for="tahun" class="form-label">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-select w-100">
                                            <option value="">Pilih Tahun</option>
                                            @php
                                                $tahun_mulai = 2022;
                                                $tahun_sekarang = date('Y');
                                            @endphp
                                            @for ($tahun = $tahun_mulai; $tahun <= $tahun_sekarang; $tahun++)
                                                <option value="{{ $tahun }}"
                                                    {{ date('Y') == $tahun ? 'selected' : '' }}>
                                                    {{ $tahun }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="nuptk" class="form-label">Pilih Guru</label>
                                        <select name="nuptk" id="nuptk" class="form-select w-100" required>
                                            <option value="">Pilih Guru</option>
                                            @foreach ($guru as $d)
                                                <option value="{{ $d->nuptk }}">{{ $d->nama_lengkap }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-fill me-2">
                                                <button type="submit" name="print" class="btn btn-primary w-100 mb-2">
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
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('myscript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();

            const nuptkField = document.getElementById('nuptk');

            if (nuptkField.value === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Silakan pilih guru terlebih dahulu!',
                });
            } else {
                this.submit();
            }
        });
    </script>
@endsection
