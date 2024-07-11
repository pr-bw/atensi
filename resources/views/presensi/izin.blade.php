@extends('layouts.presensi')

@section('header')
    {{-- App Header --}}
    <div class="appHeader text-light" style="background-color: #FFC7ED">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Izin / Sakit</div>
        <div class="right"></div>
    </div>
    {{-- App Header --}}
@endsection

@section('content')
    <div class="row" style="margin-top: 70px">
        <div class="col">
            @php
                $message_success = Session::get('success');
                $message_error = Session::get('error');
            @endphp
            @if (Session::get('success'))
                <div class="alert alert-success">
                    {{ $message_success }}
                </div>
            @endif
            @if (Session::get('error'))
                <div class="alert alert-danger">
                    {{ $message_error }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col">
            @foreach ($data_izin as $d)
                <ul class="listview image-listview">
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>
                                    <b>{{ date('d-m-Y', strtotime($d->tanggal_izin)) }}
                                        ({{ $d->status == 's' ? 'Sakit' : 'Izin' }})
                                    </b><br />
                                    <small class="text-muted">{{ $d->keterangan }}</small>
                                </div>
                                @if ($d->status_persetujuan == 0)
                                    <span class="badge bg-warning">Waiting</span>
                                @elseif ($d->status_persetujuan == 1)
                                    <span class="badge bg-success">Approved</span>
                                @elseif ($d->status_persetujuan == 2)
                                    <span class="badge bg-danger">Declined</span>
                                @endif
                            </div>
                        </div>
                    </li>
                </ul>
            @endforeach
        </div>
    </div>

    <div class="fab-button bottom-right" style="margin-bottom: 70px;">
        <a href="/karyawan/izin/buat-izin" class="fab" style="background-color: #FFF8DB">
            <ion-icon name="add-outline" style="color: #000"></ion-icon>
        </a>
    </div>
@endsection
