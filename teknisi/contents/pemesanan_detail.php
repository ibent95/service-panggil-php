<?php
	$action = (isset($_GET['action'])) ? $_GET['action'] : 'lihat' ;
	$id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
	if ($action == NULL) {
		$_SESSION['message-type'] = "danger";
		$_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
		echo "<script>location.replace('?content=pemesanan')</script>";
	}
	// if ($action != 'lihat') {
	$pemesanan = mysqli_fetch_array(getPemesananJoinById($id), MYSQLI_BOTH);
	// $pemesananDetailAll = getDetailPemesananByIdPemesanan($pemesanan['id']);
	if (!empty($pemesanan['longlat'])) {
		$longlat = explode(",", $pemesanan['longlat']);
	} else {
		$longlat[0] = 0;
		$longlat[1] = 0;
	}
	$fotoKerusakanAll       = getFotoKerusakanByIdPemesanan($id);
	$softwareAll            = getJenisSoftwareByIdKategori($pemesanan['id_kategori']);
	$hardwareAll            = getJenisHardwareByIdKategori($pemesanan['id_kategori']);
	$sparepartAll           = getSparepartAll();
	// if ($action != 'lihat') {
		$pengerjaanAll      = getDetailPemesananByIdPemesanan($id, '', '', 'not_tidak', 'ASC');
		// $biayaTambahan      = getBiayaTambahanByIdPemesanan($id);
		$riwayatPembayaran  = getBuktiPembayaranByIdPemesanan($id, '', 'ASC');
		$sisaPembayaran     = 0;
		foreach ($pengerjaanAll as $data) {
			$sisaPembayaran += $data['harga'];
		}
		// foreach ($biayaTambahan as $data) {
		//     $sisaPembayaran += $data['harga_biaya_tambahan'];
		// }
		foreach ($riwayatPembayaran as $data) {
			$sisaPembayaran -= $data['jumlah'];
		}
		$pemesanan['status_pembayaran'] = (mysqli_num_rows($riwayatPembayaran) !== 0 AND $sisaPembayaran === 0) ? "Lunas" : "Belum Lunas";
	// }
	$totalHarga = 0;
	$no = 1;
	// }
?>
<!-- Bread crumb -->
<div class="row page-titles">
	<div class="col-md-5 align-self-center">
		<h3 class="text-primary">
			Diagnosis
		</h3>
	</div>
	<div class="col-md-7 align-self-center">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="javascript:void(0)">
					Home
				</a>
			</li>
			<li class="breadcrumb-item">
				<a href="?content=pemesanan">
					Transaksi
				</a>
			</li>
			<li class="breadcrumb-item active">
				Diagnosis
			</li>
		</ol>
	</div>
</div>
<!-- End Bread crumb -->
<!-- Container fluid  -->
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card text-dark">
				<div class="card-title">
					<h4>Form Diagnosis - <?= $pemesanan['id_pemesanan'] ?></h4>
				</div>
				<div class="card-body">
					<p class="text-dark">
						Diagnosis kerusakan pada perangkat dan perbaikan yang dilakukan :
					</p>
					<div class="text-dark">
						<div class="row">
							<div class="col-md-5">
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Tanggal Transaksi</label>
									<div class="col-md-7">
										<input class="form-control-plaintext" type="text" value=": <?= $pemesanan['tanggal_pesan'] ?>" disabled />
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Pelanggan</label>
									<div class="col-md-7">
										<input class="form-control-plaintext" type="text" value=": <?= $pemesanan['nama_pelanggan'] ?>" disabled />
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Kategori Layanan</label>
									<div class="col-md-7">
										<input class="form-control-plaintext" type="text" value=": <?= $pemesanan['nama_kategori_layanan'] ?>" disabled />
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Tanggal Pengerjaan</label>
									<div class="col-md-7">
										<input class="form-control-plaintext" type="text" value=": <?= $pemesanan['tanggal_kerja'] ?>" disabled />
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-5 col-form-label">Keluhan</label>
									<div class="col-md-7">
										<textarea class="form-control-plaintext" disabled ><?= $pemesanan['keluhan'] ?></textarea>
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<div class="form-group" id="form-lokasi" > <!-- style="display: none;" -->
									<label class="col-md-3 control-label">Lokasi</label>
									<div class="col-md-12">
										<input type="hidden" class="form-control input-rounded input-focus" name="longlat" value="<?= $pemesanan['longlat'] ?>" id="longlat" >
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
								<p class="text-dark">Foto Kerusakan :</p>
								<?php foreach ($fotoKerusakanAll as $data): ?>
									<img src="<?php echo searchFile($data['url_file'], "img", "short"); ?>" class="img-fluid img-thumbnail mb-2" alt="..." style="height: 150px;" id="image_gallery">
								<?php endforeach ?>
							</div>
						</div>
					<?php endif ?>
					<p class="text-dark mt-3">
						Daftar Pengerjaan & Sparepart :
						<a class="btn btn-primary btn-sm" href="?content=pengerjaan_form&action=tambah&id=<?php print $id; ?>">
							<i class="fas fa-plus"></i>
							Tambah
						</a>
					</p>
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Jenis Layanan</th>
									<th>Kategori</th>
									<th>Pengerjaan Ke</th>
									<th>Harga</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody id="pengerjaan_list">
								<?php if (mysqli_num_rows($pengerjaanAll) === 0 AND !isset($_SESSION['processing'])) : ?>
									<tr>
										<td class="text-center" colspan="5">Tidak ada data..!</td>
									</tr>
								<?php else : ?>
									<!-- Pengerjaan -->
									<?php foreach ($pengerjaanAll as $data) : ?>
										<?php if ($data['jenis_pengerjaan'] != 'biaya_tambahan') : ?>
											<tr>
												<td>
													<?php if (($data['jenis_pengerjaan'] == "software") OR ($data['jenis_pengerjaan'] == "hardware")) : ?>
														<?php echo $data['nama_jenis_layanan']; ?>
													<?php elseif ($data['jenis_pengerjaan'] == 'sparepart') : ?>
														<?php echo $data['nama_sparepart']; ?>
													<?php endif ?>
												</td>
												<td>
													<?php echo $data['jenis_pengerjaan']; ?>
												</td>
												<td class="text-right">
													<?php if ($data['pengerjaan_ke'] == '0') : ?>
														<?php echo setBadges('Belum Dikonfirmasi', 'danger'); ?>
													<?php else : ?>
														<?php echo $data['pengerjaan_ke']; ?>
													<?php endif ?>
												</td>
												<td class="text-right">
													<?php if (($data['jenis_pengerjaan'] == "software") OR ($data['jenis_pengerjaan'] == "hardware")) : ?>
														<?php echo format($data['harga'], 'currency'); ?>
													<?php elseif ($data['jenis_pengerjaan'] == 'sparepart') : ?>
														<?php echo format($data['harga'], 'currency'); ?>
													<?php endif ?>
												</td>
												<td>
													<button
														class="btn btn-warning btn-sm"
														data-toggle="modal"
														data-target="#modal_edit_pengerjaan"
														<?php echo "data-id_pemesanan_detail=\"" . $data['id_pemesanan_detail'] . "\""; ?>
														<?php echo "data-id_pemesanan=\"" . $data['id_pemesanan'] . "\""; ?>
														<?php echo "data-id_kategori=\"" . $pemesanan['id_kategori'] . "\""; ?>
														id="edit_pengerjaan"
													>
														<i class="fas fa-edit"></i>
														Ubah
													</button>
													<button
														class="btn btn-danger btn-sm"
														onclick="confirm('Apakah anda yakin ingin menghapus data ini..?', '<?php echo "?content=pengerjaan_proses&proses=remove&id=" . $data['id_pemesanan_detail']; ?>');"
													>
														<i class="fas fa-times"></i>
														Hapus
													</button>
												</td>
											</tr>
										<?php endif ?>
									<?php endforeach ?>
									<?php //print_r($_SESSION['processing']); ?>
									<?php if (isset($_SESSION['processing'])) : ?>
										<?php
											$array = array_keys($_SESSION["processing"]);
											for ($i = 0; $i <= end($array); $i++) :
										?>
											<?php //print_r(array_keys($_SESSION["processing"])); ?>
											<?php $data = $_SESSION["processing"][$i]; ?>
											<?php if ($data['jenis_pengerjaan'] != 'biaya_tambahan') : ?>
												<tr>
													<td>
														<?php echo $data['nama_jenis_layanan_sparepart']; ?>
													</td>
													<td>
														<?php echo $data['jenis_pengerjaan']; ?>
													</td>
													<td class="text-right">
														<?php if ($data['pengerjaan_ke'] == '0') : ?>
															<?php echo setBadges('Belum Dikonfirmasi', 'danger'); ?>
														<?php else : ?>
															<?php echo $data['pengerjaan_ke']; ?>
														<?php endif ?>
													</td>
													<td class="text-right">
														<?php if (($data['jenis_pengerjaan'] == "software") or ($data['jenis_pengerjaan'] == "hardware")) : ?>
															<?php echo format($data['harga'], 'currency'); ?>
														<?php elseif ($data['jenis_pengerjaan'] == 'sparepart') : ?>
															<?php echo format($data['harga'], 'currency'); ?>
														<?php endif ?>
													</td>
													<td>
														<button
															class="btn btn-warning btn-sm"
															data-toggle="modal"
															data-target="#modal_edit_processing"
															<?php echo "data-id_pemesanan_detail=\"" . array_keys($array)[$i] . "\""; ?>
															<?php echo "data-id_pemesanan=\"" . $data['id_pemesanan'] . "\""; ?>
															<?php echo "data-id_kategori=\"" . $pemesanan['id_kategori'] . "\""; ?>
															<?php echo "data-id_jenis_layanan_sparepart=\"" . $data['id_jenis_layanan_sparepart'] . "\""; ?>
															<?php echo "data-jenis_pengerjaan=\"" . $data['jenis_pengerjaan'] . "\""; ?>
															id="edit_pengerjaan"
														>
															<i class="fas fa-edit"></i>
															Ubah
														</button>
														<button
															class="btn btn-danger btn-sm"
															onclick="confirm('Apakah anda yakin ingin menghapus data ini..?', '<?php echo "?content=pengerjaan_proses&proses=remove_processing&id=" . array_keys($array)[$i]; ?>');"
														>
															<i class="fas fa-times"></i>
															Hapus
														</button>
													</td>
												</tr>
											<?php endif ?>
										<?php endfor ?>
									<?php endif ?>
									<!-- End Pengerjaan -->
								<?php endif ?>
							</tbody>
						</table>
					</div>
					<p class="text-dark mt-3">
						Daftar Biaya Tambahan & Administrasi :
						<button
							class="btn btn-primary btn-sm"
							data-toggle="modal"
							data-target="#modal_form_biaya_tambahan"
							<?php echo "data-id_pemesanan=\"" . $id . "\""; ?>
							<?php echo "data-action=\"tambah\""; ?>
							id="tambah_biaya_tambahan"
						>
							<i class="fas fa-plus"></i>
							Tambah
						</button>
					</p>
					<div class="table-responsive mb-2">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Keterangan</th>
									<th>Pengerjaan Ke</th>
									<th>Harga</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody id="pengerjaan_list">
								<?php if (mysqli_num_rows($pengerjaanAll) === 0 AND !isset($_SESSION['additional_cost'])) : ?>
									<tr>
										<td class="text-center" colspan="5">Tidak ada data..!</td>
									</tr>
								<?php else : ?>
									<!-- Biaya Tambahan -->
									<?php foreach ($pengerjaanAll as $data) : ?>
										<?php if ($data['jenis_pengerjaan'] == 'biaya_tambahan') : ?>
											<tr>
												<td>
													<?php echo $data['keterangan']; ?>
												</td>
												<td class="text-right">
													<?php if ($data['pengerjaan_ke'] == '0') : ?>
														<?php echo setBadges('Belum Dikonfirmasi', 'danger'); ?>
													<?php else : ?>
														<?php echo $data['pengerjaan_ke']; ?>
													<?php endif ?>
												</td>
												<td class="text-right">
													<?php echo format($data['harga_biaya_tambahan'], 'currency'); ?>
												</td>
												<td>
													<button
														class="btn btn-warning btn-sm"
														data-toggle="modal"
														data-target="#modal_form_biaya_tambahan"
														<?php echo "data-id_biaya_tambahan=\"" . $data['id_biaya_tambahan'] . "\""; ?>
														<?php echo "data-id_pemesanan=\"" . $id . "\""; ?>
														<?php echo "data-action=\"ubah\""; ?>
														id="ubah_biaya_tambahan"
													>
														<i class="fas fa-edit"></i>
														Ubah
													</button>
													<button
														class="btn btn-danger btn-sm"
														onclick="confirm('Apakah anda yakin ingin menghapus data ini..?', '<?php echo "?content=biaya_tambahan_proses&proses=remove&id=" . $data['id_biaya_tambahan']; ?>');"
													>
														<i class="fas fa-times"></i>
														Hapus
													</button>
												</td>
											</tr>
										<?php endif ?>
									<?php endforeach ?>
									<?php //print_r($_SESSION['additional_cost']); ?>
									<?php if (isset($_SESSION['additional_cost'])) : ?>
										<?php
											$array = array_keys($_SESSION["additional_cost"]);
											for ($i = 0; $i <= end($array); $i++) :
										?>
											<?php //print_r(array_keys($_SESSION["additional_cost"])); ?>
											<?php //$data = $_SESSION["additional_cost"][$i]; ?>
											<?php if ($_SESSION["additional_cost"][$i]['jenis_pengerjaan'] == 'biaya_tambahan') : ?>
												<tr>
													<td>
														<?php echo $_SESSION["additional_cost"][$i]['keterangan']; ?>
													</td>
													<td class="text-right">
														<?php if ($_SESSION["additional_cost"][$i]['pengerjaan_ke'] == '0') : ?>
															<?php echo setBadges('Belum Dikonfirmasi', 'danger'); ?>
														<?php else : ?>
															<?php echo $_SESSION["additional_cost"][$i]['pengerjaan_ke']; ?>
														<?php endif ?>
													</td>
													<td class="text-right">
														<?php echo format($_SESSION["additional_cost"][$i]['harga_biaya_tambahan'], 'currency'); ?>
													</td>
													<td>
														<button
															class="btn btn-warning btn-sm"
															data-toggle="modal"
															data-target="#modal_form_additional_cost"
															<?php echo "data-id_array=\"" . array_keys($array)[$i] . "\""; ?>
															<?php echo "data-id_biaya_tambahan=\"" . $_SESSION["additional_cost"][$i]['id_jenis_layanan_sparepart'] . "\""; ?>
															<?php echo "data-id_pemesanan=\"" . $id . "\""; ?>
															<?php echo "data-action=\"ubah\""; ?>
															id="ubah_biaya_tambahan"
														>
															<i class="fas fa-edit"></i>
															Ubah
														</button>
														<button
															class="btn btn-danger btn-sm"
															onclick="confirm('Apakah anda yakin ingin menghapus data ini..?', '<?php echo "?content=biaya_tambahan_proses&proses=remove_additional_cost&id=" . array_keys($array)[$i]; ?>');"
														>
															<i class="fas fa-times"></i>
															Hapus
														</button>
													</td>
												</tr>
											<?php endif ?>
										<?php endfor ?>
									<?php endif ?>
									<!-- End Biaya Tambahan -->
								<?php endif ?>
							</tbody>
						</table>
					</div>
					<?php if ($action == 'konfirmasi' OR (isset($_SESSION['processing']) OR isset($_SESSION['additional_cost']))) : ?>
						<form
							class="text-right"
							<?php if ($action == 'konfirmasi' OR $action == 'lihat') : ?>
								action="?content=pemesanan_proses&proses=confirm"
							<?php elseif ($action == 'ubah') : ?>
								action="?content=pemesanan_proses&proses=edit"
							<?php endif ?>
							method="POST"
							enctype="multipart/form-data"
						>
							<input type="hidden" name="id_pemesanan" value="<?php echo $id; ?>">
							<input type="hidden" name="status_check_teknisi" value="sudah">
							<div class="form-group row">
								<div class="col-md-12">
									<button type="submit" class="btn btn-primary">
										<i class="fas fa-edit"></i>
										Konfirmasi
									</button>
									<!--
									<input type="reset" class="btn btn-danger"/>
									-->
								</div>
							</div>
						</form>
					<?php endif ?>
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
<script type="text/javascript">
	function getCurrency() {
		var totalBiayaAwal = document.getElementById('currency-total-biaya').split(" ");
		$('label#currency-total-biaya').html(totalBiayaAwal[1] + $('input#total-biaya').val());
		console.log("getCurrency : Success...");
	}
</script>