<?php
    cekLogin('pelanggan');
    if (isset($_GET['proses']) and $_GET['proses'] == "ganti-password" and isset($_POST['currentPassword']) and isset($_POST['newPassword'])) {
        $proses = $_GET['proses'];
        // $result = ;
        if (changePassword($_POST['currentPassword'], $_POST['newPassword'], $_SESSION['id_pelanggan']) == TRUE) {
            echo "<script>window.location.replace('$csv::$URL_BASE/?content=profil'); </script>";
        } else {
            echo "<script>window.location.replace('$csv::$URL_BASE/?content=beranda'); </script>";
        }
    } elseif (isset($_GET['proses']) and $_GET['proses'] == "ganti_foto_profil") {
        if (changeFotoPelanggan($_SESSION['id'], $_FILES['url_foto'])) {
            echo "<script>window.location.replace('" . $csv::$URL_BASE . "/?content=profil'); </script>";
        } else {
            echo "<script>window.location.replace('" . $csv::$URL_BASE . "/?content=profil'); </script>";
        }
    }
    $pelanggan  = mysqli_fetch_array(getPelangganById($_SESSION['id']), MYSQLI_BOTH);
    $orPending  = getPemesananSubJoinByIdPelanggan($_SESSION['id'], 'tunggu');
    $orProses   = getPemesananSubJoinByIdPelanggan($_SESSION['id'], 'proses_batal');
    $orSelesai  = getPemesananSubJoinByIdPelanggan($_SESSION['id'], 'selesai');
    $orBatal    = getPemesananSubJoinByIdPelanggan($_SESSION['id'], 'batal');
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Profil [<?= $_SESSION['username'] ?>]</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">
                            <i class="fa fa-user"></i>
                            Profil
                        </li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcrumb Area End ##### -->
<!-- ##### Blog Area Start ##### -->
<section class="alazea-blog-area section-padding-0-100">
    <div class="container">
        <?php getNotifikasi(); ?>
        <div class="row">
            <div class="col-md-12">
                <!-- Section Heading -->
                <!-- <div class="section-heading text-center">
                    <h2>Profil</h2>
                    <p>The breaking news about Gardening &amp; House plants</p>
                    <p><?php //echo generateToken(); ?></p>
                </div> -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="text-left">Foto</div>
                                    <div class="text-right">
                                        <button
                                            type="button"
                                            class="btn btn-link btn-sm mt-0 pt-0"
                                            data-toggle="modal"
                                            data-target="#modal_change_profil_picture"
                                            style="border-top: 0;"
                                        >
                                            Ganti
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </div>
                                </div>
                                <img class="img-thumbnail img-responsive" src="<?php echo searchFile($_SESSION["url_foto"], "img", "short"); ?>">
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>
                                            Nama : <?php echo $pelanggan['nama_lengkap']; ?>
                                            <a
                                                class="btn btn-link btn-sm ml-5"
                                                href="?content=profil_form&action=ubah"
                                            >
                                                <i class="fa fa-edit"></i>
                                                Ubah Data Profil
                                            </a>
                                            <br>
                                            No. Telepon : <?php echo $pelanggan['no_hp']; ?> <br>
                                            Alamat : <?php echo $pelanggan['alamat']; ?> <br><br>
                                            <!-- Button trigger modal -->
                                            <button
                                                type="button"
                                                class="btn btn-blue btn-md"
                                                data-toggle="modal"
                                                data-target="#modal_change_password">
                                                <!-- <i class="fa fa-5x fa-pencil-square-o"></i> -->
                                                <i class="fa fa-edit"></i>
                                                Ubah Password
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <div class="table-responsive"> -->
                                    <p>
                                        <h3>History Pemesanan</h3>
                                    </p>

                                    <ul class="nav nav-tabs nav-fill" id="nav-tab" role="tablist" id="product-details-tab">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="nav-home" aria-selected="true">
                                                Pending
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="nav-menu1-tab" data-toggle="tab" href="#menu1" role="tab" aria-controls="menu1" aria-selected="false">
                                                Proses
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="nav-menu2-tab" data-toggle="tab" href="#menu2" role="tab" aria-controls="menu2" aria-selected="false">
                                                Selesai
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="nav-menu3-tab" data-toggle="tab" href="#menu3" role="tab" aria-controls="menu3" aria-selected="false">
                                                Batal
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="nav-tabContent">
    <!-- Tab Pending -->
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="nav-home-tab">
        <div class="description_area">
            <br>

            <p align="justify">
                Untuk pemesanan yang telah disetujui oleh pelanggan, harap segera melakukan pembayaran dan mengirim bukti pembayarabn maksimal 5 jam setelah melakukan pemesanan. Apabila tidak melakukan pengiriman bukti pembayaran dalam rentang waktu yang telah disebutkan, maka pemesanan akan dibatalkan.
            </p>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th> <th>Tanggal</th> <th>Total Harga</th> <th>Datang ke Lokasi</th> <th>Status Pemesanan</th> <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($order = mysqli_fetch_array($orPending, MYSQLI_BOTH)) : ?>
                            <?php
                                $persetujuanPelanggan = 'belum';
                                foreach (getDetailPemesananByIdPemesanan($order['id_pemesanan'], '', '', '', 'ASC') as $data) {
                                    $persetujuanPelanggan = $data['persetujuan_pelanggan'];
                                }
                            ?>
                            <tr>
                                <td><?php echo $order['no_pemesanan']; ?></td>
                                <td><?php echo $order['tanggal_pesan']; ?></td>
                                <td><?php echo format(getTotalHargaPemesanan($order['id_pemesanan']), "currency"); ?></td>
                                <td><?php echo setBadges($order['datang_ke_lokasi']); ?></td>
                                <td>
                                    <?php echo setBadges($order['status_pemesanan']); ?>
                                    <?php
                                    $pembayaran = mysqli_num_rows(getBuktiPembayaranByIdPemesanan($order['id_pemesanan'], ''));
                                    $pembayaran = 0;
                                    $cekPembayaranPanjar = getBuktiPembayaranByIdPemesanan($order[0], 'panjar');
                                    if (mysqli_num_rows($cekPembayaranPanjar) != 0) {
                                        foreach ($cekPembayaranPanjar as $data) {
                                            if ($data['konfirmasi_admin'] == 'ya' OR $data['konfirmasi_admin'] == 'belum') {
                                                $pembayaran += (int)$data['jumlah'];
                                            }
                                        }
                                    }
                                    if ($order['status_pemesanan'] == 'tunggu' and $pembayaran == 0 and $order['teknisi_check'] == "sudah" and $persetujuanPelanggan == "ya") :
                                    ?>
                                        <?php
                                            $unique = str_replace('-', '', $order['id_pemesanan']);
                                            $date = new DateTime($order['tanggal_pesan']);
                                            $date->add(new DateInterval('PT5H'));
                                            $expiration = $date->format('Y-m-d H:i:s');
                                            // echo $expiration;
                                        ?>
                                        <p id="countDown-<?php echo $unique; ?>"></p>
                                        <script type="text/javascript">
                                            // Display the countdown timer in an element
                                            // Set the date we're counting down to
                                            var countDownDate_<?php echo $unique; ?> = new Date("<?php echo $expiration; ?>").getTime();
                                            var distance_<?php echo $unique; ?>;
                                            // Update the count down every 1 second
                                            var x_<?php echo $unique; ?> = setInterval(function() {

                                                // Get todays date and time
                                                var now_<?php echo $unique; ?> = new Date().getTime();

                                                // Find the distance between now an the count down date
                                                distance_<?php echo $unique; ?> = countDownDate_<?php echo $unique; ?> - now_<?php echo $unique; ?>;

                                                // Time calculations for days, hours, minutes and seconds
                                                var days_<?php echo $unique; ?> = Math.floor(distance_<?php echo $unique; ?> / (1000 * 60 * 60 * 24));
                                                var hours_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                var minutes_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60 * 60)) / (1000 * 60));
                                                var seconds_<?php echo $unique; ?> = Math.floor((distance_<?php echo $unique; ?> % (1000 * 60)) / 1000);

                                                // Display the result in the element with id="demo"
                                                document.getElementById("countDown-<?php echo $unique; ?>").innerHTML =
                                                        days_<?php echo $unique; ?> + " Hari " +
                                                        hours_<?php echo $unique; ?> + " Jam " +
                                                        minutes_<?php echo $unique; ?> + " Menit " +
                                                        seconds_<?php echo $unique; ?> + " Detik ";
                                                // console.log(distance);
                                                // If the count down is finished, write some text
                                                if (distance_<?php echo $unique; ?> <= 0) {
                                                    clearInterval(x_<?php echo $unique; ?>)     ;
                                                    document.getElementById("countDown-<?php echo $unique; ?>").innerHTML = "Proccessing...";
                                                    $.ajax({
                                                        url: 'functions/function_responds.php?content=set_status_pemesanan',
                                                        type: 'POST',
                                                        dataType: 'html',
                                                        async: false,
                                                        data: {
                                                            id: '<?php echo $order['id_pemesanan']; ?>',
                                                            status_pemesanan : 'batal'
                                                        },
                                                    }).done(function() {
                                                        console.log("success");
                                                        window.location.replace('?content=profil');
                                                    }).fail(function() {
                                                        console.log("error");
                                                    }).always(function() {
                                                        console.log("complete");
                                                    });
                                                }
                                            }, 1000);
                                            // console.log(distance);
                                        </script>
                                    <?php endif ?>
                                </td>
                                <td>
                                    <?php if ($order['teknisi_check'] == "sudah" and $persetujuanPelanggan == "belum") : ?>
                                        <a class="btn btn-warning btn-block btn-sm mb-2" href="?content=perbaikan_persetujuan_form&action=persetujuan&id=<?php echo $order['id_pemesanan'] ; ?>"
                                        >
                                            <i class="fa fa-upload"></i>
                                            Persetujuan
                                        </a>
                                    <?php endif ?>
                                    <?php if ($order['status_pemesanan'] == 'tunggu' and $pembayaran == 0 and $order['teknisi_check'] == "sudah" and $persetujuanPelanggan == "ya") : ?>
                                        <a class="btn btn-warning btn-block btn-sm mb-2" href="?content=pembayaran_panjar_form&action=tambah&noPemesanan=<?php echo $order['no_pemesanan']; ?>"
                                        >
                                            <i class="fa fa-upload"></i>
                                            Upload Bukti Pembayaran Panjar
                                        </a>
                                    <?php endif ?>
                                    <button type="button" class="btn btn-danger btn-block btn-sm mb-2" onclick="confirm('Apakah anda yakin ingin membatalkan pemesanan ini..?', '<?php echo "?content=perbaikan_persetujuan_proses&proses=batal&id=" . $order['id_pemesanan']; ?>');">
                                        <i class="fa fa-times"></i>
                                        Batal
                                    </button>
                                    <a class="btn btn-dark btn-block btn-sm mb-2" href="?content=perbaikan_detail&id=<?php echo $order['id_pemesanan']; ?>"
                                    >
                                        <i class="fa fa-list text-light"></i>
                                        Details
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Proses -->
    <div class="tab-pane fade" id="menu1" role="tabpanel" aria-labelledby="nav-menu1-tab">
        <div class="description_area">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th> <th>Tanggal Pemesanan</th> <th>Total Harga</th> <th>Diantarkan</th> <th>Status Pemesanan</th> <th>Nota</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_array($orProses, MYSQLI_BOTH)) : ?>
                            <?php $persetujuanPelanggan = getPersetujuanPelangganTerakhir($order['id_pemesanan']); ?>
                            <?php if (($order['status_pemesanan'] == 'proses') OR ($order['status_pemesanan'] == 'batal' AND mysqli_num_rows(getBuktiPembayaranByIdPemesanan($order['id_pemesanan'], 'lunas')) > 0) AND (getSisaPembayaranPemesanan($order['id_pemesanan']) > 0)) : ?>
                                <tr>
                                    <td><?php echo $order['no_pemesanan']; ?></td>
                                    <td><?php echo $order['tanggal_pesan']; ?></td>
                                    <td><?php echo format(getTotalHargaPemesanan($order['id_pemesanan']), 'currency'); ?></td>
                                    <td><?php echo setBadges($order['datang_ke_lokasi']); ?></td>
                                    <td>
                                        <?php echo setBadges($order['status_pemesanan']); ?>
                                    </td>
                                    <td>
                                        <?php
                                            $totalHarga = (int) getTotalHargaPemesanan($order['id_pemesanan']);
                                            $pembayaranPanjar = 0;
                                            $cekPembayaranPanjar = getBuktiPembayaranByIdPemesanan($order[0], 'panjar');
                                            if (mysqli_num_rows($cekPembayaranPanjar) != 0) {
                                                foreach ($cekPembayaranPanjar as $data) {
                                                    if ($data['konfirmasi_admin'] == 'ya' OR $data['konfirmasi_admin'] == 'belum') {
                                                        $pembayaranPanjar += (int)$data['jumlah'];
                                                    }
                                                }
                                            }
                                            $pembayaranLunas = 0;
                                            $cekPembayaranLunas = getBuktiPembayaranByIdPemesanan($order['id_pemesanan'], 'lunas');
                                            if (mysqli_num_rows($cekPembayaranLunas) != 0) {
                                                foreach ($cekPembayaranLunas as $data) {
                                                    if ($data['konfirmasi_admin'] == 'ya' OR $data['konfirmasi_admin'] == 'belum') {
                                                        $pembayaranLunas += (int) $data['jumlah'];
                                                    }
                                                }
                                            }
                                            $sisaPembayaran = $totalHarga - ($pembayaranPanjar + $pembayaranLunas);
                                        ?>
                                        <?php if ($order['teknisi_check'] == "sudah" and $persetujuanPelanggan == "belum") : ?>
                                            <a class="btn btn-warning btn-sm mb-2" href="?content=perbaikan_persetujuan_form&action=persetujuan&id=<?php echo $order['0']; ?>">
                                                <i class="fa fa-upload"></i>
                                                Persetujuan
                                            </a>
                                        <?php endif ?>
                                        <?php if (($pembayaranLunas == 0) AND ($sisaPembayaran != 0) AND ($order['teknisi_check'] == "selesai")) : ?>
                                            <a class="btn btn-warning btn-sm mb-2" href="?content=pembayaran_lunas_form&action=tambah&noPemesanan=<?php echo $order['no_pemesanan']; ?>">
                                                <i class="fa fa-upload"></i>
                                                Upload Bukti Pembayaran Lunas
                                            </a>
                                        <?php elseif ($order['teknisi_check'] == "selesai" AND mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], 'lunas'))['konfirmasi_admin'] == 'ya') : ?>
                                            <button type="button" class="btn btn-success btn-sm mb-2" onclick="confirm('Apakah anda yakin perangkat telah kembali..?', '<?php echo "?content=perbaikan_persetujuan_proses&proses=finish&id=" . $order['id_pemesanan']; ?>');">
                                                <i class="fa fa-check-square-o"></i>
                                                Perangkat Telah Kembali
                                            </button>
                                        <?php endif ?>
                                        <form action="<?php echo $csv::$URL_BASE; ?>/nota.php" method="POST" target="_blank">
                                            <input type="hidden" name="id" value="<?php echo $order[0]; ?>">
                                            <button type="submit" class="btn btn-primary btn-sm mb-2">
                                                <i class="fa fa-print"></i>
                                                Nota
                                            </button>
                                            <?php if ($pembayaranLunas == 0) : ?>
                                                <button type="button" class="btn btn-danger btn-sm mb-2" onclick="confirm('Apakah anda yakin ingin membatalkan pemesanan ini..?', '<?php echo "?content=perbaikan_persetujuan_proses&proses=batal&id=" . $order['id_pemesanan']; ?>');">
                                                    <i class="fa fa-times"></i>
                                                    Batal
                                                </button>
                                            <?php endif ?>
                                            <a class="btn btn-dark btn-sm mb-2" href="?content=perbaikan_detail&id=<?php echo $order[0]; ?>">
                                                <i class="fa fa-list text-light"></i>
                                                Details
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            <?php endif ?>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Selesai -->
    <div class="tab-pane fade" id="menu2" role="tabpanel" aria-labelledby="nav-menu2-tab">
        <div class="description_area">
            <!-- <br> -->
            <!-- <p align="justify">
            </p> -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th> <th>Tanggal Pemesanan</th> <th>Total Harga</th> <th>Diantarkan</th> <th>Status Pemesanan</th> <th>Rating dari Pelanggan</th> <th>Aksi </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($order = mysqli_fetch_array($orSelesai, MYSQLI_BOTH)) : ?>
                            <?php
                                $persetujuanPelanggan = 'belum';
                                foreach (getDetailPemesananByIdPemesanan($order['id_pemesanan'], '', '', '', 'ASC') as $data) {
                                    $persetujuanPelanggan = $data['persetujuan_pelanggan'];
                                }
                            ?>
                            <tr>
                                <td><?php echo $order['no_pemesanan']; ?></td>
                                <td><?php echo $order['tanggal_pesan']; ?></td>
                                <td><?php echo format(getTotalHargaPemesanan($order['id_pemesanan']), 'currency'); ?></td>
                                <td><?php echo setBadges($order['datang_ke_lokasi']); ?></td>
                                <td><?php echo setBadges($order['status_pemesanan']); ?></td>
                                <td><div id="ratingTemplate"><?php echo $rating = (isset($order['rating']) AND (!empty($order['rating']) OR $order['rating'] != NULL)) ? showRating($order['rating'], 20) : showRating(0, 20) ; ?></div></td>
                                <td>
                                    <?php if ($order['status_pemesanan'] == 'selesai') : ?>
                                        <form action="<?php echo $csv::$URL_BASE; ?>/nota.php" method="POST" target="_blank">
                                            <input type="hidden" name="id" value="<?php echo $order[0]; ?>">
                                            <button type="submit" class="btn btn-warning btn-sm mb-2" target="_blank"
                                            >
                                                <i class="fa fa-print"></i>
                                                Nota
                                            </button>
                                            <!-- onclick="redirectTo('nota_lunas', <?php //echo $order['id_pemesanan']; ?>)"  -->
                                            <?php if (!isset($order['rating']) OR $order['rating'] == 0) : ?>
                                                <a
                                                    role="button"
                                                    class="btn btn-info btn-sm mb-2"
                                                    href="?content=perbaikan_rating_form&id=<?php echo $order['id_pemesanan']; ?>"
                                                >
                                                    <i class="fa fa-star"></i>
                                                    Beri Rating & Ulasan
                                                </a>
                                            <?php endif ?>
                                            <a
                                                class="btn btn-dark btn-sm mb-2"
                                                href="?content=perbaikan_detail&id=<?php echo $order[0]; ?>"
                                            >
                                                <i class="fa fa-list"></i>
                                                Details
                                            </a>
                                        </form>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Batal -->
    <div class="tab-pane fade" id="menu3" role="tabpanel" aria-labelledby="nav-menu3-tab">
        <div class="description_area">
            <!-- <br> -->
            <!-- <p align="justify">
            </p> -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Total Harga</th>
                            <th>Datang ke Lokasi</th>
                            <th>Status Pemesanan</th>
                            <th>Rating dari Pelanggan</th>
                            <th>Rincian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($order = mysqli_fetch_array($orBatal, MYSQLI_BOTH)) : ?>
                            <?php //if (getSisaPembayaranPemesanan($order['id_pemesanan']) > 0) : ?>
                                <tr>
                                    <td><?php echo $order['no_pemesanan']; ?></td>
                                    <td><?php echo $order['tanggal_pesan']; ?></td>
                                    <td><?php echo format(getTotalHargaPemesanan($order['id_pemesanan']), 'currency'); ?></td>
                                    <td><?php echo setBadges($order['datang_ke_lokasi']); ?></td>
                                    <td><?php echo setBadges($order['status_pemesanan']); ?></td>
                                    <td><div id="ratingTemplate"><?php echo $rating = (isset($order['rating']) AND (!empty($order['rating']) OR $order['rating'] != NULL)) ? showRating($order['rating'], 20) : showRating(0, 20) ; ?></div></td>
                                    <td>
                                        <?php
                                            $sparepart = mysqli_query($koneksi, "SELECT `id_pemesanan_detail` FROM `data_pemesanan_detail` WHERE `id_pemesanan` = '$order[id_pemesanan]' AND `jenis_pengerjaan` = 'sparepart' AND `persetujuan_pelanggan` = 'ya'");
                                            if (getSisaPembayaranPemesanan($order['id_pemesanan']) > 0 AND mysqli_num_rows($sparepart) > 0) : 
                                        ?>
                                            <a
                                                class="btn btn-warning btn-sm mb-2"
                                                href="?content=pembayaran_lunas_form&action=tambah&noPemesanan=<?php echo $order['no_pemesanan']; ?>"
                                                >
                                                <i class="fa fa-upload"></i>
                                                Upload Bukti Pembayaran Lunas
                                            </a>
                                        <?php endif ?>
                                        <?php if (!isset($order['rating']) OR $order['rating'] == 0) : ?>
                                            <a
                                                role="button"
                                                class="btn btn-info btn-sm mb-2"
                                                href="?content=perbaikan_rating_form&id=<?php echo $order['id_pemesanan']; ?>"
                                            >
                                                <i class="fa fa-star"></i>
                                                Beri Rating & Ulasan
                                            </a>
                                        <?php endif ?>
                                        <a
                                            class="btn btn-dark btn-sm mb-2"
                                            href="?content=perbaikan_detail&id=<?php echo $order['id_pemesanan']; ?>"
                                        >
                                            <i class="fa fa-list"></i>
                                            Details
                                        </a>
                                    </td>
                                </tr>
                            <?php //endif ?>
                        <?php endwhile ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
                                    </div>
                                <!-- </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ##### Blog Area End ##### -->