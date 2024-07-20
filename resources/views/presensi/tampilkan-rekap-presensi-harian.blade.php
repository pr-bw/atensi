@php
    function selisih($jam_masuk, $jam_keluar)
    {
        [$h, $m, $s] = explode(':', $jam_masuk);
        $dtAwal = mktime($h, $m, $s, '1', '1', '1');
        [$h, $m, $s] = explode(':', $jam_keluar);
        $dtAkhir = mktime($h, $m, $s, '1', '1', '1');
        $dtSelisih = $dtAkhir - $dtAwal;
        $totalmenit = $dtSelisih / 60;
        $jam = explode('.', $totalmenit / 60);
        $sisamenit = $totalmenit / 60 - $jam[0];
        $sisamenit2 = $sisamenit * 60;
        $jml_jam = $jam[0];
        return $jml_jam . ':' . round($sisamenit2);
    }
@endphp

@foreach ($presensi as $d)
    @php
        $fotoIn = Storage::url('uploads/presensi/' . $d->foto_in);
        $fotoOut = Storage::url('uploads/presensi/' . $d->foto_out);
    @endphp

    <tr>
        <td style="white-space: nowrap;">{{ $loop->iteration }}</td>
        <td style="white-space: nowrap;">{{ $d->nuptk }}</td>
        <td style="white-space: nowrap;">{{ $d->nama_lengkap }}</td>
        <td style="white-space: nowrap;">{{ $d->mapel }}</td>
        <td style="white-space: nowrap;">{{ $d->jam_in }}</td>
        <td style="white-space: nowrap;">
            <img src="{{ url($fotoIn) }}" style="width: 50px;" alt="">
        </td>
        <td style="white-space: nowrap;">
            {!! $d->jam_out != null ? $d->jam_out : '<span class="badge bg-danger">Belum Melakukan Presensi</span>' !!}
        </td>
        <td style="white-space: nowrap;">
            @if ($d->jam_out != null)
                <img src="{{ url($fotoOut) }}" style="width: 50px;" alt="">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-hourglass">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M6.5 7h11" />
                    <path d="M6.5 17h11" />
                    <path d="M6 20v-2a6 6 0 1 1 12 0v2a1 1 0 0 1 -1 1h-10a1 1 0 0 1 -1 -1z" />
                    <path d="M6 4v2a6 6 0 1 0 12 0v-2a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1z" />
                </svg>
            @endif
        </td>
        <td style="white-space: nowrap;">
            @if ($d->jam_in > '07:30')
                @php
                    $jam_terlambat = selisih('07:30:00', $d->jam_in);
                @endphp
                <span class="badge bg-danger">Terlambat {{ $jam_terlambat }}</span>
            @else
                <span class="badge bg-success">Tepat Waktu</span>
            @endif
        </td>
        {{-- <td>
            <a href="#" class="btn btn-primary tampilkanPeta" id="{{ $d->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                    <path d="M9 4v13" />
                    <path d="M15 7v5.5" />
                    <path
                        d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                    <path d="M19 18v.01" />
                </svg>
            </a>
        </td> --}}
    </tr>
@endforeach

{{-- <script>
    $(function() {
        $(".tampilkanPeta").click(function(e) {
            e.preventDefault(); // Menghentikan default behavior dari anchor

            var id = $(this).attr("id");

            $.ajax({
                type: 'POST',
                url: '/tampilkanpeta',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(response) {
                    $("#loadMap").html(response); // Memuat konten peta ke dalam #loadMap
                    $("#modal-tampilkanPeta").modal(
                        "show"); // Menampilkan modal setelah konten dimuat
                },
                error: function(xhr, status, error) {
                    console.error("Error:",
                        error); // Menampilkan pesan error jika terjadi masalah
                }
            });
        });
    });
</script> --}}
