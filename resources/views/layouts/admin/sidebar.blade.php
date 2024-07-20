 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/administrator/dashboard">
         <!-- GANTI dengan nama dan foto dari logo sekolah -->
         <img src="{{ asset('assets/img/admin/logo_smp_islam_parung.png') }}" alt="Logo SMP Islam Parung"
             style="width: 70px; height: auto; border-radius: 50%;">
         <div class="sidebar-brand-text mx-2">SMP Islam Parung</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0">

     <!-- Nav Item - Dashboard -->
     <li class="nav-item active">
         <a class="nav-link" href="/administrator/dashboard">
             <i class="fas fa-fw fa-home"></i>
             <span>Home</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider">

     <!-- Nav Item - Data Master -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDataMaster"
             aria-expanded="false" aria-controls="collapseDataMaster">
             <i class="fas fa-fw fa-database"></i>
             <span>Data Master</span>
         </a>
         <div id="collapseDataMaster" class="collapse" aria-labelledby="headingDataMaster"
             data-parent="#accordionSidebar" style="">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Kelola Data:</h6>
                 <a class="collapse-item" href="/administrator/guru">Data Guru</a>
             </div>
         </div>
     </li>

     <!-- Monitoring Presensi -->
     <li class="nav-item">
         <a class="nav-link" href="/administrator/presensi/monitoring">
             <i class="fas fa-fw fa-clock"></i>
             <span>Monitoring Presensi</span>
         </a>
     </li>

     <!-- Data Izin / Sakit -->
     <li class="nav-item">
         <a class="nav-link" href="/administrator/presensi/izin-sakit-guru">
             <i class="fas fa-fw fa-file-alt"></i>
             <span>Data Izin / Sakit</span>
         </a>
     </li>

     <!-- Laporan -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
             aria-expanded="false" aria-controls="collapseLaporan">
             <i class="fas fa-fw fa-chart-line"></i>
             <span>Laporan</span>
         </a>
         <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan" data-parent="#accordionSidebar"
             style="">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="/administrator/presensi/laporan/guru">Presensi</a>
                 <a class="collapse-item" href="/administrator/presensi/rekapitulasi">Rekap Presensi</a>
                 {{-- <a class="collapse-item" href="utilities-animation.html">Animations</a>
                 <a class="collapse-item" href="utilities-other.html">Other</a> --}}
             </div>
         </div>
     </li>

     <!-- Nav Item - Konfigurasi -->
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKonfigurasi"
             aria-expanded="false" aria-controls="collapseKonfigurasi">
             <i class="fas fa-fw fa-cog"></i>
             <span>Konfigurasi</span>
         </a>
         <div id="collapseKonfigurasi" class="collapse" aria-labelledby="headingKonfigurasi"
             data-parent="#accordionSidebar" style="">
             <div class="bg-white py-2 collapse-inner rounded">
                 <a class="collapse-item" href="/administrator/konfigurasi/lokasi-sekolah">Lokasi Sekolah</a>
             </div>
         </div>
     </li>

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>
 </ul>
 <!-- End of Sidebar -->
