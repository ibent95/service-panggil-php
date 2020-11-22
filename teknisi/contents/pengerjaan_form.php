<?php
	$action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
	$id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
	if ($action == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>location.replace('?content=pemesanan')</script>";
	}
	// $kategoriAll = getKategoriAll();
	// if ($action == 'ubah') {
	$pemesanan = mysqli_fetch_array(
		getPemesananJoinById($id), 
		MYSQLI_BOTH
	);
	$pemesananDetailAll = getDetailPemesananByIdPemesanan($pemesanan['id_pemesanan']);
	if (!empty($pemesanan['longlat'])) {
		$longlat = explode(",", $pemesanan['longlat']);
	} else {
		$longlat[0] = 0;
		$longlat[1] = 0;
	}
	$fotoKerusakanAll = getFotoKerusakanByIdPemesanan($id);
	$softwareAll = getJenisSoftwareByIdKategori($pemesanan['id_kategori']);
	$hardwareAll = getJenisHardwareByIdKategori($pemesanan['id_kategori']);
	$sparepartAll = getSparepartAll();
	// }
?>
<!-- Bread crumb -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-primary">Pemesanan</h3> </div>
	<div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
			<li class="breadcrumb-item">
				<a href="?content=pemesanan">Pemesanan</a>
			</li>
			<li class="breadcrumb-item">
				<a href="?content=pemesanan_detail&id=<?php echo $id; ?>">Pemesanan Detail</a>
			</li>
			<li class="breadcrumb-item active">Tambah Pemesanan</li>
		</ol>
	</div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">

			<div class="card">

				<div class="card-title">
					<h4>Form Pemesanan</h4>
				</div>

				<div class="card-body">
					<p class="text-dark">
						Diagnosis kerusakan pada perangkat dan perbaikan yang dilakukan :
					</p>
					<div class="text-dark">
						<div class="row">
							<div class="col-md-5">
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Tanggal Pemesanan</label>
									<div class="col-md-7">
										<input
											class="form-control-plaintext"
											type="text"
											value=": <?php echo $pemesanan['tanggal_pesan']; ?>"
											disabled
										/>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Pelanggan</label>
									<div class="col-md-7">
										<input
											class="form-control-plaintext"
											type="text"
											value=": <?php echo $pemesanan['nama_pelanggan']; ?>"
											disabled
										/>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Kategori Layanan</label>
									<div class="col-md-7">
										<input
											class="form-control-plaintext"
											type="text"
											value=": <?php echo $pemesanan['nama_kategori_layanan']; ?>"
											disabled
										/>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Tanggal Pengerjaan</label>
									<div class="col-md-7">
										<input
											class="form-control-plaintext"
											type="text"
											value=": <?php echo $pemesanan['tanggal_kerja']; ?>"
											disabled
										/>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Keluhan</label>
									<div class="col-md-7">
										<textarea
											class="form-control-plaintext"
											disabled
										><?= $pemesanan['keluhan'] ?></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group" id="form-lokasi" > <!-- style="display: none;" -->
									<label class="col-md-3 control-label">Lokasi</label>
									<div class="col-md-12">
										<input
											type="hidden"
											class="form-control input-rounded input-focus"
											name="longlat"
											value="<?= $pemesanan['longlat'] ?>"
											id="longlat"
										>
										<!-- <br> -->
										<div id="map" style="width:100%; height:300px"></div>
										<script>
											function initMap() {
												var lngs = <?php echo $longlat[0]; ?>;
												var lats = <?php echo $longlat[1]; ?>;
												var input = document.getElementById('longlat');
												var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
												var labelIndex = 0;
												if (lngs == 0 && lats == 0) {
													var myLatlng = {lat: -5.147665, lng: 119.432732};
												} else {
													// console.log(lngs);
													// console.log(lats);
													var myLatlng = {lat: lats, lng: lngs};
												}

												var map = new google.maps.Map(document.getElementById('map'), {
													zoom: 15,
													center: myLatlng
												});

												var marker = new google.maps.Marker({
													position: myLatlng,
													map: map,
													label: 'B',
													title: 'Click to zoom'
												});

												var infoWindow = new google.maps.InfoWindow({map: map});

												// google.maps.event.addDomListener(map, 'click', function(event) {
												//     var myLatLng = event.latLng;
												//     var lat = myLatLng.lat();
												//     var lng = myLatLng.lng();
												//     alert( 'lat '+ lat + ' lng ' + lng );
												// }

												// Try HTML5 geolocation.
												var watchID = null;
												if (navigator.geolocation) {
													var optn = {
														enableHighAccuracy: true,
														timeout: Infinity,
														maximumAge: 0
													};
													navigator.geolocation.getCurrentPosition(function(position) {
															var pos = {
																lat: position.coords.latitude,
																lng: position.coords.longitude,
																mapTypeId:google.maps.MapTypeId.ROAD
															};
															var markerA = new google.maps.Marker({
																position: pos,
																map: map,
																label: 'A',
																title: 'Click to zoom'
															});
															// infoWindow.setPosition(pos);
															// infoWindow.setContent('Location found.');
															// map.setCenter(pos);
														}, function(failure) {
															handleLocationError(true, infoWindow, map.getCenter());
															if (failure.message.indexOf("Only secure origins are allowed") == 0) {
																handleLocationError(true, infoWindow, map.getCenter());
															}
														}, optn
													);
													// $("button").click(function(){
													//     if (watchID)
													//         navigator.geolocation.clearWatch(watchID);

													//     watchID = null;
													//     return false;
													// });
												} else {
													// Browser doesn't support Geolocation
													handleLocationError(false, infoWindow, map.getCenter());
												}
												// map.addListener('center_changed', function() {
												//     // 3 seconds after the center of the map has changed, pan back to the
												//     // marker.
												//     var lnglat = map.getCenter();
												//     var lat = lnglat.lat();
												//     var lng = lnglat.lng();
												//     // input.value = lng + ',' + lat;
												//     marker.setPosition(map.getCenter());
												//     input.value = lng + ',' + lat;
												// });
												// marker.addListener('click', function() {
												//     map.setZoom(15);
												//     map.setCenter(marker.getPosition());
												// });
											}
											function handleLocationError(browserHasGeolocation, infoWindow, pos) {
												infoWindow.setPosition(pos);
												infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
											}
										</script>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php if (mysqli_num_rows($fotoKerusakanAll) > 0) : ?>
						<div class="row">
							<div class="col-md-12">
								<p class="text-dark">
									Foto Kerusakan :
								</p>
								<?php foreach ($fotoKerusakanAll as $data): ?>
									<img src="<?php echo searchFile($data['url_file'], "img", "short"); ?>" class="img-fluid img-thumbnail" alt="..." style="height: 150px;" id="image_gallery">
								<?php endforeach ?>
							</div>
						</div>
					<?php endif ?>

					<p class="text-dark mt-3">
						Daftar Pengerjaan & Sparepart : 
					</p>

					<form 
						class="form-horizontal" 
						<?php if ($action == 'tambah') : ?>
							action="?content=pengerjaan_proses&proses=add" 
						<?php else: ?>
							action="?content=pengerjaan_proses&proses=edit"
						<?php endif ?> 
						method="POST"
						enctype="multipart/form-data"
					>
						<?php if ($action == 'tambah' OR $action == 'ubah') : ?>
							<input type="hidden" name="id" value="<?php echo $id; ?>">
						<?php endif ?>

						<div class="">
							<div class="todo-list">
								<div class="tdl-holder">
									<div class="tdl-content">
										<ul>
											<div class="accordion" id="accordion">
												<!-- Software -->
												<div class="card-header border-right border-left border-top">
													<h5 class="mb-0">
														<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_software" aria-expanded="true" aria-controls="collapse_software">
															Jasa Pengerjaan Software
														</button>
													</h5>
												</div>
												<div class="card-body border-right border-left">
													<div class="collapse show" aria-labelledby="collapse_software" data-parent="#accordion" id="collapse_software">
														<?php foreach ($softwareAll as $data) : ?>
															<li>
																<label>
																	<input
																		type="checkbox"
																		name="software[]"
																		value="<?php echo $data['id_layanan_jenis']; ?>"
																		class="hide"
																		id="software-<?php echo $data['id_layanan_jenis']; ?>"
																	>
																	<i class="bg-dark"></i>
																	<span>
																		<?php echo $data['nama_jenis_layanan'] . " [<b>" . format($data['harga'], "currency") . "</b>]"; ?>
																	</span>
																</label>
															</li>
														<?php endforeach ?>
													</div>
												</div>
												<!-- hardware -->
												<div class="card-header border-right border-left border-top">
													<h5 class="mb-0">
														<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_hardware" aria-expanded="false" aria-controls="collapse_hardware">
															Jasa Pengerjaan Hardware
														</button>
													</h5>
												</div>
												<div class="card-body border-right border-left">
													<div class="collapse show" aria-labelledby="collapse_hardware" data-parent="#accordion" id="collapse_hardware">
														<?php foreach ($hardwareAll as $data) : ?>
															<li>
																<label>
																	<input type="checkbox" name="hardware[]" value="<?php echo $data['id_layanan_jenis']; ?>">
																	<i class="bg-dark"></i>
																	<span>
																		<?php echo $data['nama_jenis_layanan'] . " [<b>" . format($data['harga'], "currency") . "</b>]"; ?>
																	</span>
																</label>
															</li>
														<?php endforeach ?>
													</div>
												</div>
												<!-- Sparepart -->
												<div class="card-header border-right border-left border-top">
													<h5 class="mb-0">
														<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_sparepart" aria-expanded="false" aria-controls="collapse_sparepart">
															Penggantian Sparepart
														</button>
													</h5>
												</div>
												<div class="card-body border-right border-left border-bottom">
													<div class="collapse show" aria-labelledby="collapse_sparepart" data-parent="#accordion" id="collapse_sparepart">
														<?php foreach ($sparepartAll as $data) : ?>
															<li>
																<label>
																	<input type="checkbox" name="sparepart[]" value="<?php echo $data['id_sparepart']; ?>">
																	<i class="bg-dark"></i>
																	<span>
																		<?php echo $data['nama_sparepart'] . " [<b>" . format($data['harga'], "currency") . "</b>]"; ?>
																	</span>
																</label>
															</li>
														<?php endforeach ?>
													</div>
												</div>
												<!-- Total Biaya -->
												<!--
												<div class="card-header border-right border-left border-top">
													<div class="row">
														<div class="col-md-6">
															<label class="mb-0 text-primary" style="text-">
																Total Biaya
															</label>
														</div>
														<div class="col-md-6">
															<label class="text-right" id='currency-total-biaya'>Rp 0</label>
															<input type="hidden" value="0" name="total-biaya" id="total-biaya" onchange="getCurrency();">
														</div>
													</div>
												</div>
												-->
											</div>
										</ul>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group text-right mt-3">
							<input type="submit" class="btn btn-primary" name="simpan" value="Simpan"/>
							<input type="reset" class="btn btn-danger"/>
						</div>

					</form>
				</div>
				<!-- End Card Body -->

			</div>
			<!-- End Card -->

		</div>
		<!-- End Coloumn -->

	</div>
	<!-- End Row -->

</div>

<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'>
</script>