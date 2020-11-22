<?php
	$idKategori = (isset($_GET['id_kategori'])) ? antiInjection($_GET['id_kategori']) : NULL ;
	if ($idKategori == NULL) {
		$_SESSION['message-type'] 		= "danger";
        $_SESSION['message-content'] 	= "Anda belum memilih kategori..!";
        echo "<script>location.replace('?content=pemesanan')</script>";
	}
	$kategori = mysqli_fetch_array(
		getKategoriById($idKategori),
		MYSQLI_BOTH
	);
	$softwareAll = getJenisSoftwareByIdKategori($idKategori);
    $hardwareAll = getJenisHardwareByIdKategori($idKategori);
?>

<!-- Start feature Area -->
<section class="feature-area section-gap" id="service">
	<div class="container">
		<div class="row">

			<div class="col-md-12">
				<h2>Daftar Jenis Layanan <?php echo $kategori['nama_kategori_layanan']; ?></h2>
				<p class="pb-30">
					<!-- Silahkan pilih jenis layanan kami. -->
				</p>

				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>Nama Jenis Layanan</th>
								<th>Harga</th>
							</tr>
						</thead>
						<tbody>
							<?php if (mysqli_num_rows($softwareAll) > 0) : ?>
								<tr>
									<td class="text-left font-weight-bold" colspan="2">
										&nbsp;&nbsp;  Software
									</td>
								</tr>
								<?php foreach ($softwareAll as $data) : ?>
									<tr>
										<td>
											<?php echo $data['nama_jenis_layanan']; ?>
										</td>
										<td>
											<?php echo format($data['harga'], 'currency'); ?>
										</td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>

							<?php if (mysqli_num_rows($hardwareAll) > 0) : ?>
								<tr>
									<td class="text-left font-weight-bold" colspan="2">
										&nbsp;&nbsp;  Hardware
									</td>
								</tr>
								<?php foreach ($hardwareAll as $data) : ?>
									<tr>
										<td>
											<?php echo $data['nama_jenis_layanan']; ?>
										</td>
										<td>
											<?php echo format($data['harga'], 'currency'); ?>
										</td>
									</tr>
								<?php endforeach ?>
							<?php endif ?>
						</tbody>
					</table>
				</div>

				<p class="text-right">
					<a href="?content=pemesanan_form&action=tambah&id_kategori=<?php echo $idKategori; ?>" class="btn btn-primary" role="button">
						Selanjutnya
						<i class="fas fa-arrow-right text-light"></i>
					</a>
				</p>
			</div>
		</div>
	</div>
</section>
<!-- End feature Area -->

<!-- Modal Detail Teknisi -->
<div
	class="modal fade"
	tabindex="-1"
	role="dialog"
	aria-labelledby="modalLabel"
	aria-hidden="true"
	id="modal_detail_teknisi"
>
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Profil Teknisi</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="result">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- End Modal Detail Teknisi -->