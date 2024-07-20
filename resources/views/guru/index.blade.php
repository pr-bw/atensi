@extends('layouts.admin.sbadmin2')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

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
                                    @if (Session::has('success'))
                                        <div class="alert alert-success">
                                            {{ Session::get('success') }}
                                        </div>
                                    @endif

                                    @if (Session::has('warning'))
                                        <div class="alert alert-warning">
                                            {{ Session::get('warning') }}
                                        </div>
                                    @endif

                                    <a href="#" class="btn btn-primary" id="btnTambahGuru">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 5l0 14" />
                                            <path d="M5 12l14 0" />
                                        </svg>
                                        Tambah Data
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form action="/administrator/guru" method="GET">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <input type="text" name="nama_guru" id="nama_guru"
                                                        class="form-control" placeholder="Nama guru"
                                                        value="{{ Request('nama_guru') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center" style="white-space: nowrap;">No.</th>
                                                    <th class="text-center" style="white-space: nowrap;">NUPTK</th>
                                                    <th class="text-center" style="white-space: nowrap;">Nama</th>
                                                    <th class="text-center" style="white-space: nowrap;">Jenis Kelamin</th>
                                                    <th class="text-center" style="white-space: nowrap;">Pendidikan</th>
                                                    <th class="text-center" style="white-space: nowrap;">Mapel</th>
                                                    <th class="text-center" style="white-space: nowrap;">No. HP</th>
                                                    {{-- <th class="text-center" style="white-space: nowrap;">Password</th> --}}
                                                    <th class="text-center" style="white-space: nowrap;">Foto</th>
                                                    <th class="text-center" style="white-space: nowrap;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($guru as $d)
                                                    @php
                                                        $path = Storage::url('public/uploads/guru/' . $d->foto);
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center">
                                                            {{ $loop->iteration + $guru->firstItem() - 1 }}</td>
                                                        <td class="text-center">{{ $d->nuptk }}</td>
                                                        <td class="text-center">{{ $d->nama_lengkap }}</td>
                                                        <td class="text-center">{{ $d->jenis_kelamin }}</td>
                                                        <td class="text-center">{{ $d->pendidikan }}</td>
                                                        <td class="text-center">{{ $d->mapel }}</td>
                                                        <td class="text-center">{{ $d->nomor_hp }}</td>
                                                        {{-- <td class="text-center">{{ $d->password }}</td> --}}
                                                        <td class="text-center">
                                                            @if (empty($d->foto))
                                                                <img src="{{ asset('assets/img/default/default.jpg') }}"
                                                                    alt="no photo" width="70px">
                                                            @else
                                                                <img src="{{ url($path) }}" alt=""
                                                                    class="avatar" width="75px" height="80px">
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="btn-group">
                                                                <a href="#" class="edit btn btn-info btn-sm"
                                                                    nuptk="{{ $d->nuptk }}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="#000000" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                            fill="none" />
                                                                        <path
                                                                            d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                                        <path
                                                                            d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                                        <path d="M16 5l3 3" />
                                                                    </svg>
                                                                </a>
                                                                <form
                                                                    action="/administrator/guru/{{ $d->nuptk }}/hapus"
                                                                    method="POST">
                                                                    @csrf
                                                                    <a class="btn btn-danger btn-sm delete-confirm">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            width="24" height="24"
                                                                            viewBox="0 0 24 24" fill="none"
                                                                            stroke="#000000" stroke-width="2"
                                                                            stroke-linecap="round" stroke-linejoin="round"
                                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                                            <path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none" />
                                                                            <path d="M4 7l16 0" />
                                                                            <path d="M10 11l0 6" />
                                                                            <path d="M14 11l0 6" />
                                                                            <path
                                                                                d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                            <path
                                                                                d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                                        </svg>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{ $guru->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tambah Guru -->
    <div class="modal modal-blur fade" id="modal-tambahGuru" tabindex="-1" role="dialog"
        aria-labelledby="modal-tambahGuruLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/administrator/guru/tambah-data-guru" method="POST" id="frmGuru"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-barcode">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                                <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                                                <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                                                <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                                                <path d="M5 11h1v2h-1z" />
                                                <path d="M10 11l0 2" />
                                                <path d="M14 11h1v2h-1z" />
                                                <path d="M19 11l0 2" />
                                            </svg>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="nuptk" name="nuptk"
                                        placeholder="Nomor Unik Pendidik dan Tenaga Kependidikan">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                                <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                <path d="M15 8l2 0" />
                                                <path d="M15 12l2 0" />
                                                <path d="M7 16l10 0" />
                                            </svg>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"
                                        placeholder="Nama Lengkap">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                                <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                            </svg>
                                        </span>
                                    </div>
                                    <select class="form-control" id="pendidikan" name="pendidikan">
                                        <option value="SMA">SMA</option>
                                        <option value="SMK">SMK</option>
                                        <option value="D I">D I</option>
                                        <option value="D II">D II</option>
                                        <option value="D III">D III</option>
                                        <option value="D IV">D IV</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase-2">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z" />
                                                <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                                            </svg>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="mapel" name="mapel"
                                        placeholder="Mata Pelajaran">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                            </svg>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="nomor_hp" name="nomor_hp"
                                        placeholder="Nomor HP">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-image">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                                                <path d="M10 10l2 -2l2 2" />
                                                <path d="M4 8l8 8l4 -4l4 4" />
                                            </svg>
                                        </span>
                                    </div>
                                    <input type="file" class="form-control" id="foto" name="foto"
                                        accept=".jpg, .jpeg, .png">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal tambah Guru -->


    <!-- Modal edit guru -->
    <div class="modal modal-blur fade" id="modal-editGuru" tabindex="-1" role="dialog"
        aria-labelledby="editGuruModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="editGuruModalLabel">Edit Data Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 6l-12 12" />
                            <path d="M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body" id="loadEditForm">
                    <!-- Form content will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#btnTambahGuru").click(function() {
                $("#modal-tambahGuru").modal("show");
            });

            $(".edit").click(function() {
                let nuptk = $(this).attr('nuptk');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('administrator.guru.ubah-data') }}',
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        nuptk: nuptk
                    },
                    success: function(response) {
                        $("#loadEditForm").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });
                $("#modal-editGuru").modal("show");
            });

            $(".delete-confirm").click(function(e) {
                let form = $(this).closest('form');

                e.preventDefault();

                Swal.fire({
                    title: "Apakah Anda Yakin Ingin Menghapus Data Guru Ini?",
                    text: "Data Akan Dihapus Secara Permanen",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                            title: "Deleted!",
                            text: "Data Guru Berhasil Dihapus.",
                            icon: "success"
                        });
                    }
                });
            });

            $("#frmGuru").submit(function() {
                let nuptk = $("#nuptk").val();
                let nama_lengkap = $("#nama_lengkap").val();
                let pendidikan = $("#pendidikan").val();
                let mapel = $("#mapel").val();
                let nomor_hp = $("#nomor_hp").val();
                let foto = $("#foto").val();

                if (nuptk === "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'NUPTK Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#nuptk").focus();
                    })

                    return false;
                } else if (nama_lengkap === "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Nama Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#nama_lengkap").focus();
                    })

                    return false;
                } else if (jenis_kelamin === "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Jenis Kelamin Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#jenis_kelamin").focus();
                    })

                    return false;
                } else if (pendidikan === "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Pendidikan Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#pendidikan").focus();
                    })

                    return false;
                } else if (mapel === "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Mata Pelajaran Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#mapel").focus();
                    })

                    return false;
                } else if (nomor_hp === "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Nomor Handphone Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#nomor_hp").focus();
                    })

                    return false;
                } else if (foto === "") {
                    Swal.fire({
                        title: 'Warning!',
                        text: 'Harus Melampirkan Foto',
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    }).then((result) => {
                        $("#foto").focus();
                    })

                    return false;
                }
            })
        });
    </script>
@endpush
