<?php
	$id = (isset($_GET['id']) AND !empty($_GET['id'])) ? $_GET['id'] : NULL ;
	$kategoriLayanan = mysqli_fetch_array(getKategoriById($id), MYSQLI_BOTH);
	$jenisLayananSoftwareAll = getJenisSoftwareByIdKategori($id, 'ASC');
	$jenisLayananHardwareAll = getJenisHardwareByIdKategori($id, 'ASC');
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->`
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Layanan Perbaikan - <?php echo $kategoriLayanan['nama_kategori_layanan']; ?></h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item" aria-current="page">Layanan Perbaikan</li>
						<li class="breadcrumb-item active" aria-current="page"><?php echo $kategoriLayanan['nama_kategori_layanan']; ?></li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcrumb Area End ##### -->

<!-- ##### Portfolio Area Start ##### -->
<section class="alazea-portfolio-area portfolio-page section-padding-0-100">
	<div class="container">
		<?php getNotifikasi(); ?>
		<div class="row">
			<!-- <div class="col-12">
				Section Heading
				<div class="section-heading text-center">
					<h2>Layanan Perbaikan - </h2>
					<p>Silahkan pilih jenis layanan kami.</p>
				</div>
			</div>
			<div class="row"> -->
				<div class="col-lg-12 col-md-12 vol-wrap mb-30">
					<div class="card">
						<!-- <div class="card-header text-center">
						</div> -->
						<?php if ($kategoriLayanan['gambar'] == NULL) { $kategoriLayanan['gambar'] = "1"; } ?>
						<!-- <img class="card-img-top" src="<?php //echo searchFile($kategoriLayanan["gambar"], "img", "short"); ?>" alt="<?php //echo $kategoriLayanan['nama_kategori_layanan']; ?>" style="height: 250px; width: 100%;"> -->
						<div class="card-body">
							<h3 class="card-title"><?php echo $kategoriLayanan['nama_kategori_layanan']; ?></h3>
							<p class="pb-8 text-justify" style="ul { list-style: circle; }">
								<?php echo htmlspecialchars_decode($kategoriLayanan['deskripsi']); ?>
							</p>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Nama Jenis Layanan</th>
											<th>Deskripsi</th>
											<th>Harga</th>
										</tr>
									</thead>
									<tbody id="result">
										<tr>
											<td class='text-dark font-weight-bold' colspan='4'>Software</td>
										</tr>
										<?php $i = 1; ?>
										<?php foreach ($jenisLayananSoftwareAll as $data) : ?>
												<tr>
													<td><?= $i ?></td>
													<td><?= $data['nama_jenis_layanan'] ?></td>
													<td><?= $data['deskripsi_jenis_layanan'] ?></td>
													<td><?= format($data['harga'], 'currency') ?></td>
												</tr>
											<?php $i++; ?>
										<?php endforeach ?>
										<tr>
											<td class='text-dark font-weight-bold' colspan='4'>Hardware</td>
										</tr>
										<?php $i = 1; ?>
										<?php foreach ($jenisLayananHardwareAll as $data) : ?>
												<tr>
													<td><?= $i ?></td>
													<td><?= $data['nama_jenis_layanan'] ?></td>
													<td><?= $data['deskripsi_jenis_layanan'] ?></td>
													<td><?= format($data['harga'], 'currency'); ?></td>
												</tr>
											<?php $i++; ?>
										<?php endforeach ?>
									</tbody>
								</table>
							</div>
							<div class="text-right">
								<a class="btn btn-primary" href="?content=perbaikan" id="pesan">
									<i class="fa fa-paper-plane"></i>
									Pesan
								</a>
							</div>
						</div>
					</div>
				</div>
			<!-- </div> -->
		</div>
	</div>
</section>
<!-- ##### Portfolio Area End ##### -->

<!-- Modal Daftar Jenis Layanan -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" id="modal_daftar_jenis_layanan">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Daftar Jenis Layanan <?php //echo $_SESSION['id']; ?></h5>
				<button type="button" class="close" kategoriLayanan-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="result">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover">
						<thead>
							<tr>
								<th>No.</th>
								<th>Nama Jenis Layanan</th>
								<th>Harga</th>
							</tr>
						</thead>
						<tbody id="result">
							<tr>
								<td class="text-center" colspan="3" style="background: rgba( 255, 255, 255, .8) 50% 50% no-repeat">
									<img src="assets/frontend/img/ajax-loader.gif" alt=""> Mohon tunggu..!
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<p class="text-right">
					<a class="btn btn-primary btn-lg btn-blok" href="" id="button-order-layanan">
						<i class="fa fa-paper-plane"></i>
						Pesan
					</a>
				</p>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-secondary" kategoriLayanan-dismiss="modal">Close</button>
			</div> -->
		</div>
	</div>
</div>
<!-- End Modal Detail Teknisi -->