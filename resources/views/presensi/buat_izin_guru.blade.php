@extends('layouts.presensi')

@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <style>
        /* Menyesuaikan date picker modal */
        .datepicker-modal {
            max-height: none !important;
            height: auto !important;
        }

        /* Menyembunyikan tombol clear */
        .datepicker-footer .btn-flat:contains("Clear") {
            display: none !important;
        }

        /* Styling umum untuk tombol di footer date picker */
        .datepicker-footer .btn-flat {
            margin: 5px !important;
            padding: 10px 20px !important;
            font-size: 14px !important;
            border-radius: 5px !important;
            transition: background-color 0.3s, color 0.3s;
        }

        /* Menghapus warna khusus untuk tombol Cancel */
        .datepicker-footer .btn-cancel {
            background-color: inherit !important;
            color: inherit !important;
        }

        .datepicker-footer .btn-cancel:hover {
            background-color: inherit !important;
            color: inherit !important;
        }

        /* Menghapus warna khusus untuk tombol OK */
        .datepicker-footer .btn-ok {
            background-color: inherit !important;
            color: inherit !important;
        }

        .datepicker-footer .btn-ok:hover {
            background-color: inherit !important;
            color: inherit !important;
        }
    </style>

    {{-- App Header --}}
    <div class="appHeader text-light" style="background-color: #FFC7ED">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Izin</div>
        <div class="right"></div>
    </div>
    {{-- App Header --}}
@endsection

@section('content')
    <div class="row" style="margin-top:70px">
        <div class="col">
            <form method="POST" action="/guru/presensi/simpan-izin" id="form_izin">
                @csrf
                <div class="form-group">
                    <input type="text" id="tanggal_izin" name="tanggal_izin" class="form-control datepicker"
                        placeholder="Tanggal">
                </div>
                <div class="form-group">
                    <select name="status" id="status" class="form-control">
                        <option value="">Izin / Sakit</option>
                        <option value="i">Izin</option>
                        <option value="s">Sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary w-100">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(document).ready(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd"
            });

            $("#tanggal_izin").change(function(e) {
                let tanggal_izin = $(this).val();

                $.ajax({
                    type: 'POST',
                    url: '/guru/presensi/cek-pengajuan-izin',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal_izin: tanggal_izin
                    },
                    cache: false,
                    success: function(response) {
                        if (response == 1) {
                            Swal.fire({
                                title: 'Oops !',
                                text: 'Anda Sudah Melakukan Pengajuan Izin Pada Tanggal Tersebut',
                                icon: 'warning'
                            }).then((result) => {
                                $("#tanggal_izin").val("");
                            });
                        }
                    }
                })
            });


            $("#form_izin").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi',
                    text: "Apakah Anda yakin ingin mengirim pengajuan izin ini?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Kirim!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika user mengkonfirmasi, kirim form
                        $.ajax({
                            url: $(this).attr('action'),
                            method: $(this).attr('method'),
                            data: $(this).serialize(),
                            success: function(response) {
                                Swal.fire(
                                    'Berhasil!',
                                    'Pengajuan izin Anda telah berhasil dikirim.',
                                    'success'
                                ).then((result) => {
                                    // Redirect atau reset form sesuai kebutuhan
                                    window.location.href =
                                        '/guru/dashboard'; // Ganti dengan URL yang sesuai
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    'Terjadi kesalahan saat mengirim pengajuan izin.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
