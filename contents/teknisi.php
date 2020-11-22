<?php
	$teknisiAll = getTeknisiAll('ASC');
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Teknisi</h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item active" aria-current="page">Teknisi</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>
</div>
<!-- ##### Breadcrumb Area End ##### -->
<!-- ##### Team Area Start ##### -->
<section class="team-area section-padding-0-100">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!-- Section Heading -->
				<div class="section-heading text-center">
					<h2>Teknisi Kami</h2>
					<p>Tim teknisi yang profesional dibidangnya.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<?php foreach ($teknisiAll as $data) : ?>
				<!-- Single Team Member Area -->
				<div class="col-12 col-sm-6 col-lg-3">
					<div class="single-team-member text-center mb-100">
						<!-- Team Member Thumb -->
						<div class="team-member-thumb">
							<a
								class="btn btn-link"
								data-toggle="modal"
								data-target="#modal_detail_teknisi"
								id="detail_teknisi"
								data-id="<?php echo $data['id_teknisi']; ?>"
								data-content="<?php echo $content; ?>"
								aria-hidden="true"
							>
								<img src="<?php echo searchFile($data["url_foto"], "img", "short"); ?>" alt="<?php echo $data['nama_lengkap']; ?>">
							</a>
							<!-- Social Info -->
							<div class="team-member-social-info">
								<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
								<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
								<a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
								<a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
							</div>
						</div>
						<!-- Team Member Info -->
						<div class="team-member-info mt-30">
							<a
								class="btn btn-link"
								data-toggle="modal"
								data-target="#modal_detail_teknisi"
								id="detail_teknisi"
								data-id="<?php echo $data['id_teknisi']; ?>"
								data-content="<?php echo $content; ?>"
								aria-hidden="true"
							>
								<h5><?php echo $data['nama_lengkap']; ?></h5>
							</a>
							<!-- <p>CEO &amp; Founder</p> -->
						</div>
					</div>
				</div>
			<?php endforeach ?>

		</div>
	</div>
</section>
<!-- ##### Team Area End ##### -->

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