<?php
	$action = (isset($_GET['action'])) ? antiInjection($_GET['action']) : NULL ;
	$noPemesanan = (isset($_SESSION['data_pemesanan']['no_pemesanan'])) ? antiInjection($_SESSION['data_pemesanan']['no_pemesanan']) : NULL ;
	// print_r($_SESSION['data_pemesanan']);
	// print '<br>' . $_SESSION['data_pemesanan']['no_pemesanan'];
	if ($action == NULL) {
		$_SESSION['message-type'] 		= "danger";
        $_SESSION['message-content'] 	= "Action belum ditentukan..!";
        // echo "<script>location.replace('?content=pemesanan')</script>";
	}
	if ($noPemesanan == NULL) {
		$_SESSION['message-type'] 		= "danger";
        $_SESSION['message-content'] 	= "No Pemesanan kosong..!";
        // echo "<script>location.replace('?content=pemesanan')</script>";
	}
	$pemesanan = (isset($_SESSION['data_pemesanan'])) ? $_SESSION['data_pemesanan'] : $pemesanan = mysqli_fetch_array(getPemesananByNoPemesanan($noPemesanan), MYSQLI_BOTH); ;
	$kategori = mysqli_fetch_array(
		getKategoriById($pemesanan['id_kategori']),
		MYSQLI_BOTH
	);
	$softwareAll 	= getJenisSoftwareByIdKategori($pemesanan['id_kategori']);
	$hardwareAll 	= getJenisHardwareByIdKategori($pemesanan['id_kategori']);
	$sparepartAll 	= getSparepartAll();

	$syaratKetentuanAll = mysqli_query($koneksi, "SELECT * FROM `data_konfigurasi_syarat_ketentuan`");
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Form Perbaikan</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item">
							<a href="<?php echo $csv::$URL_BASE; ?>/?content=perbaikan">
								<!-- <i class="fa fa-home"></i> -->
								Perbaikan
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Form Perbaikan</li>
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
					<!-- Content -->
					<div class="section-heading">
						<h2>Form Perbaikan untuk Layanan <?php echo $kategori['nama_kategori_layanan']; ?></h2>
						<!-- <p>We are improving our services to serve you better.</p> -->
					</div>
					<form
						class="form-horizontal"
						<?php if ($action == 'tambah') : ?>
							action="?content=perbaikan_secondary_proses&proses=add"
						<?php elseif ($action == 'ubah') : ?>
							action="?content=perbaikan_secondary_proses&proses=edit"
						<?php endif ?>
						method="POST"
						enctype="multipart/form-data"
					>
						<input type="hidden" name="noPemesanan" value="<?php echo $noPemesanan; ?>">
						<div class="row">
							<div class="col-md-7">
								<script src="assets/lib/editor/ckeditor/ckeditor.js"></script>
								<div class="form-group row">
									<label class="col-md-5 col-form-label" for="keluhan">Keluhan</label>
									<div class="col-md-12">
										<textarea class="form-control" name="keluhan" id="keluhan" ></textarea>
									</div>
								</div>
								<script>CKEDITOR.replace( 'keluhan' );</script>

								<div class="form-group row">
									<label class="col-md-5 col-form-label" for="keluhan">Foto Kerusakan (Opsional)</label>
									<div class="col-md-12">
										<input type="file" class="form-control" name="foto_kerusakan[]" id="foto_kerusakan" multiple>
									</div>
								</div>

								<div class="form-group form-check">
									<input type="checkbox" name="syarat_ketentuan" class="form-check-input syarat_ketentuan" id="syarat_ketentuan" required>
									<label class="form-check-label" for="syarat_ketentuan">Saya menyetujui Syarat & Ketentuan yang berlaku.</label>
								</div>
							</div>
							<div class="col-md-5">
								<div class="form-group row">
									<label class="col-md-5 col-form-label" for="daftarJenisLayanan">
										Jenis Layanan :
									</label>
									<div class="col-md-12">
										<div class="accordion" id="daftarJenisLayanan">
											<div class="card">
												<div class="card-header" id="headingSoftware">
													<h5 class="mb-0">
														<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseSoftware" aria-expanded="true" aria-controls="collapseSoftware">
															Software
														</button>
													</h5>
												</div>

												<div id="collapseSoftware" class="collapse" aria-labelledby="headingSoftware" data-parent="#daftarJenisLayanan">
													<div class="card-body">
														<ul>
															<?php if (mysqli_num_rows($softwareAll) > 0) : ?>
																<?php foreach ($softwareAll as $data) : ?>
																	<li>
																		<label>
																			<input
																				type="checkbox"
																				name="softwareId[]"
																				value="<?php echo $data['id_layanan_jenis']; ?>"
																				id="software-<?php echo $data['id_layanan_jenis']; ?>"
																			>
																			<i class="bg-dark"></i>
																			<span>
																				<?php echo "<b>" . $data['nama_jenis_layanan'] . "</b>" . " [<b>" . format($data['harga'], "currency") . "</b>]"; ?>
																			</span>
																		</label>
																	</li>
																<?php endforeach ?>
															<?php endif ?>
														</ul>
													</div>
												</div>
											</div>
											<div class="card">
												<div class="card-header" id="headingHardware">
													<h5 class="mb-0">
													<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseHardware" aria-expanded="false" aria-controls="collapseHardware">
														Hardware
													</button>
													</h5>
												</div>
												<div id="collapseHardware" class="collapse" aria-labelledby="headingHardware" data-parent="#daftarJenisLayanan">
													<div class="card-body">
														<ul>
															<?php if (mysqli_num_rows($hardwareAll) > 0) : ?>
																<?php foreach ($hardwareAll as $data) : ?>
																	<li>
																		<label>
																			<input
																				type="checkbox"
																				name="hardwareId[]"
																				value="<?php echo $data['id_layanan_jenis']; ?>"
																				id="hardware-<?php echo $data['id_layanan_jenis']; ?>"
																			>
																			<i class="bg-dark"></i>
																			<span>
																				<?php echo "<b>" . $data['nama_jenis_layanan'] . "</b>" . " [<b>" . format($data['harga'], "currency") . "</b>]"; ?>
																			</span>
																		</label>
																	</li>
																<?php endforeach ?>
															<?php endif ?>
														</ul>
													</div>
												</div>
											</div>
											<div class="card">
												<div class="card-header" id="headingSparepart">
													<h5 class="mb-0">
													<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseSparepart" aria-expanded="false" aria-controls="collapseSparepart">
														Sparepart
													</button>
													</h5>
												</div>
												<div id="collapseSparepart" class="collapse" aria-labelledby="headingSparepart" data-parent="#daftarJenisLayanan">
													<div class="card-body">
														<ul>
															<?php if (mysqli_num_rows($sparepartAll) > 0) : ?>
																<?php foreach ($sparepartAll as $data) : ?>
																	<li>
																		<label>
																			<input
																				type="checkbox"
																				name="sparepartId[]"
																				value="<?php echo $data['id_sparepart']; ?>"
																				id="sparepart-<?php echo $data['id_sparepart']; ?>"
																			>
																			<i class="bg-dark"></i>
																			<span>
																				<?php
																					echo "<b>" . $data['nama_sparepart'] . "</b>" . " [<b>" . format($data['harga'], "currency") . "</b>]";
																				?>
																			</span>
																		</label>
																	</li>
																<?php endforeach ?>
															<?php endif ?>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-12 text-right">
								<button type="submit" class="btn btn-primary" name="simpan">
									Lanjutkan
									<i class="fa fa-arrow-right"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ##### Checkout Area End ##### -->

<!-- Modal Modal Syarat & Ketentuan -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" id="modal_syarat_ketentuan">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Syarat & Ketentuan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="result">
				<p>
					<?php $i = 1; ?>
					<?php foreach ($syaratKetentuanAll as $data) : ?>
						<?= $i . ". " . $data['deskripsi_syarat_ketentuan'] . "<br>" ?>
						<?php $i++; ?>
					<?php endforeach ?>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
			</div>
		</div>
	</div>
</div>
<!-- End Modal Syarat & Ketentuan -->