<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('warning'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('warning') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<form action="/administrator/guru/{{ $guru->nuptk }}/perbarui" method="POST" id="frmguru"
    enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-barcode">
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
                <input type="text" id="nuptk" value="{{ $guru->nuptk }}" class="form-control" name="nuptk"
                    placeholder="Nomor Unik Pendidik dan Tenaga Pendidik">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                            <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M15 8l2 0" />
                            <path d="M15 12l2 0" />
                            <path d="M7 16l10 0" />
                        </svg>
                    </span>
                </div>
                <input type="text" value="{{ old('nama_lengkap', $guru->nama_lengkap) }}"
                    class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap"
                    name="nama_lengkap" placeholder="Nama Lengkap">
                @error('nama_lengkap')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                            <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                        </svg>
                    </span>
                </div>
                <select class="form-control @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin"
                    name="jenis_kelamin">
                    <option value="">Pilih Jenis Kelamin</option>
                    <option value="Laki - laki"
                        {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Laki - laki' ? 'selected' : '' }}>
                        Laki - laki
                    </option>
                    <option value="Perempuan"
                        {{ old('jenis_kelamin', $guru->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-school">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M22 9l-10 -4l-10 4l10 4l10 -4v6" />
                            <path d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4" />
                        </svg>
                    </span>
                </div>
                <select class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan"
                    name="pendidikan">
                    <option value="">Pilih Pendidikan</option>
                    <option value="SMA" {{ old('pendidikan', $guru->pendidikan) == 'SMA' ? 'selected' : '' }}>SMA
                    </option>
                    <option value="SMK" {{ old('pendidikan', $guru->pendidikan) == 'SMK' ? 'selected' : '' }}>SMK
                    </option>
                    <option value="D I" {{ old('pendidikan', $guru->pendidikan) == 'D I' ? 'selected' : '' }}>D
                        I</option>
                    <option value="D II" {{ old('pendidikan', $guru->pendidikan) == 'D II' ? 'selected' : '' }}>D
                        II</option>
                    <option value="D III" {{ old('pendidikan', $guru->pendidikan) == 'D III' ? 'selected' : '' }}>D
                        III</option>
                    <option value="D IV" {{ old('pendidikan', $guru->pendidikan) == 'D IV' ? 'selected' : '' }}>D
                        IV</option>
                    <option value="S1" {{ old('pendidikan', $guru->pendidikan) == 'S1' ? 'selected' : '' }}>S1
                    </option>
                    <option value="S2" {{ old('pendidikan', $guru->pendidikan) == 'S2' ? 'selected' : '' }}>S2
                    </option>
                    <option value="S3" {{ old('pendidikan', $guru->pendidikan) == 'S3' ? 'selected' : '' }}>S3
                    </option>
                </select>
                @error('pendidikan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9z" />
                            <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                        </svg>
                    </span>
                </div>
                <input type="text" value="{{ old('mapel', $guru->mapel) }}"
                    class="form-control @error('mapel') is-invalid @enderror" id="mapel" name="mapel"
                    placeholder="Mata Pelajaran">
                @error('mapel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                        </svg>
                    </span>
                </div>
                <input type="text" value="{{ old('nomor_hp', $guru->nomor_hp) }}"
                    class="form-control @error('nomor_hp') is-invalid @enderror" id="nomor_hp" name="nomor_hp"
                    placeholder="Nomor Handphone">
                @error('nomor_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-12">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <rect x="5" y="11" width="14" height="10" rx="2" />
                            <circle cx="12" cy="16" r="1" />
                            <path d="M8 11v-4a4 4 0 0 1 8 0v4" />
                        </svg>
                    </span>
                </div>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Password Baru (Kosongkan jika tidak ingin mengubah)">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div> --}}

    <div class="row mt-2">
        <div class="col-12">
            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror">
            <input type="hidden" name="old_foto" value="{{ $guru->foto }}">
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-group">
                <button type="submit" class="btn btn-primary w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M10 14l11 -11" />
                        <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" />
                    </svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('frmguru');
        const inputs = form.querySelectorAll('input, select');

        inputs.forEach(input => {
            input.addEventListener('change', function() {
                updateField(this.name, this.value);
            });
        });

        // Special handling for file input
        const fileInput = form.querySelector('input[type="file"]');
        fileInput.addEventListener('change', function() {
            updateFile(this);
        });
    });

    function updateField(fieldName, fieldValue) {
        const formData = new FormData();
        formData.append(fieldName, fieldValue);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        sendRequest(formData);
    }

    function updateFile(fileInput) {
        const formData = new FormData();
        formData.append('foto', fileInput.files[0]);
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        sendRequest(formData);
    }

    // function sendRequest(formData) {
    //     fetch('/administrator/guru/{{ $guru->nuptk }}/perbarui', {
    //             method: 'POST',
    //             headers: {
    //                 'X-Requested-With': 'XMLHttpRequest',
    //                 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
    //             },
    //             body: formData
    //         })
    //         .then(response => {
    //             if (response.redirected) {
    //                 window.location.href = response.url;
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //         });
    // }

    function sendRequest(formData) {
        fetch('/administrator/guru/{{ $guru->nuptk }}/perbarui', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
