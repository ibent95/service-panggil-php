<?php
	$kategoriLayananAll = getKategoriAll('ASC');
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Perbaikan</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Perbaikan</li>
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
			<div class="col-12">
				<!-- Section Heading -->
				<div class="section-heading text-center">
					<h2>Perbaikan</h2>
					<p>Silahkan pilih jenis layanan kami.</p>
				</div>
			</div>
			<div class="row">
				<?php foreach ($kategoriLayananAll as $data) : ?>
					<div class="col-lg-4 col-md vol-wrap mb-30">
						<div class="card">
							<!-- <div class="card-header text-center">
							</div> -->
							<?php
								if ($data['gambar'] == NULL) {
									$data['gambar'] = "1";
								}
							?>
							<img class="card-img-top" src="<?php echo searchFile($data["gambar"], "img", "short"); ?>" alt="<?php echo $data['nama_kategori_layanan']; ?>">
							<div class="card-body">
								<h5 class="card-title"><?php echo $data['nama_kategori_layanan']; ?></h5>
								<p class="pb-8 text-justify" style="ul{list-style:circle;}">
									<?php echo htmlspecialchars_decode($data['deskripsi']); ?>
								</p>
								<div class="text-center">
									<button
										class="btn btn-primary text-center"
										data-toggle="modal"
										data-target="#modal_daftar_jenis_layanan"
										data-id="<?php echo $data['id_layanan_kategori']; ?>"
										id="id_kategori_layanan"
										style="width: 100%;"
									>
										Lihat & Pesan
									</button>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach ?>
			</div>
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
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div> -->
		</div>
	</div>
</div>
<!-- End Modal Detail Teknisi -->