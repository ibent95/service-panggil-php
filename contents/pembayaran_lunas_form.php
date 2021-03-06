<?php
	cekLogin('pelanggan');
	$action 		= (isset($_GET['action'])) ? antiInjection($_GET['action']) : null;
	$noPemesanan 	= (isset($_GET['noPemesanan'])) ? antiInjection($_GET['noPemesanan']) : null;

	$idPelanggan 	= $_SESSION['id'];

	$pemesanan 		= mysqli_fetch_array(getPemesananByNoPemesanan($noPemesanan), MYSQLI_BOTH);
	$totalHarga 	= (int) getTotalHargaPemesanan($pemesanan['id_pemesanan']);
	$namaKategori 	= mysqli_fetch_array(getKategoriById($pemesanan['id_kategori'], MYSQLI_BOTH))['nama_kategori_layanan'];


	$pembayaranPanjar 		= 0;
	$cekPembayaranPanjar 	= getBuktiPembayaranByIdPemesanan($pemesanan['id_pemesanan'], 'panjar');
	if (mysqli_num_rows($cekPembayaranPanjar) != 0) {
		foreach ($cekPembayaranPanjar as $data) {
			if ($data['konfirmasi_admin'] == 'ya') {
				$pembayaranPanjar 	+= (int) $data['jumlah'];
			}
		}
	}

	$pembayaranLunas = 0;
	$cekPembayaranLunas 	= getBuktiPembayaranByIdPemesanan($pemesanan['id_pemesanan'], 'lunas');
	if (mysqli_num_rows($cekPembayaranLunas) != 0) {
		foreach ($cekPembayaranLunas as $data) {
			if ($data['konfirmasi_admin'] == 'ya') {
				$pembayaranLunas 	+= (int) $data['jumlah'];
			}
		}
	}

	$sisaPembayaran 		= ($pemesanan['status_pemesanan'] != 'batal') ? $totalHarga - ($pembayaranPanjar + $pembayaranLunas) : $totalHarga;
	if ($sisaPembayaran == 0 OR $sisaPembayaran == "0") {
		saveNotifikasi(
			array(
				array(
					'danger',
					'Bukti pembayaran telah dikirim, silahkan tunggu informasi dari pihak admin..!'
				)
			)
		);
		echo "<script>window.location.href='?content=profil'</script>";
	}

	$noRekening = mysqli_fetch_array(getKonfigurasiUmum("no_rek_transaksi", "multiple"), MYSQLI_BOTH);
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
							<a href="<?php echo $csv::$URL_BASE; ?>/?content=pemesanan">
								<!-- <i class="fa fa-home"></i> -->
								Pemesanan
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Form Konfirmasi Pembayaran Lunas</li>
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
		<?php if (dateDifference($pemesanan['tanggal_kerja'], date('Y-m-d')) < 1) : ?>
			<div class="alert alert-danger alert-dismissable">
				<button class='close' type='button' data-dismiss='alert'>&times</button>
				<div class="container">
					Segera lakukan konfirmasi pembayaran panjar sebelum anda keluar dari form ini. Apabila pemesanan tidak dikonfirmasi dan anda telah keluar dari form ini, maka pemesanan akan dibatalkan secara otomatis..!
				</div>
			</div>
		<?php endif ?>
		<div class="row justify-content-between">
			<div class="col-md-12">
				<div class=" clearfix">

					<h2>Konfirmasi Pembayaran Lunas [<?php echo $pemesanan['no_pemesanan']; ?>]</h2>
					<p class="pb-10">
						<!-- Silahkan pilih jenis layanan kami. -->
					</p>

					<div class="row">
						<div class="col-md-9">
							<div class="form-horizontal">
								<div class="form-group row">
									<label class="col-md-3 control-label">No. Pemesanan</label>
									<div class="col-md-9">
										<label class="control-label">
											: <?php echo $pemesanan['no_pemesanan']; ?>
										</label>
										<input type="hidden" name="no_pemesanan" value="<?php echo $pemesanan['no_pemesanan']; ?>">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-3 control-label">Nama Pelanggan</label>
									<div class="col-md-9">
										<label class="control-label">
											: <?php echo $_SESSION['nama_lengkap']; ?>
										</label>
										<input type="hidden" name="id_pelanggan" value="<?php echo $_SESSION['id']; ?>">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-3 control-label">Nama Layanan</label>
									<div class="col-md-9">
										<label class="control-label">
											: <?php echo $namaKategori; ?>
										</label>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-3 control-label">Total Harga</label>
									<div class="col-md-9">
										<label class="control-label">
											: <?php echo format($totalHarga, 'currency'); ?>
										</label>
										<input type="hidden" id="total_harga" value="<?php echo $totalHarga; ?>">
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label class="col-md-3 control-label">Harga Pembayaran Dimuka</label>
								<div class="col-md-9">
									<label class="control-label">
										: <?php echo format($pembayaranPanjar, 'currency'); ?>
									</label>
									<input type="hidden" name="jumlah" id="jumlah" value="<?php echo $dp; ?>">
								</div>
							</div>

							<form
								class="form-horizontal"
								<?php if ($action == 'tambah') : ?>
									action="?content=pembayaran_lunas_proses&proses=add"
								<?php elseif ($action == 'ubah') : ?>
									action="?content=pembayaran_lunas_proses&proses=edit"
								<?php endif ?>
								method="POST"
								role="form"
								id="konfirmasi-form"
								enctype="multipart/form-data"
							>

								<input type="hidden" name="id" value="<?php echo $pemesanan['id_pemesanan']; ?>" />

								<div class="form-group row">
									<label class="col-md-3 control-label">Sisa Pembayaran</label>
									<div class="col-md-9">
										<label class="control-label">
											: <?php echo format($sisaPembayaran, 'currency'); ?>
										</label>
										<input type="hidden" name="jumlah" id="jumlah" value="<?php echo $sisaPembayaran; ?>">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-md-3 control-label">Bukti Pembayaran</label>
									<div class="col-md-9">
										<input
											type="file"
											class="form-control"
											name="bukti_pembayaran"
											id="bukti_pembayaran"
											required
										/>
									</div>
								</div>

								<div class="form-group">
									<div class="offset-md-3 col-md-9">
										<button class="btn btn-success" type="submit" name="checkout">Upload</button>
										<button class="btn btn-default" type="button" onclick="location.href='?content=profil'">Keluar</button>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-3">
							<div class="card text-white bg-warning" style="width: 18rem;">
								<div class="card-header">
									Info Transfer
								</div>
								<div class="card-body text-dark bg-light">
									<div class="form">
										<div class="form-group">
											<label class="col-md-12 col-form-label">Info Bank : </label>
											<div class="col-md-12">
												<?php echo $noRekening['keterangan']; ?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-12 col-form-label">No. Rek : </label>
											<div class="col-md-12">
												<?php echo $noRekening['nilai_konfigurasi']; ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ##### Checkout Area End ##### -->