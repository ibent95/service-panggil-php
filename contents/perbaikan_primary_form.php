<?php
cekLogin('pelanggan');
$action = (isset($_GET['action'])) ? antiInjection($_GET['action']) : NULL;
$idKategori = (isset($_GET['id_kategori'])) ? antiInjection($_GET['id_kategori']) : NULL;
if ($action == NULL) {
	$_SESSION['message-type'] 		= "danger";
	$_SESSION['message-content'] 	= "Action belum ditentukan..!";
	echo "<script>location.replace('?content=perbaikan')</script>";
}
if ($idKategori == NULL) {
	$_SESSION['message-type'] 		= "danger";
	$_SESSION['message-content'] 	= "Anda belum memilih kategori..!";
	echo "<script>location.replace('?content=perbaikan')</script>";
}
$kategori = mysqli_fetch_array(
	getKategoriById($idKategori),
	MYSQLI_BOTH
);
$softwareAll = getJenisSoftwareByIdKategori($idKategori);
$hardwareAll = getJenisHardwareByIdKategori($idKategori);
$sparepartAll = getSparepartAll();
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
					<form class="form-horizontal" <?php if ($action == 'tambah') : ?> action="?content=perbaikan_primary_proses&proses=add" <?php elseif ($action == 'ubah') : ?> action="?content=perbaikan_primary_proses&proses=edit" <?php endif ?> method="POST" enctype="multipart/form-data">

						<div class="form-group row">
							<label class="col-md-3 col-form-label" for="">Nama Pelanggan</label>
							<div class="col-md-9">
								<input type="hidden" name="id_pelanggan" id="id_pelanggan" value="<?php echo $_SESSION['id']; ?>">
								<input type="text" class="form-control-plaintext" name="nama_pelanggan" id="nama_pelanggan" value="<?php echo $_SESSION['nama_lengkap']; ?>" readonly>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-3 col-form-label" for="">No. Telp (Yang bisa dihubungi)</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="no_telp" id="no_telp" placeholder="No. Telepon yang bisa dihubungi..." value="<?php echo $_SESSION['no_hp']; ?>">
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-3">Datang ke Lokasi Pelanggan</div>
							<div class="col-sm-9">
								<div class="form-check">
									<input class="form-check-input form-sm" type="checkbox" name="datang_ke_lokasi" value="ya" id="datang_ke_lokasi" />
									<label class="form-check-label" for="datang_ke_lokasi">
										Ya
									</label>
									<label></label>
								</div>
							</div>
						</div>

						<div id="form-lanjutan" style="display: none;">
							<!-- <style>
								button.Zebra_DatePicker_Icon {
									margin-top: 8%;
								}
							</style> -->
							<div class="form-group row">
								<label for="tanggal_kerja" class="col-sm-3 col-form-label">Tanggal Pengerjaan</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="tanggal_kerja" id="tanggal_kerja" placeholder="Tanggal Pengerjaan..." style="width: 230px;" />
								</div>
							</div>
							<div class="form-group row">
								<label for="alamat" class="col-sm-3 col-form-label">Alamat Pelanggan</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Pelanggan yang ingin didatangi..." />
								</div>
							</div>

							<div class="form-group row">
								<label for="alamat" class="col-sm-3 col-form-label">Map</label>
								<div class="col-sm-9">
									<input type="hidden" class="form-control" name="longlat" id="longlat" placeholder="Lokasi..." />
									<div id="map" style="width:100%; height:500px"></div>
									<script>
										function initMap() {
											var lngs = 0;
											var lats = 0;
											var inputAddress = document.getElementById('alamat');
											var input = document.getElementById('longlat');
											var myLatlng = (lngs == 0 && lats == 0) ? {
												lat: -5.147665,
												lng: 119.432732
											} : {
												lat: lats,
												lng: lngs
											};
											var map = new google.maps.Map(document.getElementById('map'), {
												zoom: 14,
												center: myLatlng
											});

											map.addListener('center_changed', function() {
												// 3 seconds after the center of the map has changed, pan back to the marker.
												var lnglat = map.getCenter();
												var lat = lnglat.lat();
												var lng = lnglat.lng();
												marker.setPosition(map.getCenter());
												document.getElementById('longlat').value = lng + ',' + lat;
											});

											var searchBox = new google.maps.places.Autocomplete(inputAddress, {
												componentRestrictions: {
													country: 'id' // ['us', 'pr', 'vi', 'gu', 'mp']
												}
											});

											searchBox.addListener('place_changed', function() { // places_changed
												var place = searchBox.getPlace();

												// For each place, get the icon, name and location.
												var bounds = new google.maps.LatLngBounds();

												// places.forEach(function(place) {
												if (!place.geometry) {
													console.log("Returned place contains no geometry");
													return;
												}

												// Create a marker for each place.
												marker.setPosition(place.geometry.location);

												if (place.geometry.viewport) {
													// Only geocodes have viewport.
													bounds.union(place.geometry.viewport);
												} else {
													bounds.extend(place.geometry.location);
												}
												// });
												map.fitBounds(bounds);
												// map.setCenter(marker.getPosition());
											});

											var marker = new google.maps.Marker({
												position: myLatlng,
												map: map,
												animation: google.maps.Animation.DROP,
												title: 'Click to zoom'
											});

											marker.addListener('click', function() {
												map.setZoom(18);
												map.setCenter(marker.getPosition());
												var info = (searchBox.getPlace()) ? searchBox.getPlace()['adr_address'] : "Alamat Belum dimasukan..!";
												infoWindow.setContent("<div style='text-align: center;'>" + info + "</div>");
												infoWindow.open(map, marker)
											});

											var infoWindow = new google.maps.InfoWindow();

											// var distance = google.maps.geometry.spherical.computeDistanceBetween(dest, marker.position);
										}
									</script>
								</div>
							</div>
						</div>

						<div class="form-group row">
							<div class="offset-md-3 col-md-9 text-right">
								<input type="hidden" name="id_kategori" value="<?php echo $idKategori; ?>">
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

<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&libraries=places&callback=initMap'>
</script>

<!-- Modal Detail Teknisi -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true" id="modal_detail_teknisi">
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