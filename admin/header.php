<!-- header  -->
<div class="header">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- Logo -->
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo class_static_value::$URL_BASE; ?>/admin">
                <!-- Logo icon -->
                <b>
                    <img src="../assets/backend/images/logo.png" alt="homepage" class="dark-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span>
                    Administrator
                    <!-- <img src="assets/images/logo-text.png" alt="homepage" class="dark-logo" /> -->
                </span>
            </a>
        </div>
        <!-- End Logo -->
        <div class="navbar-collapse">
            <!-- toggle and nav items -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <!-- This is  -->
                <li class="nav-item">
                    <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)">
                        <i class="mdi mdi-menu"></i>
                    </a>
                </li>
                <li class="nav-item m-l-10">
                    <a class="nav-link sidebartoggler hidden-sm-down text-muted  " href="javascript:void(0)">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <!-- Messages -->
                <!--<li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-th-large"></i>
                    </a>
                    <div class="dropdown-menu animated zoomIn">
                        <ul class="mega-dropdown-menu row">

                            <li class="col-lg-3  m-b-30">
                                <h4 class="m-b-20">CONTACT US</h4> -->
                                <!-- Contact -->
                                <!-- <form>
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name"> </div>
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Enter email"> </div>
                                    <div class="form-group">
                                        <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </form>
                            </li>
                            <li class="col-lg-3 col-xlg-3 m-b-30">
                                <h4 class="m-b-20">List style</h4> -->
                                <!-- List style -->
                                <!-- <ul class="list-style-none">
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                </ul>
                            </li>
                            <li class="col-lg-3 col-xlg-3 m-b-30">
                                <h4 class="m-b-20">List style</h4> -->
                                <!-- List style -->
                                <!-- <ul class="list-style-none">
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                </ul>
                            </li>
                            <li class="col-lg-3 col-xlg-3 m-b-30">
                                <h4 class="m-b-20">List style</h4> -->
                                <!-- List style -->
                                <!-- <ul class="list-style-none">
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> This Is Another Link</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </li> -->
                <!-- End Messages -->
            </ul>
            <!-- User profile and search -->
            <ul class="navbar-nav my-lg-0">
                <!-- Search -->
                <!-- <li class="nav-item hidden-sm-down search-box">
                    <a class="nav-link hidden-sm-down text-muted  " href="javascript:void(0)">
                        <i class="ti-search"></i>
                    </a>
                    <form class="app-search">
                        <input type="text" class="form-control" placeholder="Search here">
                            <a class="srh-btn">
                                <i class="ti-close"></i>
                            </a>
                    </form>
                </li> -->
                <!-- Comment -->
                <li class="nav-item dropdown" id="notification_center">
                    <a class="nav-link dropdown-toggle text-muted text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <div class="notify" id="notify"></div>
                        <!-- <div class="notify">
                            <span class="heartbit"></span>
                            <span class="point"></span>
                        </div> -->
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated fadeIn"> <!-- slideInRight | slideInDown -->
                        <ul>
                            <li>
                                <div class="drop-title">Notifikasi</div>
                            </li>
                            <li>
                                <div class="message-center" id="message_center">
                                    <!-- <a href="#">
                                        <div class="btn btn-info btn-circle m-r-10"><i class="fas fa-info"></i></div>
                                        <div class="mail-content">
                                            <span class="mail-desc">Tidak ada notifikasi..!</span>
                                        </div>
                                    </a> -->
                                    <!-- Message
                                    <a href="#">
                                        <div class="btn btn-danger btn-circle m-r-10"><i class="fas fa-link"></i></div>
                                        <div class="mail-content">
                                            <h5>This is title</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span>
                                        </div>
                                    </a> -->
                                    <!-- Message
                                    <a href="#">
                                        <div class="btn btn-success btn-circle m-r-10"><i class="fas fa-calendar"></i></div>
                                        <div class="mail-content">
                                            <h5>This is another title</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span>
                                        </div>
                                    </a> -->
                                    <!-- Message
                                    <a href="#">
                                        <div class="btn btn-info btn-circle m-r-10"><i class="fas fa-cog"></i></div>
                                        <div class="mail-content">
                                            <h5>This is title</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span>
                                        </div>
                                    </a> -->
                                    <!-- Message
                                    <a href="#">
                                        <div class="btn btn-primary btn-circle m-r-10"><i class="fas fa-user"></i></div>
                                        <div class="mail-content">
                                            <h5>This is another title</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span>
                                        </div>
                                    </a> -->
                                    <!-- Message 
                                    <a href="#">
                                        <div class="btn btn-warning btn-circle m-r-10"><i class="fas fa-exclamation"></i></div>
                                        <div class="mail-content">
                                            <h5>This is another title</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span>
                                        </div>
                                    </a> -->
                                </div>
                            </li>
                            <!-- <li>
                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                            </li> -->
                        </ul>
                    </div>
                </li>
                <!-- End Comment -->
                <!-- Messages -->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted" href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn" aria-labelledby="2">
                        <ul>
                            <li>
                                <div class="drop-title">You have 4 new messages</div>
                            </li>
                            <li>
                                <div class="message-center"> -->
                                    <!-- Message -->
                                    <!-- <a href="#">
                                        <div class="user-img"> <img src="assets/images/users/5.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-content">
                                            <h5>Michael Qin</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span>
                                        </div>
                                    </a> -->
                                    <!-- Message -->
                                    <!-- <a href="#">
                                        <div class="user-img"> <img src="assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>John Doe</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span>
                                        </div>
                                    </a> -->
                                    <!-- Message -->
                                    <!-- <a href="#">
                                        <div class="user-img"> <img src="assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Mr. John</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span>
                                        </div>
                                    </a> -->
                                    <!-- Message -->
                                    <!-- <a href="#">
                                        <div class="user-img"> <img src="assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>Michael Qin</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span>
                                        </div>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
                <!-- End Messages -->
                <!-- Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo searchFile($_SESSION['url_foto'], 'img', 'short'); ?>" alt="user" class="profile-pic" />
                        <?php echo $_SESSION['nama_lengkap']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated slideInRight">
                        <ul class="dropdown-user">
                            <li>
                                <a href="?content=profil_pengguna">
                                    <i class="fas fa-user"></i>
                                    Profil
                                </a>
                            </li>
                            <!-- <li><a href="#"><i class="ti-wallet"></i> Balance</a></li>
                            <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                            <li><a href="#"><i class="ti-settings"></i> Setting</a></li> -->
                            <li>
                                <a href="../index.php?content=login_proses&proses=logout">
                                    <i class="fas fa-power-off"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- End Profile -->
            </ul>
            <!-- End User profile and search -->
        </div>
    </nav>
</div>
<!-- End header header -->
<!-- Left Sidebar  -->
<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li class="nav-label">Home</li>
                <li>
                    <a aria-expanded="false" href="?content=beranda"> <!-- class="has-arrow" -->
                        <i class="fas fa-tachometer-alt"></i>
                        <span class="hide-menu">
                            Dashboard
                            <!-- <span class="label label-rouded label-primary pull-right">
                                2
                            </span> -->
                        </span>
                    </a>
                    <!-- <ul class="collapse" aria-expanded="false">
                        <li><a href="index.html">Ecommerce </a></li>
                        <li><a href="index1.html">Analytics </a></li>
                    </ul> -->
                </li>
                <!-- <li class="nav-label">Apps</li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Email</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="email-compose.html">Compose</a></li>
                        <li><a href="email-read.html">Read</a></li>
                        <li><a href="email-inbox.html">Inbox</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Charts</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="chart-flot.html">Flot</a></li>
                        <li><a href="chart-morris.html">Morris</a></li>
                        <li><a href="chart-chartjs.html">ChartJs</a></li>
                        <li><a href="chart-chartist.html">Chartist </a></li>
                        <li><a href="chart-amchart.html">AmChart</a></li>
                        <li><a href="chart-echart.html">EChart</a></li>
                        <li><a href="chart-sparkline.html">Sparkline</a></li>
                        <li><a href="chart-peity.html">Peity</a></li>
                    </ul>
                </li> -->
                <li class="nav-label">Transaksi</li>
                <li>
                    <a class="no-arrow" aria-expanded="false" href="?content=pemesanan">
                        <i class="fab fa-first-order"></i>
                        <span class="hide-menu">
                            Transaksi
                            <?php if (countPemesanan('tunggu', '') >= 1): ?>
                                <span class="label label-rouded label-danger pull-right">
                                    <?php echo countPemesanan('tunggu', ''); ?>
                                </span>
                            <?php endif ?>
                        </span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" aria-expanded="false" href="#">
                        <i class="fas fa-history"></i>
                        <span class="hide-menu">
                            Riwayat Transaksi
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <!--
                            <li>
                                <a href="?content=pemesanan_riwayat_menunggu">Menuggu</a>
                            </li>
                        -->
                        <li>
                            <a href="?content=pemesanan_riwayat_proses">Proses</a>
                        </li>
                        <li>
                            <a href="?content=pemesanan_riwayat_selesai">Selesai</a>
                        </li>
                        <li>
                            <a href="?content=pemesanan_riwayat_batal">Batal</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-label">Data Master</li>
                <li>
                    <a class="has-arrow" aria-expanded="false" href="#">
                        <i class="fas fa-users"></i>
                        <span class="hide-menu">
                            Data Pengguna
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="?content=data_pengguna_teknisi">Teknisi</a>
                        </li>
                        <li>
                            <a href="?content=data_pengguna_pelanggan">Pelanggan</a>
                        </li>
                        <!-- <li>
                            <a href="?content=data_pengguna">Pengguna Lain</a>
                        </li> -->
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" aria-expanded="false" href="#">
                        <i class="fab fa-servicestack"></i>
                        <span class="hide-menu">
                            Data Layanan
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="?content=data_layanan_kategori">Kategori</a>
                        </li>
                        <!-- <li>
                            <a href="?content=data_layanan_kategori_sub">Sub Kategori</a>
                        </li> -->
                        <li>
                            <a class="has-arrow" aria-expanded="false" href="#">
                                Jenis
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a href="?content=data_layanan_jenis_hardware">Hardware</a>
                                </li>
                                <li>
                                    <a href="?content=data_layanan_jenis_software">Software</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a aria-expanded="false" href="?content=data_sparepart"> <!-- class="has-arrow" -->
                        <i class="fas fa-suitcase"></i>
                        <span class="hide-menu">
                            Data Sparepart
                        </span>
                    </a>
                </li>

                <li class="nav-label">Data Laporan</li>

                <li>
                    <a class="has-arrow" aria-expanded="false" href="#">
                        <i class="fas fa-book-reader"></i>
                        <span class="hide-menu">
                            Laporan Pengguna
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="?content=laporan_teknisi">Teknisi</a>
                        </li>
                        <li>
                            <a href="?content=laporan_pelanggan">Pelanggan</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a aria-expanded="false" href="?content=laporan_transaksi"> <!-- class="has-arrow" -->
                        <i class="fas fa-file-alt"></i>
                        <span class="hide-menu">
                            Laporan Transaksi
                        </span>
                    </a>
                </li>

                <li class="nav-label">Data Konfigurasi</li>
                <li>
                    <a class="has-arrow" aria-expanded="false" href="#">
                        <i class="fas fa-bars"></i>
                        <span class="hide-menu">
                            Menu (Header)
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="?content=data_konfigurasi_menu_pelanggan">Pelanggan</a>
                        </li>
                        <!-- <li>
                            <a href="?content=data_konfigurasi_menu_teknisi">Teknisi</a>
                        </li> -->
                    </ul>
                </li>
                <li>
                    <a aria-expanded="false" href="?content=data_konfigurasi_umum"> <!-- class="has-arrow" -->
                        <i class="fas fa-cog"></i>
                        <span class="hide-menu">
                            Umum
                        </span>
                    </a>
                </li>
                <li>
                    <a aria-expanded="false" href="?content=data_konfigurasi_syarat_ketentuan"> <!-- class="has-arrow" -->
                        <i class="fas fa-list"></i>
                        <span class="hide-menu">
                            Syarat &amp; Ketentuan
                        </span>
                    </a>
                </li>
                <!-- <li>
                    <a class="has-arrow" href="#" aria-expanded="false">
                        <i class="fa fa-suitcase"></i>
                        <span class="hide-menu">
                            Components
                            <span class="label label-rouded label-danger pull-right">
                                6
                            </span>
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="uc-calender.html">Calender</a></li>
                        <li><a href="uc-datamap.html">Datamap</a></li>
                        <li><a href="uc-nestedable.html">Nestedable</a></li>
                        <li><a href="uc-sweetalert.html">Sweetalert</a></li>
                        <li><a href="uc-toastr.html">Toastr</a></li>
                        <li><a href="uc-weather.html">Weather</a></li>
                    </ul>
                </li> -->
                <!-- <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Forms</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="form-basic.html">Basic Forms</a></li>
                        <li><a href="form-layout.html">Form Layout</a></li>
                        <li><a href="form-validation.html">Form Validation</a></li>
                        <li><a href="form-editor.html">Editor</a></li>
                        <li><a href="form-dropzone.html">Dropzone</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Tables</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="table-bootstrap.html">Basic Tables</a></li>
                        <li><a href="table-datatable.html">Data Tables</a></li>
                    </ul>
                </li>
                <li class="nav-label">Layout</li>
                <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-columns"></i><span class="hide-menu">Layout</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="layout-blank.html">Blank</a></li>
                        <li><a href="layout-boxed.html">Boxed</a></li>
                        <li><a href="layout-fix-header.html">Fix Header</a></li>
                        <li><a href="layout-fix-sidebar.html">Fix Sidebar</a></li>
                    </ul>
                </li> -->
                <!-- <li class="nav-label">EXTRA</li>
                <li>
                  <a class="has-arrow  " href="#" aria-expanded="false">
                    <i class="fas fa-book"></i>
                    <span class="hide-menu">
                      Pages
                      <span class="label label-rouded label-success pull-right">
                        8
                      </span>
                    </span>
                  </a>
                    <ul aria-expanded="false" class="collapse">
                        <li>
                            <a href="#" class="has-arrow">
                                Authentication
                                <span class="label label-rounded label-success">
                                    6
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="page-login.html">Login</a></li>
                                <li><a href="page-register.html">Register</a></li>
                                <li><a href="page-invoice.html">Invoice</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#" class="has-arrow">Error Pages</a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="page-error-400.html">400</a></li>
                                <li><a href="page-error-403.html">403</a></li>
                                <li><a href="page-error-404.html">404</a></li>
                                <li><a href="page-error-500.html">500</a></li>
                                <li><a href="page-error-503.html">503</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow  " href="#" aria-expanded="false">
                        <i class="fas fa-map-marker"></i>
                        <span class="hide-menu">
                            Maps
                        </span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="map-google.html">Google</a></li>
                        <li><a href="map-vector.html">Vector</a></li>
                    </ul>
                </li>
                <li>
                  <a class="has-arrow  " href="#" aria-expanded="false">
                    <i class="fas fa-level-down-alt"></i>
                    <span class="hide-menu">
                      Multi level dd
                    </span>
                  </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="#">item 1.1</a></li>
                        <li><a href="#">item 1.2</a></li>
                        <li> <a class="has-arrow" href="#" aria-expanded="false">Menu 1.3</a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="#">item 1.3.1</a></li>
                                <li><a href="#">item 1.3.2</a></li>
                                <li><a href="#">item 1.3.3</a></li>
                                <li><a href="#">item 1.3.4</a></li>
                            </ul>
                        </li>
                        <li><a href="#">item 1.4</a></li>
                    </ul>
                </li> -->
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>
<!-- End Left Sidebar