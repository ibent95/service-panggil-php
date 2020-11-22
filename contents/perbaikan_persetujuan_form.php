<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($id == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
        echo "<script>location.replace('?content=profil')</script>";
    }
    // if ($action == 'persetujuan') {
        $pemesanan = mysqli_fetch_array(
            getPemesananJoinById($id), 
            MYSQLI_BOTH
        );
        // $pemesananDetailAll = getDetailPemesananByIdPemesanan($pemesanan['id']);
        $diagnosisSoftware  = getDetailPemesananByIdPemesanan($id, 'software', '', 'ya', 'ASC');
        $diagnosisHardware  = getDetailPemesananByIdPemesanan($id, 'hardware', '', 'ya', 'ASC');
        $diagnosisSparepart = getDetailPemesananByIdPemesanan($id, 'sparepart', '', 'ya', 'ASC');
        $biayaTambahan      = getDetailPemesananByIdPemesanan($id, 'biaya_tambahan', '', 'ya', 'ASC');
        // $biayaTambahan      = getBiayaTambahanByIdPemesanan($id);
        $riwayatPembayaran  = getBuktiPembayaranByIdPemesanan($id);
        $sisaPembayaran     = 0;
        foreach ($diagnosisSoftware as $data) {
            $sisaPembayaran += $data['harga'];
        }
        foreach ($diagnosisHardware as $data) {
            $sisaPembayaran += $data['harga'];
        }
        foreach ($diagnosisSparepart as $data) {
            $sisaPembayaran += $data['harga_sparepart'];
        }
        foreach ($biayaTambahan as $data) {
            $sisaPembayaran += $data['harga_biaya_tambahan'];
        }
        foreach ($riwayatPembayaran as $data) {
            $sisaPembayaran -= $data['jumlah'];
        }
        $pemesanan['status_pembayaran'] = ($sisaPembayaran == 0) ? "Lunas" : "Belum Lunas" ;

        if (!empty($pemesanan['longlat'])) {
            $longlat = explode(",", $pemesanan['longlat']);
        } else {
            $longlat[0] = 0;
            $longlat[1] = 0;
        }
    // }
    $no         = 1;
    $totalHarga = 0;
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Form Pemesanan</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item">
							<a href="<?php echo $csv::$URL_BASE; ?>/?content=profil">
								<!-- <i class="fa fa-home"></i> -->
								Profil
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Detail Pemesanan</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcrumb Area End ##### -->

<!-- ##### Checkout Area Start ##### -->
<div class="checkout_area mb-100">
	<div class="container">
		<?php getNotifikasi(); ?>
		<div class="row justify-content-between">
			<div class="col-md-12">
                <div class=" clearfix">
                    <h2>Persetujuan Perbaikan - <?php echo $pemesanan['no_pemesanan']; ?></h2>
                    <p class="pb-30">
                        <!-- Silahkan pilih jenis layanan kami. -->
                    </p>
                    <div class="text-dark">
                        <button class="btn btn-default text-dark" onclick="window.location.replace('?content=profil');" role="button" data-toggle="button" aria-pressed="false" autocomplete="off">
                            <i class="fa fa-arrow-left"></i>
                            Kembali
                        </button>
                        <div class="card-body">
                            <div class="text-dark">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="table" class="">Data Pengerjaan</label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Layanan</th>
                                                        <th>Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php if ((mysqli_num_rows($diagnosisSoftware) > 0) OR (mysqli_num_rows($diagnosisHardware) > 0) OR (mysqli_num_rows($diagnosisSparepart) > 0) OR (mysqli_num_rows($biayaTambahan) > 0) OR (mysqli_num_rows($riwayatPembayaran) > 0)): ?>
                                                        <!-- Software -->
                                                        <?php if (mysqli_num_rows($diagnosisSoftware) > 0) : ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold" colspan="2">
                                                                    &nbsp;&nbsp; Software
                                                                </td>
                                                            </tr>
                                                            <?php foreach ($diagnosisSoftware as $data): ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php 
                                                                            echo $no . ". " . $data['nama_jenis_layanan']; 
                                                                            $no++;
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php 
                                                                            echo format($data['harga'], 'currency'); 
                                                                            $totalHarga = $totalHarga + $data['harga'];
                                                                        ?>

                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        <?php endif ?>

                                                        <!-- Hardware -->
                                                        <?php if (mysqli_num_rows($diagnosisHardware) > 0): ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold" colspan="2">
                                                                    &nbsp;&nbsp;  Hardware
                                                                </td>
                                                            </tr>
                                                            <?php foreach ($diagnosisHardware as $data): ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php 
                                                                            echo $no . ". " . $data['nama_jenis_layanan'];  
                                                                            $no++;
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php 
                                                                            echo format($data['harga'], 'currency'); 
                                                                            $totalHarga = $totalHarga + $data['harga'];
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        <?php endif ?>

                                                        <!-- Sparepart -->
                                                        <?php if (mysqli_num_rows($diagnosisSparepart) > 0): ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold" colspan="2">
                                                                    &nbsp;&nbsp;  Sparepart
                                                                </td>
                                                            </tr>
                                                            <?php foreach ($diagnosisSparepart as $data): ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php 
                                                                            echo $no . ". " . $data['nama_sparepart']; 
                                                                            $no++;
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php 
                                                                            echo format($data['harga'], 'currency'); 
                                                                            $totalHarga = $totalHarga + $data['harga'];
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        <?php endif ?>

                                                        <!-- Biaya Tambahan -->
                                                        <?php if (mysqli_num_rows($biayaTambahan) > 0) : ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold" colspan="2">
                                                                    &nbsp;&nbsp;  Biaya Tambahan
                                                                </td>
                                                            </tr>
                                                            <?php foreach ($biayaTambahan as $data): ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php 
                                                                            echo $no . ". " . $data['keterangan']; 
                                                                            $no++;
                                                                        ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php 
                                                                            echo format($data['harga_biaya_tambahan'], 'currency'); 
                                                                            $totalHarga = $totalHarga + $data['harga_biaya_tambahan'];
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                        
                                                        <!-- Riwayat Pembayaran -->
                                                        <?php if (mysqli_num_rows($riwayatPembayaran) > 0) : ?>
                                                            <tr style="font-weight: bold;">
                                                                <td colspan="3" style="text-align: left;">&emsp;Riwayat Pembayaran</td>
                                                            </tr>
                                                            <?php foreach ($riwayatPembayaran as $pembayaran): ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php 
                                                                            echo $no . ". " 
                                                                        ?>
                                                                        Pembayaran <?php echo $pembayaran['info_pembayaran']; ?> tanggal <?php echo format($pembayaran['tgl_pembayaran'], "date"); ?>

                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php 
                                                                            echo format($pembayaran['jumlah'], "currency"); 
                                                                            $totalHarga = $totalHarga - $pembayaran['jumlah'];
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td class="text-center" colspan="2">
                                                                Belum ada data pengerjaan..!
                                                            </td>
                                                        </tr>
                                                    <?php endif ?>

                                                    <tr>
                                                        <td class="text-right font-weight-bold">
                                                            <?php if (mysqli_num_rows($riwayatPembayaran) == 0) : ?>
                                                                Total Harga
                                                            <?php else : ?>
                                                                Sisa Pembayaran
                                                            <?php endif ?>
                                                        </td>
                                                        <td class="font-weight-bold text-right">
                                                            <?php echo format($totalHarga, 'currency'); ?>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Daftar Pengerjaan yang Menunggu Persetujuan -->
                                <?php 
                                    $no = 1;
                                    $diagnosisSoftwareBelum	        = getDetailPemesananByIdPemesanan($id, 'software', '', 'not_ya', 'ASC');
                                    $diagnosisHardwareBelum	        = getDetailPemesananByIdPemesanan($id, 'hardware', '', 'not_ya', 'ASC');
                                    $diagnosisSparepartBelum	    = getDetailPemesananByIdPemesanan($id, 'sparepart', '', 'not_ya', 'ASC');
                                    $diagnosisBiayaTambahanBelum	= getDetailPemesananByIdPemesanan($id, 'biaya_tambahan', '', 'not_ya', 'ASC');
                                ?>
                                <?php if ((mysqli_num_rows($diagnosisSoftwareBelum) > 0) OR (mysqli_num_rows($diagnosisHardwareBelum) > 0) OR (mysqli_num_rows($diagnosisSparepartBelum) > 0) OR (mysqli_num_rows($diagnosisBiayaTambahanBelum) > 0)) : ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="table" class="">Persetujuan</label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Layanan</th>
                                                            <th>Harga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (mysqli_num_rows($diagnosisSoftwareBelum) > 0) : ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold" colspan="2">
                                                                    &nbsp;&nbsp; Software
                                                                </td>
                                                            </tr>
                                                            <?php foreach ($diagnosisSoftwareBelum as $data) : ?>
                                                                <?php if ($data['persetujuan_pelanggan'] != 'tidak') : ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php 
                                                                                echo $no . ". " . $data['nama_jenis_layanan']; 
                                                                                $no++;
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php 
                                                                                echo format($data['harga'], 'currency'); 
                                                                                $totalHarga = $totalHarga + $data['harga'];
                                                                            ?>

                                                                        </td>
                                                                    </tr>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                        <?php if (mysqli_num_rows($diagnosisHardwareBelum) > 0) : ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold" colspan="2">
                                                                    &nbsp;&nbsp;  Hardware
                                                                </td>
                                                            </tr>
                                                            <?php foreach ($diagnosisHardwareBelum as $data): ?>
                                                                <?php if ($data['persetujuan_pelanggan'] != 'tidak') : ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php 
                                                                                echo $no . ". " . $data['nama_jenis_layanan'];  
                                                                                $no++;
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php 
                                                                                echo format($data['harga'], 'currency'); 
                                                                                $totalHarga = $totalHarga + $data['harga'];
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                        <?php if (mysqli_num_rows($diagnosisSparepartBelum) > 0) : ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold" colspan="2">
                                                                    &nbsp;&nbsp;  Sparepart
                                                                </td>
                                                            </tr>
                                                            <?php foreach ($diagnosisSparepartBelum as $data): ?>
                                                                <?php if ($data['persetujuan_pelanggan'] != 'tidak') : ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php 
                                                                                echo $no . ". " . $data['nama_sparepart']; 
                                                                                $no++;
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php 
                                                                                echo format($data['harga'], 'currency'); 
                                                                                $totalHarga = $totalHarga + $data['harga'];
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        <?php endif ?>
                                                        <?php if (mysqli_num_rows($diagnosisBiayaTambahanBelum) > 0) : ?>
                                                            <tr>
                                                                <td class="text-left font-weight-bold" colspan="2">
                                                                    &nbsp;&nbsp;  Biaya Tambahan
                                                                </td>
                                                            </tr>
                                                            <?php foreach ($diagnosisBiayaTambahanBelum as $data): ?>
                                                                <?php if ($data['persetujuan_pelanggan'] != 'tidak') : ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php 
                                                                                echo $no . ". " . $data['keterangan']; 
                                                                                $no++;
                                                                            ?>
                                                                        </td>
                                                                        <td class="text-right">
                                                                            <?php 
                                                                                echo format($data['harga_biaya_tambahan'], 'currency'); 
                                                                                $totalHarga = $totalHarga + $data['harga_biaya_tambahan'];
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endif ?>
                                                            <?php endforeach ?>
                                                        <?php endif ?>

                                                        <tr>
                                                            <td class="text-right font-weight-bold">
                                                                <?php if (mysqli_num_rows($riwayatPembayaran) == 0) : ?>
                                                                    Total Harga
                                                                <?php else : ?>
                                                                    Sisa Pembayaran
                                                                <?php endif ?>
                                                            </td>
                                                            <td class="font-weight-bold text-right">
                                                                <?php echo format($totalHarga, 'currency'); ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                            </div>
                            <p class="text-right">
                                <?php //if ($pemesanan['pengerjaan_ke'] < 2) : ?>
                                    <!-- <a id="" class="btn btn-danger" href="?content=pemesanan_persetujuan_proses&proses=batal&id=<?php //echo $pemesanan[0]; ?>" role="button">
                                        <i class="fa fa-times"></i>
                                        Batal
                                    </a> -->
                                <?php //else : ?>
                                    <a id="" class="btn btn-danger" href="?content=perbaikan_persetujuan_proses&proses=tidak_setuju&id=<?php  echo $pemesanan[0]; ?>" role="button">
                                        <i class="fa fa-thumbs-down"></i>
                                        Tidak Setuju
                                    </a>
                                <?php // endif ?>
                                <a id="" class="btn btn-success" href="?content=perbaikan_persetujuan_proses&proses=setuju&id=<?php echo $pemesanan[0]; ?>" role="button">
                                    Setuju
                                    <i class="fa fa-thumbs-up"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                    <!-- End Card Body -->
                </div>
            </div>
		</div>
	</div>
</div>
<!-- ##### Checkout Area End ##### -->

<script
	async
	defer
	src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'
>
</script>