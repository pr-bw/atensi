@extends('layouts.presensi')

@section('header')
    {{-- App Header --}}
    <div class="appHeader text-light" style="background-color: #FFC7ED">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Riwayat Presensi</div>
        <div class="right"></div>
    </div>
    {{-- App Header --}}
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="bulan" id="bulan" class="form-control">
                            <option value="">Bulan</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ date('m') == $i ? 'selected' : '' }}>
                                    {{ $nama_bulan[$i] }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <select name="tahun" id="tahun" class="form-control">
                            <option value="">Tahun</option>
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
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <button class="btn btn-block" style="background-color: #91DDCF" id="dapatkan_riwayat_kehadiran">
                            <ion-icon name="search-outline"></ion-icon>
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="showhistory"></div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#dapatkan_riwayat_kehadiran").click(function(e) {
                e.preventDefault(); // Prevent default form submission
                var bulan = $("#bulan").val();
                var tahun = $("#tahun").val();

                console.log("Bulan:", bulan);
                console.log("Tahun:", tahun);

                $.ajax({
                    type: 'POST',
                    url: '/guru/presensi/riwayat',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun
                    },
                    cache: false,
                    success: function(response) {
                        console.log("Response:", response);
                        $("#showhistory").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            });
        });
    </script>
@endpush
