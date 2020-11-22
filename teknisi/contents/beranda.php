<?php
    $transaksiTunggu    = getPemesananSubJoinAll('tunggu');
    $transaksiProses    = mysqli_num_rows(getPemesananSubJoinAll('proses'));
    $transaksiSelesai   = mysqli_num_rows(getPemesananSubJoinAll('selesai'));
    $transaksiBatal     = mysqli_num_rows(getPemesananSubJoinAll('batal'));
    $transaksiTotal     = mysqli_num_rows(getPemesananAll());
    $pelangganTotal     = mysqli_num_rows(getPelangganAll());
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Dashboard</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">

    <?php getNotifikasi(); ?>

    <!-- Start Page Content -->
    <div class="row">
        <div class="col-md">

            <!-- Badge 1 - Jumlah masing-masing Jenis Transaksi -->
            <!-- <div class="row">
                <div class="col-md">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fas fa-exclamation f-s-40 color-warning"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><?php //echo mysqli_num_rows($transaksiTunggu); ?></h2>
                                <p class="m-b-0">Transaksi Tunggu</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fas fa-shopping-cart f-s-40 color-success"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><?php //echo $transaksiProses; ?></h2>
                                <p class="m-b-0">Transaksi Proses</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fas fa-archive f-s-40 color-default"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><? //echo $transaksiTotal; ?></h2>
                                <p class="m-b-0">Total Transaksi</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- End Badge 1 -->

            <!-- Badge 2 - Jumlah Transaksi & Pelanggan -->
            <!-- <div class="row">
                <div class="col-md">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fas fa-dollar-sign f-s-40 color-primary"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><? //echo $transaksiSelesai; ?></h2>
                                <p class="m-b-0">Transaksi Selesai</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fas fa-times f-s-40 color-danger"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><? //echo $transaksiBatal; ?></h2>
                                <p class="m-b-0">Transaksi Batal</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card p-30">
                        <div class="media">
                            <div class="media-left meida media-middle">
                                <span><i class="fas fa-user f-s-40 color-dark"></i></span>
                            </div>
                            <div class="media-body media-text-right">
                                <h2><? //echo $pelangganTotal; ?></h2>
                                <p class="m-b-0">Total Pelanggan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- End Badge 2 -->

        </div>
    </div>
    <!-- End Page Content Row -->
    
    <div class="row">
        <div class="col-md-8">
            <!-- <div class="card">
                <div class="card-title">
                    <h4>Pemesanan Terbaru (10)</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Tanggal/Waktu</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php //foreach ($transaksiTunggu as $data): ?>
                                    <tr>
                                        <td>
                                            <div class="round-img">
                                                <a href="#">
                                                    <img src="<?php //echo searchFile($data['url_foto'], 'img', 'short'); ?>" alt="<?php //echo $data['nama_lengkap']; ?>">
                                                </a>
                                            </div>
                                        </td>
                                        <td><?php //echo $data['nama_lengkap']; ?></td>
                                        <td><span><?php //echo $data['tanggal_pesan']; ?></span></td>
                                        <td><span><?php //echo $data['nama_kategori_layanan']; ?></span></td>
                                        <td><?php //echo setBadges($data['status_pemesanan']); ?></td>
                                    </tr>
                                <?php //endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
        </div>
        <div class="col-md-4">
            <!-- <div class="card">
                <div class="card-body">
                    <div class="year-calendar"></div>
                </div>
            </div> -->
        </div>
    </div>
    <!-- End Page Content Row -->

</div>
<!-- End Container fluid  -->