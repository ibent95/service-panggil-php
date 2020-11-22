<?php
	cekLogin('pelanggan');
	$action = (isset($_GET['action'])) ? antiInjection($_GET['action']) : NULL ;
	$noPemesanan = (isset($_GET['noPemesanan'])) ? antiInjection($_GET['noPemesanan']) : NULL ;

	$idPelanggan = $_SESSION['id'];

	$pemesanan = mysqli_fetch_array(
		getPemesananByNoPemesanan(
			$noPemesanan,
			MYSQLI_BOTH
		)
	);
	$totalHarga 		= (int) getTotalHargaPemesanan($pemesanan['id_pemesanan']);
	$namaKategori = mysqli_fetch_array(
		getKategoriById(
			$pemesanan['id_kategori'],
			MYSQLI_BOTH
		)
	)['nama_kategori_layanan'];

	$cekPembayaranPanjar = getBuktiPembayaranByIdPemesanan($pemesanan['id_pemesanan'], 'panjar');

	// if (mysqli_num_rows($cekPembayaranPanjar) >= 1) {
	// 	saveNotifikasi(array('danger', 'Bukti pembayaran telah dikirim, silahkan tunggu informasi dari pihak rental..!'));
	// 	echo "<script>window.location.href='?content=profil'</script>";
	// }

	// $pembayaranPanjar = $pemesanan['total_harga'] / 2;
	$pembayaranPanjar = getKonfigurasiUmum('biaya_administrasi', 'single')['nilai_konfigurasi'];

	$noRekening 	= mysqli_fetch_array(
		getKonfigurasiUmum(
			"no_rek_transaksi",
			"multiple"
		),
		MYSQLI_BOTH
	);
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
						<li class="breadcrumb-item active" aria-current="page">Form Konfirmasi Pembayaran Panjar</li>
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
		<?= getNotifikasi() ?>
		<div class="row justify-content-between">
			<div class="col-md-12">
				<div class=" clearfix">
					<!-- Content -->
					<div class="section-heading">
						<h2>Konfirmasi Pembayaran Panjar [<?php echo $pemesanan['no_pemesanan']; ?>]</h2>
						<!-- <p>We are improving our services to serve you better.</p> -->
					</div>

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

							<form
								class="form-horizontal"
								<?php if ($action == 'tambah') : ?>
									action="?content=pembayaran_panjar_proses&proses=add"
								<?php elseif ($action == 'ubah') : ?>
									action="?content=pembayaran_panjar_proses&proses=edit"
								<?php endif ?>
								method="POST"
								role="form"
								id="konfirmasi-form"
								enctype="multipart/form-data"
							>

								<input type="hidden" name="id" value="<?php echo $pemesanan['id_pemesanan']; ?>" />

								<div class="form-group row">
									<label class="col-md-3 control-label">Harga Pembayaran Dimuka</label>
									<div class="col-md-9">
										<label class="control-label">
											: <?php echo format($pembayaranPanjar, 'currency'); ?>
										</label>
										<input type="hidden" name="jumlah" id="jumlah" value="<?php echo $pembayaranPanjar; ?>">
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

								<div class="form-group row">
									<div class="offset-md-3 col-md-9">
										<button class="btn btn-success" type="submit" name="checkout">Upload</button>
										<button
											class="
												btn
												btn-default
												<?php if (dateDifference($pemesanan['tanggal_kerja'], date('Y-m-d')) < 1): ?>
													btn-orange
												<?php endif ?>
											"
											type="button"
											onclick="
												<?php if (dateDifference($pemesanan['tanggal_kerja'], date('Y-m-d')) < 1): ?>
													showAlertPembayaran();
												<?php else: ?>
													location.href='?content=profil';
												<?php endif ?>
											"
										>
											Keluar
										</button>
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