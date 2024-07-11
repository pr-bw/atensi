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
            <form method="POST" action="/karyawan/presensi/simpanIzin" id="form_izin">
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
                format: "yyyy-mm-dd",
                showClearBtn: false,
                onClose: function() {
                    setTimeout(function() {
                        $('.datepicker-footer').css({
                            display: 'flex',
                            justifyContent: 'flex-end',
                            padding: '10px 20px',
                            borderTop: '1px solid #ddd'
                        });

                        $('.datepicker-footer .btn-flat').each(function(index, element) {
                            let buttonText = $(element).text().toLowerCase();
                            if (buttonText === 'cancel' || buttonText === 'batal') {
                                $(element).addClass('btn-cancel');
                            } else if (buttonText === 'ok') {
                                $(element).addClass('btn-ok');
                            }
                        });

                        // Menghapus tombol Clear jika masih ada
                        $('.datepicker-footer .btn-flat:contains("clear")').hide();
                    }, 0);
                }
            });
        });
    </script>
@endpush
