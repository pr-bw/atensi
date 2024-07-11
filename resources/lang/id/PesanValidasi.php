<?php

return [
    /*
    |---------------------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi
    |---------------------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan oleh kelas pengaya saat kita memerlukan
    | terjemahan beberapa informasi yang digunakan oleh kelas pengaya
    | untuk logika validasi.
    |
    */

    'accepted'             => 'Isian :attribute harus diterima.',
    'active_url'           => 'Isian :attribute bukan URL yang valid.',
    // ... (kode lainnya)
    'numeric'              => 'Isian :attribute harus berupa angka.',
    'password'             => 'Kata sandi salah.',
    'present'              => 'Isian :attribute harus ada.',
    'regex'                => 'Format isian :attribute tidak valid.',
    'required'             => 'Isian :attribute wajib diisi.',
    'required_if'          => 'Isian :attribute wajib diisi bila :other adalah :value.',
    'required_unless'      => 'Isian :attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => 'Isian :attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => 'Isian :attribute wajib diisi bila terdapat :values.',
    'required_without'     => 'Isian :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Isian :attribute wajib diisi bila tidak terdapat ada :values.',
    'same'                 => 'Isian :attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => 'Isian :attribute harus berukuran :size.',
        'file'    => 'Isian :attribute harus berukuran :size kilobytes.',
        'string'  => 'Isian :attribute harus berukuran :size karakter.',
        'array'   => 'Isian :attribute harus mengandung :size anggota.',
    ],
    'starts_with'          => 'Isian :attribute harus diawali salah satu dari nilai berikut: :values',
    'string'               => 'Isian :attribute harus berupa string.',
    'timezone'             => 'Isian :attribute harus berupa zona waktu yang valid.',
    'unique'               => 'Isian :attribute sudah ada sebelumnya.',
    'uploaded'             => 'Isian :attribute gagal diunggah.',
    'url'                  => 'Format isian :attribute tidak valid.',
    'uuid'                 => 'Isian :attribute harus merupakan UUID yang valid.',

    /*
    |---------------------------------------------------------------------------------------
    | Baris Bahasa untuk Validasi Kustom
    |---------------------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi untuk atribut sesuai keinginan dengan
    | menggunakan konvensi "atribut.aturan" dalam penamaan baris. Hal ini
    | memperkenankan garis Anda tetap rapi dan mudah untuk dipelihara.
    |
    */

    'custom' => [
        'nomor_hp' => [
            'min' => 'Nomor Handphone minimal :min digit',
            'max' => 'Nomor Handphone maksimal :max digit',
        ],
        'password' => [
            'min' => 'Password minimal :min karakter',
            'confirmed' => 'Konfirmasi password tidak sama dengan password',
        ],
    ],

    /*
    |---------------------------------------------------------------------------------------
    | Kustom Validasi Atribut
    |---------------------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar 'placeholder' atribut
    | dengan sesuatu yang lebih mudah dimengerti oleh pembaca seperti
    | 'Alamat Surel' daripada 'surel' untuk membantu membuat pesan sedikit
    | bersih. Misalnya:
    |
    | 'email' => 'alamat surel'
    |
    */

    'attributes' => [],
];
