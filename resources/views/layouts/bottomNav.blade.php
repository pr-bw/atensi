<style>
    .appBottomMenu {
        background-color: #FFC7ED;
    }
</style>
<div class="appBottomMenu">
    <a href="/guru/dashboard" class="item {{ request()->is('guru/dashboard') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="home"></ion-icon>
            <strong>Home</strong>
        </div>
    </a>
    <a href="/guru/presensi/riwayat-presensi"
        class="item {{ request()->is('guru/presensi/riwayat-presensi') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="calendar" role="img" class="md hydrated"></ion-icon>
            <strong>History</strong>
        </div>
    </a>
    <a href="/guru/presensi/create" class="item">
        <div class="col">
            <div class="action-button large" style="background-color: #91DDCF">
                <ion-icon name="camera" role="img" class="md hydrated"></ion-icon>
            </div>
        </div>
    </a>
    <a href="/guru/izin" class="item {{ request()->is('guru/izin') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="document-text" role="img"></ion-icon>
            <strong>Izin</strong>
        </div>
    </a>
    <a href="/guru/profile" class="item {{ request()->is('guru/profile') ? 'active' : '' }}">
        <div class="col">
            <ion-icon name="person"></ion-icon>
            <strong>Profile</strong>
        </div>
    </a>
</div>
