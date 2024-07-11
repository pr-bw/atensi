@extends('layouts.presensi')

@section('header')
    <div class="appHeader text-light" style="background-color: #FFC7ED">
        <div class="left">
            <a href="{{ route('karyawan.dashboard') }}" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profile</div>
        <div class="right"></div>
    </div>
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
                <form action="{{ route('karyawan.profile.simpan-pembaruan', ['nuptk' => $karyawan->nuptk]) }}"
                    method="POST" id="frmKaryawan" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="nuptk" class="form-label small">NUPTK</label>
                        <div class="input-group-prepend">
                            <div class="input-group-prepend">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
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
                                <input type="text" readonly id="nuptk" value="{{ $karyawan->nuptk }}"
                                    class="form-control" name="nuptk" placeholder="NUPTK">
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama_lengkap" class="form-label small">Nama Lengkap</label>
                            <div class="input-group input-group-sm">
                                <div class="input-group-prepend">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
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
                                    <input type="text" readonly id="nama_lengkap" value="{{ $karyawan->nama_lengkap }}"
                                        class="form-control" name="nama_lengkap" placeholder="Nama Lengkap">
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="jenis_kelamin" class="form-label small">Jenis Kelamin</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
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
                                        <input type="text" readonly id="jenis_kelamin"
                                            value="{{ $karyawan->jenis_kelamin }}" class="form-control" name="jenis_kelamin"
                                            placeholder="Jenis Kelamin">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="nomor_hp" class="form-label small">Nomor Handphone</label>
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                            </svg>
                                            </span>
                                            <input type="text" value="{{ old('nomor_hp', $karyawan->nomor_hp) }}"
                                                class="form-control @error('nomor_hp') is-invalid @enderror"
                                                id="nomor_hp" name="nomor_hp" placeholder="Nomor Handphone">
                                            @error('nomor_hp')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label small">Password Baru</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
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
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Password Baru">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="foto" class="form-label small">Foto Profil</label>
                                            <input type="file" name="foto"
                                                class="form-control form-control-sm @error('foto') is-invalid @enderror"
                                                id="foto" accept="image/jpeg,image/jpg,image/png">
                                            <input type="hidden" name="old_foto" value="{{ $karyawan->foto }}">
                                            <div class="invalid-feedback" id="foto_error"></div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit"
                                                class="btn btn-primary w-100 d-flex align-items-center justify-content-center">
                                                <ion-icon name="send-outline" class="me-2"></ion-icon>
                                                Perbarui Profile
                                            </button>
                                        </div>
                </form>

                <hr class="my-4">

                <form action="{{ route('karyawan.logout') }}" method="POST">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const frmKaryawan = document.getElementById('frmKaryawan');

            frmKaryawan.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(frmKaryawan);

                // Client-side validation
                let isValid = true;
                const nama_lengkap = formData.get('nama_lengkap');
                const nomor_hp = formData.get('nomor_hp');
                const password = formData.get('password');
                const foto = formData.get('foto');

                // Nama lengkap validation
                if (!/^[a-zA-Z0-9\s]{1,100}$/.test(nama_lengkap)) {
                    document.getElementById('nama_lengkap_error').textContent =
                        'Nama harus maksimal 100 karakter dan hanya mengandung alphanumeric.';
                    isValid = false;
                } else {
                    document.getElementById('nama_lengkap_error').textContent = '';
                }

                // Nomor HP validation
                if (!/^\d{10,13}$/.test(nomor_hp)) {
                    document.getElementById('nomor_hp_error').textContent =
                        'Nomor HP harus 10-13 digit dan hanya mengandung angka.';
                    isValid = false;
                } else {
                    document.getElementById('nomor_hp_error').textContent = '';
                }

                // Password validation
                if (password && password.length < 8) {
                    document.getElementById('password_error').textContent = 'Password minimal 8 karakter.';
                    isValid = false;
                } else {
                    document.getElementById('password_error').textContent = '';
                }

                // Foto validation
                if (foto && foto.size > 0) {
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(foto.type)) {
                        document.getElementById('foto_error').textContent =
                            'Foto harus berformat jpeg, jpg, atau png.';
                        isValid = false;
                    } else if (foto.size > 2 * 1024 * 1024) {
                        document.getElementById('foto_error').textContent = 'Ukuran foto maksimal 2MB.';
                        isValid = false;
                    } else {
                        document.getElementById('foto_error').textContent = '';
                    }
                }

                if (!isValid) {
                    return;
                }

                fetch(`/karyawan/${formData.get('nuptk')}/update`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'error') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message,
                            });
                            // Display validation errors
                            if (data.errors) {
                                Object.keys(data.errors).forEach(key => {
                                    document.getElementById(`${key}_error`).textContent = data
                                        .errors[key][0];
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message,
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan',
                            text: 'Terjadi kesalahan saat memperbarui profil. Silakan coba lagi.',
                        });
                    });
            });
        });
    </script>
@endsection
