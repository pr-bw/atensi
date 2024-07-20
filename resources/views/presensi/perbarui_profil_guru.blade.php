@extends('layouts.presensi')

@section('header')
    <div class="appHeader text-light" style="background-color: #FFC7ED">
        <div class="left">
            <a href="{{ route('guru.dashboard') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Perbarui Profile</div>
        <div class="right"></div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <style>
        @media (max-width: 576px) {
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .form-label {
                font-size: 0.9rem;
            }

            .input-group-text {
                padding: 0.25rem 0.5rem;
            }

            .form-control {
                font-size: 0.9rem;
            }

            .btn {
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="container px-3 py-4" style="margin-top: 60px; margin-bottom: 38px;">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form action="{{ route('guru.profile.simpan-pembaruan', ['nuptk' => $guru->nuptk]) }}" method="POST"
                    id="frmGuru" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="nuptk" class="form-label small">NUPTK</label>
                        <div class="input-group-prepend mb-3">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
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
                            <input type="text" readonly id="nuptk" value="{{ $guru->nuptk }}" class="form-control"
                                name="nuptk" placeholder="NUPTK">
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_lengkap" class="form-label small">Nama Lengkap</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="currentColor"
                                        class="icon icon-tabler icons-tabler-filled icon-tabler-user">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
                                        <path
                                            d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" />
                                    </svg>
                                </span>
                                <input type="text" readonly id="nama_lengkap" value="{{ $guru->nama_lengkap }}"
                                    class="form-control" name="nama_lengkap" placeholder="Nama Lengkap">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="jenis_kelamin" class="form-label small">Jenis Kelamin</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-gender-bigender">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M11 11m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M19 3l-5 5" />
                                        <path d="M15 3h4v4" />
                                        <path d="M11 16v6" />
                                        <path d="M8 19h6" />
                                    </svg>
                                </span>
                                <input type="text" readonly id="jenis_kelamin" value="{{ $guru->jenis_kelamin }}"
                                    class="form-control" name="jenis_kelamin" placeholder="Jenis Kelamin">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="pendidikan" class="form-label small">Pendidikan</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                                        <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                                    </svg>
                                </span>
                                <input type="text" readonly id="pendidikan" value="{{ $guru->pendidikan }}"
                                    class="form-control" name="pendidikan" placeholder="Pendidikan">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="mapel" class="form-label small">Mata Pelajaran</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-book">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                        <path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" />
                                        <path d="M3 6l0 13" />
                                        <path d="M12 6l0 13" />
                                        <path d="M21 6l0 13" />
                                    </svg>
                                </span>
                                <input type="text" readonly id="mapel" value="{{ $guru->mapel }}"
                                    class="form-control" name="mapel" placeholder="Mata Pelajaran">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nomor_hp" class="form-label small">Nomor Handphone</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="currentColor"
                                        class="icon icon-tabler icons-tabler-filled icon-tabler-phone">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M9 3a1 1 0 0 1 .877 .519l.051 .11l2 5a1 1 0 0 1 -.313 1.16l-.1 .068l-1.674 1.004l.063 .103a10 10 0 0 0 3.132 3.132l.102 .062l1.005 -1.672a1 1 0 0 1 1.113 -.453l.115 .039l5 2a1 1 0 0 1 .622 .807l.007 .121v4c0 1.657 -1.343 3 -3.06 2.998c-8.579 -.521 -15.418 -7.36 -15.94 -15.998a3 3 0 0 1 2.824 -2.995l.176 -.005h4z" />
                                    </svg>
                                </span>
                                <input type="text" value="{{ old('nomor_hp', $guru->nomor_hp) }}"
                                    class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp"
                                    name="nomor_hp" id="nomor_hp" placeholder="Nomor Handphone">
                                {{-- @error('nomor_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label small">Password Baru</label>
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-password">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 10v4" />
                                        <path d="M10 13l4 -2" />
                                        <path d="M10 11l4 2" />
                                        <path d="M5 10v4" />
                                        <path d="M3 13l4 -2" />
                                        <path d="M3 11l4 2" />
                                        <path d="M19 10v4" />
                                        <path d="M17 13l4 -2" />
                                        <path d="M17 11l4 2" />
                                    </svg>
                                </span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password Baru">
                                {{-- @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="foto" class="form-label small">Foto Profil</label>
                            <input type="file" name="foto"
                                class="form-control form-control-sm @error('foto') is-invalid @enderror" id="foto"
                                accept="image/jpeg,image/jpg,image/png">
                            <input type="hidden" name="old_foto" value="{{ $guru->foto }}">
                        </div>

                        <p>
                            * Hubungi Administrator apabila ada perubahan mengenai NUPTK, Nama Lengkap, Jenis
                            Kelamin, Pendidikan, dan Mata Pelajaran.
                        </p>

                        <div class="form-group">
                            <button type="submit"
                                class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                <ion-icon name="send-outline" class="me-2"></ion-icon>
                                Perbarui Profile
                            </button>
                        </div>
                </form>

                <hr class="my-4">

                <form action="{{ route('guru.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100 d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout me-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                            <path d="M9 12h12l-3 -3" />
                            <path d="M18 15l3 -3" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('frmGuru');
            const nomorHpInput = document.getElementById('nomor_hp');
            const passwordInput = document.getElementById('password');

            function validateInput(input, validationFunc, errorMessage) {
                const isValid = validationFunc(input.value);
                if (!isValid) {
                    input.classList.add('is-invalid');
                    input.nextElementSibling.textContent = errorMessage;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    input.nextElementSibling.textContent = '';
                }
                return isValid;
            }

            nomorHpInput.addEventListener('input', function() {
                validateInput(this,
                    (value) => value.length >= 10 && value.length <= 13 && /^\d+$/.test(value),
                    'Nomor handphone harus antara 10 sampai 13 digit.'
                );
            });

            passwordInput.addEventListener('input', function() {
                validateInput(this,
                    (value) => value.length >= 8,
                    'Password minimal 8 karakter.'
                );
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                let isValid = true;
                isValid &= validateInput(nomorHpInput,
                    (value) => value.length >= 10 && value.length <= 13 && /^\d+$/.test(value),
                    'Nomor handphone harus antara 10 sampai 13 digit.'
                );
                isValid &= validateInput(passwordInput,
                    (value) => value.length >= 8 || value.length === 0,
                    'Password minimal 8 karakter.'
                );

                if (isValid) {
                    Swal.fire({
                        title: 'Memperbarui Profil',
                        text: 'Mohon tunggu...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        },
                    });
                    this.submit();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Mohon periksa kembali input Anda.',
                    });
                }
            });

            // Tampilkan pesan sukses atau error dari server
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });
    </script>
@endsection
