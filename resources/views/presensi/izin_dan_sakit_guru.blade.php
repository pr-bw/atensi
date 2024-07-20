@extends('layouts.admin.sbadmin2')

@section('content')
    <div class="container">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Izin / Sakit</h1>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <form action="/administrator/presensi/izin-sakit-guru" method="GET" autocomplete="off">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
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
                                    <input type="text" value="{{ Request('dari') }}" class="form-control" id="dari"
                                        name="dari" placeholder="Dari">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
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
                                    <input type="text" value="{{ Request('sampai') }}" class="form-control"
                                        id="sampai" name="sampai" placeholder="Sampai">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
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
                                    </div>
                                    <input type="text" value="{{ Request('nuptk') }}" class="form-control" id="nuptk"
                                        name="nuptk" placeholder="NUPTK">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                            </svg>
                                        </span>
                                    </div>
                                    <input type="text" value="{{ Request('nama_lengkap') }}" class="form-control"
                                        id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="status_persetujuan" id="status_persetujuan" class="form-select">
                                        <option value="">Pilih Status</option>
                                        <option value="0"
                                            {{ request('status_persetujuan') == '0' ? 'selected' : '' }}>Pending</option>
                                        <option value="1"
                                            {{ request('status_persetujuan') == '1' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="2"
                                            {{ request('status_persetujuan') == '2' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                            <path d="M21 21l-6 -6" />
                                        </svg>
                                        Cari Data Guru
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center" style="white-space: nowrap;">No.</th>
                                    <th class="text-center" style="white-space: nowrap;">Tanggal</th>
                                    <th class="text-center" style="white-space: nowrap;">NUPTK</th>
                                    <th class="text-center" style="white-space: nowrap;">Nama Guru</th>
                                    <th class="text-center" style="white-space: nowrap;">Mapel</th>
                                    <th class="text-center" style="white-space: nowrap;">Status</th>
                                    <th class="text-center" style="white-space: nowrap;">Keterangan</th>
                                    <th class="text-center" style="white-space: nowrap;">Status Persetujuan</th>
                                    <th class="text-center" style="white-space: nowrap;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($izin_dan_sakit as $d)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + $izin_dan_sakit->firstItem() - 1 }}
                                        </td>
                                        {{-- <td class="text-center">{{ $loop->iteration }}</td> --}}
                                        <td class="text-center">{{ date('d-m-Y', strtotime($d->tanggal_izin)) }}</td>
                                        <td class="text-center">{{ $d->nuptk }}</td>
                                        <td class="text-center">{{ $d->nama_lengkap }}</td>
                                        <td class="text-center">{{ $d->mapel }}</td>
                                        <td class="text-center">{{ $d->status == 'i' ? 'Izin' : 'Sakit' }}</td>
                                        <td class="text-center">{{ $d->keterangan }}</td>
                                        <td class="text-center">
                                            @if ($d->status_persetujuan == 1)
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($d->status_persetujuan == 2)
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            @if ($d->status_persetujuan == 0)
                                                <a href="#" class="btn btn-sm btn-primary approve"
                                                    data-id="{{ $d->id }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-external-link">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
                                                        <path d="M11 13l9 -9" />
                                                        <path d="M15 4h5v5" />
                                                    </svg>
                                                </a>
                                            @else
                                                <a href="/administrator/presensi/izin-sakit-guru/{{ $d->id }}/batalkan"
                                                    class="btn btn-sm btn-danger">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-square-rounded-x">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 10l4 4m0 -4l-4 4" />
                                                        <path
                                                            d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $izin_dan_sakit->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-blur fade" id="modal-izin-dan-sakit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pengajuan Izin/Sakit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/administrator/presensi/izin-sakit-guru/setujui" method="POST">
                        @csrf
                        <input type="hidden" id="id_izin_dan_sakit_form" name="id_izin_dan_sakit_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="status_persetujuan" id="status_persetujuan" class="form-select w-100">
                                        <option value="1">Disetujui</option>
                                        <option value="2">Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary w-100" type="submit">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script>
        $(document).on("click", ".approve", function(e) {
            e.preventDefault();
            let id_izin_dan_sakit = $(this).data("id");
            $("#id_izin_dan_sakit_form").val(id_izin_dan_sakit);
            $("#modal-izin-dan-sakit").modal("show");
        });

        $("#dari, #sampai").datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd'
        });
    </script>
@endpush
