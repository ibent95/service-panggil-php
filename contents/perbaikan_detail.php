<?php
	$action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
	$id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
	if ($id == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>location.replace('?content=profil')</script>";
	}
	// if ($action == 'persetujuan') {
		$pemesanan = mysqli_fetch_array(
			getPemesananJoinById($id),
			MYSQLI_BOTH
		);
		// $pemesananDetailAll = getDetailPemesananByIdPemesanan($pemesanan['id']);
		$diagnosisSoftware  = getDetailPemesananByIdPemesanan($id, 'software', '', 'ya', 'ASC');
		$diagnosisHardware  = getDetailPemesananByIdPemesanan($id, 'hardware', '', 'ya', 'ASC');
		$diagnosisSparepart = getDetailPemesananByIdPemesanan($id, 'sparepart', '', 'ya', 'ASC');
		$biayaTambahan      = getDetailPemesananByIdPemesanan($id, 'biaya_tambahan', '', 'ya', 'ASC');
		// $biayaTambahan      = getBiayaTambahanByIdPemesanan($id);
		$riwayatPembayaran  = getBuktiPembayaranByIdPemesanan($id, '', 'ASC');
		$sisaPembayaran     = 0;
		foreach ($diagnosisSoftware as $data) {
			$sisaPembayaran += $data['harga'];
		}
		foreach ($diagnosisHardware as $data) {
			$sisaPembayaran += $data['harga'];
		}
		foreach ($diagnosisSparepart as $data) {
			$sisaPembayaran += $data['harga'];
		}
		foreach ($biayaTambahan as $data) {
			$sisaPembayaran += $data['harga_biaya_tambahan'];
		}
		foreach ($riwayatPembayaran as $data) {
			if ($data['konfirmasi_admin'] == 'ya' OR $data['konfirmasi_admin'] == 'belum') {
				$sisaPembayaran -= $data['jumlah'];
			}
		}
		$pemesanan['status_pembayaran'] = (mysqli_num_rows($riwayatPembayaran) !== 0 AND $sisaPembayaran === 0) ? "Lunas" : "Belum Lunas" ;
		if (!empty($pemesanan['longlat'])) {
			$longlat = explode(",", $pemesanan['longlat']);
		} else {
			$longlat[0] = 0;
			$longlat[1] = 0;
		}
	// }
	$no         = 1;
	$totalHarga = 0;
?>
<!-- ##### Breadcrumb Area Start ##### -->
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(assets/frontend/img/bg-img/24.jpg);">
		<h2>Detail Pemesanan - <?php echo $pemesanan['no_pemesanan']; ?></h2>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-12">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo $csv::$URL_BASE; ?>"><i class="fa fa-home"></i> Home</a></li>
						<li class="breadcrumb-item">
							<a href="<?php echo $csv::$URL_BASE; ?>/?content=profil">
								<!-- <i class="fa fa-home"></i> -->
								Profil
							</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Detail Pemesanan</li>
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
						<h2>Detail Pemesanan - <?php echo $pemesanan['no_pemesanan']; ?></h2>
						<!-- <p>We are improving our services to serve you better.</p> -->
					</div>
					<div class="text-dark">
						<p class="">
							<button class="btn btn-default text-dark" onclick="window.location.replace('?content=profil');" role="button" data-toggle="button" aria-pressed="false" autocomplete="off">
								<i class="fa fa-arrow-left"></i>
								Kembali
							</button>
						</p>
						<div class="card-title">
							<h4><?php if ($action == "persetujuan") echo "Form Persetujuan "; ?></h4>
						</div>

						<div class="card-body">

							<?php if ($action == "persetujuan") : ?>
								<p class="text-dark">
									Tindak lanjut atau persetujuan untuk pemesanan :
								</p>
							<?php endif ?>

							<div class="text-dark">
								<div class="row">
									<div class="col-md-5">

										<div class="form-group row">
											<label class="col-md-4 col-form-label">No. Pemesanan</label>
											<div class="col-md-8">
												<input
													class="form-control-plaintext"
													type="text"
													value=": <?php echo $pemesanan['no_pemesanan']; ?>"
													disabled
												/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-md-4 col-form-label">Tanggal Pemesanan</label>
											<div class="col-md-8">
												<input
													class="form-control-plaintext"
													type="text"
													value=": <?php echo $pemesanan['tanggal_pesan']; ?>"
													disabled
												/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-md-4 col-form-label">Pelanggan</label>
											<div class="col-md-8">
												<input
													class="form-control-plaintext"
													type="text"
													value=": <?php echo $pemesanan['nama_pelanggan']; ?>"
													disabled
												/>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-md-4 col-form-label">Status Pembayaran</label>
											<div class="col-md-8">
												<div class="form-control-plaintext">
													: <?php echo $pemesanan['status_pembayaran']; ?>
												</div>
											</div>
										</div>

										<?php if (mysqli_num_rows($riwayatPembayaran) > 0) : ?>
											<div class="form-group row">
												<label class="col-md-4 col-form-label">Bukti Pembayaran</label>
												<div class="col-md-8">
												<?php foreach ($riwayatPembayaran AS $data) : ?>
													<?php if ($data['konfirmasi_admin'] == 'ya' OR $data['konfirmasi_admin'] == 'belum'): ?>
														<img class="img-thumbnail" width='90dp' src='<?php echo searchFile($data["bukti_pembayaran"], "img", "short"); ?>' id="image_gallery">
													<?php endif ?>
												<?php endforeach ?>
												</div>
											</div>
										<?php endif ?>
									</div>
									<div class="col-md-7">

										<div class="form-group row">
											<label class="col-md-3 col-form-label">Teknisi</label>
											<div class="col-md-9">
												<div class="form-control-plaintext">
													: <?php echo $teknisi = ($pemesanan['nama_teknisi']) ? $pemesanan['nama_teknisi'] . ' [' . mysqli_fetch_assoc(getTeknisiById($pemesanan['id_teknisi']))['no_hp'] . ']' : 'Belum ditentukan' ; ?>
												</div>
											</div>
										</div>

										<div class="form-group row">
											<label class="col-md-3 col-form-label">Datang ke Lokasi</label>
											<div class="col-md-9">
												<div class="form-control-plaintext">
													: <?php echo setBadges($pemesanan['datang_ke_lokasi']); ?>
												</div>
											</div>
										</div>
										<?php if ($pemesanan['datang_ke_lokasi'] == 'ya') : ?>
											<div class="form-group row">
												<label class="col-md-3 col-form-label">Tanggal Pengantaran</label>
												<div class="col-md-9">
													<input
														class="form-control-plaintext"
														type="text"
														value=": <?php echo $pemesanan['tanggal_kerja']; ?>"
														disabled
													/>
												</div>
											</div>

											<div class="form-group row" id="form-lokasi" > <!-- style="display: none;" -->
												<label class="col-md-3 col-form-label">Alamat Pengantaran</label>
												<div class="col-md-9">
													<textarea
														class="form-control-plaintext"
														id="alamat"
														cols="30"
														rows="0"
													>: <?php echo $pemesanan['alamat']; ?></textarea>
												</div>
											</div>

											<div class="form-group row" id="form-lokasi" > <!-- style="display: none;" -->
												<label class="col-md-3 control-label">Lokasi</label>
												<div class="col-md-12">
													<input
														type="hidden"
														class="form-control input-rounded input-focus"
														name="longlat"
														value="<?php echo $pemesanan['longlat']; ?>"
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
										<?php endif ?>
									</div>
								</div>

								<div class="row">
									<div class="col-md-12">
										<label for="table" class="">Data Pengerjaan</label>
										<div class="table-responsive">
											<table class="table table-bordered table-hover table-striped">
												<thead>
													<tr>
														<th>Nama Layanan</th>
														<th>Harga</th>
													</tr>
												</thead>
												<tbody>
													<?php if (mysqli_num_rows($diagnosisSoftware) == 0 AND mysqli_num_rows($diagnosisHardware) == 0 AND mysqli_num_rows($diagnosisSparepart) == 0 AND mysqli_num_rows($biayaTambahan) == 0) : ?>
														<tr>
															<td colspan="2" style="text-align: center;">
																<?php if ($pemesanan['status_pemesanan'] == 'selesai' OR $pemesanan['status_pemesanan'] == 'batal') : ?>
																	Tidak
																<?php elseif ($pemesanan['status_pemesanan'] == 'tunggu' OR $pemesanan['status_pemesanan'] == 'proses') : ?>
																	Belum
																<?php endif ?>
																ada Pengerjaan..!
															</td>
														</tr>
													<?php else : ?>
														<?php if (mysqli_num_rows($diagnosisSoftware) > 0) : ?>
															<tr>
																<td class="text-left font-weight-bold" colspan="2">
																	&nbsp;&nbsp; Software
																</td>
															</tr>
															<?php foreach ($diagnosisSoftware as $data): ?>
																<tr>
																	<td>
																		<?php
																			echo $no . ". " . $data['nama_jenis_layanan'];
																			$no++;
																		?>
																	</td>
																	<td class="text-right">
																		<?php
																			echo format($data['harga'], 'currency');
																			$totalHarga = $totalHarga + $data['harga'];
																		?>

																	</td>
																</tr>
															<?php endforeach ?>
														<?php endif ?>
														<?php if (mysqli_num_rows($diagnosisHardware) > 0) : ?>
															<tr>
																<td class="text-left font-weight-bold" colspan="2">
																	&nbsp;&nbsp;  Hardware
																</td>
															</tr>
															<?php foreach ($diagnosisHardware as $data): ?>
																<tr>
																	<td>
																		<?php
																			echo $no . ". " . $data['nama_jenis_layanan'];
																			$no++;
																		?>
																	</td>
																	<td class="text-right">
																		<?php
																			echo format($data['harga'], 'currency');
																			$totalHarga = $totalHarga + $data['harga'];
																		?>
																	</td>
																</tr>
															<?php endforeach ?>
														<?php endif ?>
														<?php if (mysqli_num_rows($diagnosisSparepart) > 0) : ?>
															<tr>
																<td class="text-left font-weight-bold" colspan="2">
																	&nbsp;&nbsp;  Sparepart
																</td>
															</tr>
															<?php foreach ($diagnosisSparepart as $data): ?>
																<tr>
																	<td>
																		<?php
																			echo $no . ". " . $data['nama_sparepart'];
																			$no++;
																		?>
																	</td>
																	<td class="text-right">
																		<?php
																			echo format($data['harga'], 'currency');
																			$totalHarga = $totalHarga + $data['harga'];
																		?>
																	</td>
																</tr>
															<?php endforeach ?>
														<?php endif ?>
														<?php if (mysqli_num_rows($biayaTambahan) > 0) : ?>
															<tr>
																<td class="text-left font-weight-bold" colspan="2">
																	&nbsp;&nbsp;  Biaya Tambahan
																</td>
															</tr>
															<?php foreach ($biayaTambahan as $data): ?>
																<tr>
																	<td>
																		<?php
																			echo $no . ". " . $data['keterangan'];
																			$no++;
																		?>
																	</td>
																	<td class="text-right">
																		<?php
																			echo format($data['harga_biaya_tambahan'], 'currency');
																			$totalHarga = $totalHarga + $data['harga_biaya_tambahan'];
																		?>
																	</td>
																</tr>
															<?php endforeach ?>
														<?php endif ?>
													<?php endif ?>
													<tr style="font-weight: bold;">
														<td style="text-align: right;">
															<?php if ($pemesanan['status_pemesanan'] == 'selesai') : ?>
																Total Harga
															<?php else : ?>
																Total Estimasi
															<?php endif ?>
														</td>
														<td class="font-weight-bold text-right">
															<?php echo format($totalHarga, 'currency'); ?>
														</td>
													</tr>
													<!-- Riwayat Pembayaran -->
													<?php if (mysqli_num_rows($riwayatPembayaran) > 0) : ?>
														<tr style="font-weight: bold;">
															<td colspan="3" style="text-align: left;">&emsp;Riwayat Pembayaran</td>
														</tr>
														<?php foreach ($riwayatPembayaran as $pembayaran): ?>
															<?php if ($pembayaran['konfirmasi_admin'] == 'ya' OR $pembayaran['konfirmasi_admin'] == 'belum'): ?>
																<tr>
																	<td>
																		<?php
																			echo $no . ". ";
																			$no++;
																		?>
																		Pembayaran <?php echo $pembayaran['info_pembayaran']; ?> tanggal <?php echo format($pembayaran['tgl_pembayaran'], "date"); ?>

																	</td>
																	<td class="text-right">
																		<?php
																			echo format($pembayaran['jumlah'], "currency");
																			$totalHarga = $totalHarga - $pembayaran['jumlah'];
																		?>
																	</td>
																</tr>
															<?php endif ?>
														<?php endforeach ?>
													<?php endif ?>
													<tr>
														<td class="text-right font-weight-bold">
															<?php //if ($pemesanan['status_pemesanan'] == 'proses' AND $pemesanan['teknisi_check'] == 'selesai') : ?>
																Sisa Pembayaran
															<?php //else : ?>
																<!-- Total Estimasi -->
															<?php //endif ?>
														</td>
														<td class="font-weight-bold text-right">
															<?php echo format($totalHarga, 'currency'); ?>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- End Card Body -->
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ##### Checkout Area End ##### -->

<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'></script>