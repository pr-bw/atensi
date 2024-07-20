@if ($history->isEmpty())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <div class="d-flex align-items-center">
            <ion-icon name="alert-circle-outline" class="mr-2" style="font-size: 24px;"></ion-icon>
            <strong>Data Belum Ada</strong>
        </div>
        <p class="mb-0 mt-2">Belum ada riwayat presensi yang tersedia untuk periode ini.</p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@else
    @foreach ($history as $d)
        <ul class="listview image-listview">
            <li>
                <div class="item">
                    @php
                        $path = Storage::url('uploads/presensi/' . $d->foto_in);
                    @endphp
                    <img src="{{ url($path) }}" alt="image" class="image">
                    <div class="in">
                        <div>
                            <b>{{ date('d-m-Y', strtotime($d->tanggal_presensi)) }}</b>
                            <br />
                        </div>
                        <span class="badge {{ $d->jam_in < '07:00' ? 'bg-success' : 'bg-danger' }}">
                            {{ $d->jam_in }}
                        </span>
                        <span class="badge bg-primary">
                            {{ $d->jam_out }}
                        </span>
                    </div>
                </div>
            </li>
        </ul>
    @endforeach
@endif
