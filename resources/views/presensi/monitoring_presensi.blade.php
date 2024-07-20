@extends('layouts.admin.sbadmin2')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Monitoring Presensi</h1>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-time">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" />
                                                    <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                                    <path d="M15 3v4" />
                                                    <path d="M7 3v4" />
                                                    <path d="M3 11h16" />
                                                    <path d="M18 16.496v1.504l1 1" />
                                                </svg>
                                            </span>
                                        </div>
                                        <input type="text" id="tanggal" value="{{ date('Y-m-d') }}" name="tanggal"
                                            class="form-control" placeholder="Tanggal Presensi" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center" style="white-space: nowrap;">No.</th>
                                                    <th class="text-center" style="white-space: nowrap;">NUPTK</th>
                                                    <th class="text-center" style="white-space: nowrap;">Nama Guru</th>
                                                    <th class="text-center" style="white-space: nowrap;">Mata Pelajaran</th>
                                                    <th class="text-center" style="white-space: nowrap;">Jam Masuk</th>
                                                    <th class="text-center" style="white-space: nowrap;">Foto Masuk</th>
                                                    <th class="text-center" style="white-space: nowrap;">Jam Pulang</th>
                                                    <th class="text-center" style="white-space: nowrap;">Foto Pulang</th>
                                                    <th class="text-center" style="white-space: nowrap;">Keterangan</th>
                                                    {{-- <th class="text-center" style="white-space: nowrap;">Lokasi User</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody id="loadPresensi">
                                                <!-- Data presensi akan dimasukkan melalui AJAX -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="modal-tampilkanPeta" tabindex="-1" role="dialog"
        aria-labelledby="modal-tampilkanPetaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-tampilkanPetaLabel">Lokasi Presensi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="mapid" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#tanggal").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd',
            });

            function loadPresensi() {
                var tanggal = $("#tanggal").val();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('administrator.presensi.monitoring.rekap-presensi-harian') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal
                    },
                    cache: false,
                    success: function(response) {
                        console.log('Data diterima dari server:', response);
                        $("#loadPresensi").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        $("#loadPresensi").html(
                            '<tr><td colspan="9">Gagal mengambil data presensi.</td></tr>');
                    }
                });
            }

            $("#tanggal").change(function(e) {
                loadPresensi();
            });

            loadPresensi(); // Memanggil loadPresensi saat pertama kali halaman dimuat
        });
    </script>
@endpush
