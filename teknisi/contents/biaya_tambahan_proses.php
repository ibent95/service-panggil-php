<?php
    $proses = $_GET['proses'];
	if ($proses == 'remove' OR $proses == 'remove_additional_cost') {
		$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit' or $proses == 'edit_additional_cost') {
			$idBiayaTambahan	= (isset($_POST['id_biaya_tambahan'])) ? antiInjection($_POST['id_biaya_tambahan']) : NULL;
		}
		$idPemesanan 			= (isset($_POST['id_pemesanan'])) ? $_POST['id_pemesanan'] : $_GET['id_pemesanan'] ;
		$keterangan				= (isset($_POST['keterangan'])) ? $_POST['keterangan'] : NULL ;
		$jumlah					= (isset($_POST['jumlah'])) ? $_POST['jumlah'] : NULL ;
	}
	$messages 					= array();
    $sql						= "";
    $redirect					= "";

	switch ($proses) {
		case 'add':
			try {
				if ($idPemesanan !== NULL AND $keterangan !== NULL AND $jumlah !== NULL) {
					$pemesanan = mysqli_fetch_array(
						mysqli_query($koneksi, "SELECT `pengerjaan_ke`, `total_harga` FROM `data_pemesanan` WHERE `id_pemesanan` = '$idPemesanan'"),
						MYSQLI_BOTH
					);
					$pengerjaanKe 		= (int) $pemesanan['pengerjaan_ke'];
					$persetujuanBelum 	= getPersetujuanPelangganTerakhir($idPemesanan, 'belum');
					// if ((($persetujuanBelum === FALSE OR $persetujuanBelum === TRUE) AND $pengerjaanKe == 0)) OR ($persetujuanBelum === FALSE AND $pengerjaanKe >= 1)) {
						$pengerjaanKe++;
					// }
					mysqli_query ($koneksi, "INSERT INTO `data_biaya_tambahan` (`id_pemesanan`, `keterangan`, `jumlah`) VALUES ('$idPemesanan', '$keterangan', '$jumlah')") or die ($koneksi);
					$biayaTambahan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `data_biaya_tambahan` WHERE `id_pemesanan` = '$idPemesanan' AND `keterangan` = '$keterangan'"), MYSQLI_BOTH);
					$itemArray = array(
						'id_pemesanan'					=> $idPemesanan,
						'jenis_pengerjaan'				=> 'biaya_tambahan',
						'id_jenis_layanan_sparepart'	=> $biayaTambahan['id_biaya_tambahan'],
						'keterangan'					=> $keterangan,
						'harga_biaya_tambahan'			=> $jumlah,
						'pengerjaan_ke' 				=> $pengerjaanKe,
						'persetujuan_pelanggan'			=> 'belum'
					);
					// print_r($itemArray);
					if (isset($_SESSION['additional_cost']) AND !empty($_SESSION['additional_cost'])) {
						// print_r($itemArray);
						array_push($_SESSION['additional_cost'], $itemArray);
					} else {
						// print_r($itemArray);
						$_SESSION['additional_cost'] = array($itemArray);
					}
				}
				array_push(
					$messages,
					array("success", "Data berhasil ditambahkan.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal ditambahkan.")
				);
			}
			$redirect = ($pengerjaanKe == 0) ? "?content=pemesanan_detail&action=konfirmasi&id=" . $idPemesanan : "?content=pemesanan_detail&action=lihat&id=" . $idPemesanan ;
			break;
		case 'edit':
			try {
				$pengerjaanKe = mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH)['pengerjaan_ke'];
				if ($idBiayaTambahan !== null and $idPemesanan !== null and $keterangan !== null and $jumlah !== null) {
					// Update keterangan dan jumlah / harga di `data_biaya_tambahan` dan `data_pemesanan_detail`
					mysqli_query($koneksi, "UPDATE `data_pemesanan_detail` SET `harga` = '$jumlah' WHERE `id_jenis_layanan_sparepart` = '$idBiayaTambahan' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
					mysqli_query($koneksi, "UPDATE `data_biaya_tambahan` SET  `keterangan` = '$keterangan', `jumlah` = '$jumlah' WHERE `id_biaya_tambahan` = '$idBiayaTambahan' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
				}
				array_push(
					$messages,
					array("success", "Data berhasil diubah.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal diubah.")
				);
			}
			$redirect = ($pengerjaanKe == 0) ? "?content=pemesanan_detail&action=konfirmasi&id=" . $idPemesanan : "?content=pemesanan_detail&action=lihat&id=" . $idPemesanan;
			break;
		case 'edit_additional_cost':
			try {
				$idArray = (isset($_POST['id_array'])) ? antiInjection($_POST['id_array']) : NULL ;
				$pengerjaanKe = mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH)['pengerjaan_ke'];
				if ($idBiayaTambahan !== NULL AND $idPemesanan !== NULL AND $keterangan !== NULL AND $jumlah !== NULL) {
					mysqli_query($koneksi, "UPDATE `data_biaya_tambahan` SET  `keterangan` = '$keterangan', `jumlah` = '$jumlah' WHERE `id_biaya_tambahan` = '$idBiayaTambahan' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
					if (!empty($_SESSION["additional_cost"])) {
						// Update keterangan dan jumlah / harga di `data_biaya_tambahan` dan `data_pemesanan_detail`
						// mysqli_query($koneksi, "UPDATE `data_biaya_tambahan` SET  `keterangan` = '$keterangan', `jumlah` = '$jumlah' WHERE `id_biaya_tambahan` = '$idBiayaTambahan' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
						$array = array_keys($_SESSION["additional_cost"]);
						for ($i = 0; $i <= end($array); $i++) {
							if ($idArray == array_keys($array)[$i]) {
								// mysqli_query($koneksi, "UPDATE `data_pemesanan_detail` SET `harga` = '$jumlah' WHERE `id_jenis_layanan_sparepart` = '$idBiayaTambahan' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
								$_SESSION["additional_cost"][$i]['keterangan']				= $keterangan;
								$_SESSION["additional_cost"][$i]['harga_biaya_tambahan']	= $jumlah;
							}
						}
					}
				}
				array_push(
					$messages,
					array("success", "Data berhasil diubah.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal diubah.")
				);
			}
			$redirect = ($pengerjaanKe == 0) ? "?content=pemesanan_detail&action=konfirmasi&id=" . $idPemesanan : "?content=pemesanan_detail&action=lihat&id=" . $idPemesanan ;
			break;
		case 'remove':
			try {
				$pengerjaanKe = mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH)['pengerjaan_ke'];
				$idPemesanan = mysqli_fetch_array(getBiayaTambahanById($id), MYSQLI_BOTH)['id_pemesanan'];
				mysqli_query($koneksi, "DELETE FROM `data_biaya_tambahan` WHERE `id_biaya_tambahan` = '$id' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
				mysqli_query($koneksi, "DELETE FROM `data_pemesanan_detail` WHERE `id_jenis_layanan_sparepart` = '$id' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
				array_push(
					$messages,
					array("success", "Data berhasil dihapus.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal dihapus.")
				);
			}
			$redirect = ($pengerjaanKe == 0) ? "?content=pemesanan_detail&action=konfirmasi&id=" . $idPemesanan : "?content=pemesanan_detail&action=lihat&id=" . $idPemesanan ;
			break;
		case 'remove_additional_cost':
			try {
				// $pengerjaanKe = mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH)['pengerjaan_ke'];
				$idPemesanan = NULL;
				// mysqli_query($koneksi, "DELETE FROM `data_biaya_tambahan` WHERE `id_biaya_tambahan` = '$id' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
				// mysqli_query($koneksi, "DELETE FROM `data_pemesanan_detail` WHERE `id_jenis_layanan_sparepart` = '$id' AND `id_pemesanan` = '$idPemesanan'") or die($koneksi);
				if (!empty($_SESSION["additional_cost"])) {
					$array = array_keys($_SESSION["additional_cost"]);
					for ($i = 0; $i <= end($array); $i++) {
						if ($id == array_keys($array)[$i]) {
							$idPemesanan = $_SESSION["additional_cost"][$i]['id_pemesanan'];
							unset($_SESSION["additional_cost"][$i]);
						}
						if (empty($_SESSION["additional_cost"])) {
							unset($_SESSION["additional_cost"]);
						}
					}
				}
				array_push(
					$messages,
					array("success", "Data berhasil dihapus.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal dihapus.")
				);
			}
			$redirect = ($pengerjaanKe == 0) ? "?content=pemesanan_detail&action=konfirmasi&id=" . $idPemesanan : "?content=pemesanan_detail&action=lihat&id=" . $idPemesanan;
			break;
		default:
			# code...
			break;
	}

	if (!empty($messages)) {
		saveNotifikasi($messages);
	}

	echo "
		<script>
			window.location.replace('$redirect');
		</script>
	";
?>