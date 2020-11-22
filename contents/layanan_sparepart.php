<?php
	$sparepartAll = getSparepartAll('ASC');
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Layanan Sparepart</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Layanan Sparepart</li>
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
				//Section Heading
				<div class="section-heading text-center">
					<h2>Layanan Perbaikan - </h2>
					<p>Silahkan pilih jenis layanan kami.</p>
				</div>
			</div>
			<div class="row"> -->
				<div class="col-lg-12 col-md vol-wrap mb-30">
					<div class="card">
						<!-- <div class="card-header text-center"></div> -->
						<!-- <img class="card-img-top" src="<?php //echo searchFile($kategoriLayanan["gambar"], "img", "short"); ?>" alt="<?php //echo $kategoriLayanan['nama_kategori_layanan']; ?>" style="height: 400px;"> -->
						<div class="card-body">
							<h3 class="card-title">Sparepart</h3>
							<p class="pb-8 text-justify" style="ul{list-style:circle;}">
								<!-- <?php //echo htmlspecialchars_decode($kategoriLayanan['deskripsi']); ?> -->
								Layanan Sparepart ini dimaksudkan apabila anda ingin sparepart untuk perangkat anda di layanan kami. Untuk bisa memesan sparepart, anda diharuskan untuk memesan perbaikan kemudian pada form pengisian pemesanan anda bisa memilih sparepart yang anda inginkan.
							</p>
							<div class="table-responsive">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th>No.</th>
											<th>Nama Sparepart</th>
											<th class="text-right">Harga</th>
										</tr>
									</thead>
									<tbody id="result">
										<?php $i = 1; ?>
										<?php foreach ($sparepartAll as $data) : ?>
												<tr>
													<td><?= $i ?></td>
													<td><?= $data['nama_sparepart'] ?></td>
													<td class="text-right"><?= format($data['harga'], 'currency') ?></td>
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
			</div>
		</div>
	</div>
</section>
<!-- ##### Portfolio Area End ##### -->