<?php
    $proses = $_GET['proses'];
	if ($proses == 'finish' OR $proses == 'cancel' OR $proses == 'remove' or $proses == 'remove_processing') {
		$id = antiInjection($_GET ['id']);
	} else {
		if ($proses == 'edit' OR $proses == 'edit_processing') {
            $idPemesanan 	    = antiInjection($_POST['id_pemesanan']);
            $idPemesananDetail 	= antiInjection($_POST['id_pemesanan_detail']);
            $idSoftware	    	= (isset($_POST['id_software'])) ? $_POST['id_software'] : NULL ;
			$idHardware	    	= (isset($_POST['id_hardware'])) ? $_POST['id_hardware'] : NULL ;
			$idSparepart	    = (isset($_POST['id_sparepart'])) ? $_POST['id_sparepart'] : NULL ;
			$status_pemesanan 	= (isset($_POST['status_pemesanan'])) ? antiInjection($_POST['status_pemesanan']) : 'tunggu' ;
		} elseif ($proses == 'add') {
            $idPemesanan 	    = antiInjection($_POST['id']);
            $softwareAll 		= (isset($_POST['software'])) ? $_POST['software'] : NULL ;
            $hardwareAll 		= (isset($_POST['hardware'])) ? $_POST['hardware'] : NULL ;
            $sparepartAll 		= (isset($_POST['sparepart'])) ? $_POST['sparepart'] : NULL ;
        } elseif ($proses == 'confirm') {
			$idPemesanan 	    = antiInjection($_POST['id_pemesanan']);
			$statusCheckTeknisi	= $_POST['status_check_teknisi'];
		}
		$pengerjaanKe			= 1;
	}
	$totalHarga = 0;
	$messages 	= array();
    $sql		= "";
    $redirect	= "?content=pemesanan";

	switch ($proses) {
		case 'add':
			try {
				// Ambil Pengerjaan dan Total Harga
				$pemesanan = mysqli_fetch_array(
					mysqli_query($koneksi, "SELECT `pengerjaan_ke`, `total_harga` FROM `data_pemesanan` WHERE `id_pemesanan` = '$idPemesanan'"),
					MYSQLI_BOTH
				);

				$pengerjaanKe 		= (int) $pemesanan['pengerjaan_ke'];

				// Cek Status Persetujuan Pelanggan (Belum) dan Tambah Harga Jasa dan Sparepart dalam Detail Pemesanan
				$persetujuanBelum 	= FALSE;
				$persetujuanBelum	= getPersetujuanPelangganTerakhir($idPemesanan, 'belum');
				// if (($persetujuanBelum === FALSE) AND ($pengerjaanKe >= 1)) {
					$pengerjaanKe++;
				// }

				// Input tambahan Pemesanan Detail dan Tambah Harga Layanan ke Total Biaya
				if ($softwareAll != NULL) {
					for ($i=0; $i < count($softwareAll); $i++) {
						$layanan = mysqli_fetch_array(getJenisSoftwareById($softwareAll[$i]), MYSQLI_BOTH);
						// $totalHarga += $hargaLayanan;
						// mysqli_query ($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$idPemesanan', 'software', '$softwareAll[$i]', '$hargaLayanan', '$pengerjaanKe', 'belum');") or die ($koneksi);
						$itemArray = array(
							'id_pemesanan'					=> $idPemesanan,
							'jenis_pengerjaan'				=> 'software',
							'id_jenis_layanan_sparepart'	=> $softwareAll[$i],
							'nama_jenis_layanan_sparepart' 	=> $layanan['nama_jenis_layanan'],
							'harga'							=> $layanan['harga'],
							'pengerjaan_ke'					=> $pengerjaanKe,
							'persetujuan_pelanggan'			=> 'belum'
						);
						if (isset($_SESSION["processing"]) AND !empty($_SESSION["processing"])) {
							array_push($_SESSION["processing"], $itemArray);
						} else {
							$_SESSION["processing"] = array($itemArray);
						}
					}
				}
				if ($hardwareAll != NULL) {
					for ($i=0; $i < count($hardwareAll); $i++) {
						$layanan = mysqli_fetch_array(getJenisHardwareById($hardwareAll[$i]), MYSQLI_BOTH);
						// $totalHarga += $hargaLayanan;
						// mysqli_query ($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$idPemesanan', 'hardware', '$hardwareAll[$i]', '$hargaLayanan', '$pengerjaanKe', 'belum');") or die ($koneksi);
						$itemArray = array(
							'id_pemesanan'					=> $idPemesanan,
							'jenis_pengerjaan'				=> 'hardware',
							'id_jenis_layanan_sparepart'	=> $hardwareAll[$i],
							'nama_jenis_layanan_sparepart' 	=> $layanan['nama_jenis_layanan'],
							'harga' 						=> $layanan['harga'],
							'pengerjaan_ke'					=> $pengerjaanKe,
							'persetujuan_pelanggan'			=> 'belum'
						);
						if (isset($_SESSION["processing"]) AND !empty($_SESSION["processing"])) {
							array_push($_SESSION["processing"], $itemArray);
						} else {
							$_SESSION["processing"] = array($itemArray);
						}
					}
				}
				if ($sparepartAll != NULL) {
					for ($i=0; $i < count($sparepartAll); $i++) {
						$sparepart = mysqli_fetch_array(getSparepartById($sparepartAll[$i]), MYSQLI_BOTH);
						// $totalHarga += $hargaSparepart;
						// mysqli_query ($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$idPemesanan', 'sparepart', '$sparepartAll[$i]', '$hargaSparepart', '$pengerjaanKe', 'belum');") or die ($koneksi);
						$itemArray = array(
							'id_pemesanan'					=> $idPemesanan,
							'jenis_pengerjaan'				=> 'sparepart',
							'id_jenis_layanan_sparepart'	=> $sparepartAll[$i],
							'nama_jenis_layanan_sparepart' 	=> $sparepart['nama_sparepart'],
							'harga' 						=> $sparepart['harga'],
							'pengerjaan_ke'					=> $pengerjaanKe,
							'persetujuan_pelanggan'			=> 'belum'
						);
						if (isset($_SESSION["processing"]) AND !empty($_SESSION["processing"])) {
							array_push($_SESSION["processing"], $itemArray);
						} else {
							$_SESSION["processing"] = array($itemArray);
						}
					}
				}
				// print_r($_SESSION['processing']);
				// Update Teknisi Check, Iterasi Pengerjaan, dan Total Harga di Data Pemesanan
				// mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `pengerjaan_ke` = '$pengerjaanKe', `total_harga` = '$totalHarga' WHERE `id_pemesanan` = '$idPemesanan';") or die($koneksi);

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
			$redirect = ($pengerjaanKe > 0) ? "?content=pemesanan_detail&action=lihat&id=" . $idPemesanan : "?content=pemesanan_detail&action=konfirmasi&id=" . $idPemesanan ;
			break;
		case 'edit':
			try {
				$pengerjaanKe = mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH)['pengerjaan_ke'];
				$pengerjaan = array();
				if ($idSoftware != null) {
					$pengerjaan = mysqli_fetch_array(getJenisSoftwareById($idSoftware), MYSQLI_BOTH);
					$idPengerjaan = $pengerjaan['id_layanan_jenis'];
					$pengerjaan['jenis_pengerjaan'] = 'software';
				} elseif ($idHardware != null) {
					$pengerjaan = mysqli_fetch_array(getJenisHardwareById($idHardware), MYSQLI_BOTH);
					$idPengerjaan = $pengerjaan['id_layanan_jenis'];
					$pengerjaan['jenis_pengerjaan'] = 'hardware';
				} elseif ($idSparepart != null) {
					$pengerjaan = mysqli_fetch_array(getSparepartById($idSparepart), MYSQLI_BOTH);
					$idPengerjaan = $pengerjaan['id_sparepart'];
					$pengerjaan['jenis_pengerjaan'] = 'sparepart';
				}
				// print_r($pengerjaan);
				mysqli_query($koneksi, "
                    UPDATE `data_pemesanan_detail`
                    SET
                        `jenis_pengerjaan`              = '$pengerjaan[jenis_pengerjaan]',
                        `id_jenis_layanan_sparepart`    = '$idPengerjaan',
                        `harga`                         = '$pengerjaan[harga]'
					WHERE `id_pemesanan_detail`         = '$idPemesananDetail'
					AND `id_pemesanan`					= '$idPemesanan';
                ") or die($koneksi);
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
		case 'edit_processing':
			try {
				$pengerjaanKe = mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH)['pengerjaan_ke'];
				$pengerjaan 		= array();
				if ($idSoftware != NULL) {
					$pengerjaan 	= mysqli_fetch_array(getJenisSoftwareById($idSoftware), MYSQLI_BOTH);
					$idPengerjaan 	= $pengerjaan['id_layanan_jenis'];
					$pengerjaan['jenis_pengerjaan'] = 'software';
				} elseif ($idHardware != NULL) {
					$pengerjaan 	= mysqli_fetch_array(getJenisHardwareById($idHardware), MYSQLI_BOTH);
					$idPengerjaan 	= $pengerjaan['id_layanan_jenis'];
					$pengerjaan['jenis_pengerjaan'] = 'hardware';
				} elseif ($idSparepart != NULL) {
					$pengerjaan 	= mysqli_fetch_array(getSparepartById($idSparepart), MYSQLI_BOTH);
					$idPengerjaan 	= $pengerjaan['id_sparepart'];
					$pengerjaan['jenis_pengerjaan'] = 'sparepart';
				}
				if (!empty($_SESSION["processing"])) {
					$array = array_keys($_SESSION["processing"]);
					for ($i = 0; $i <= end($array); $i++) {
						if ($idPemesananDetail == array_keys($array)[$i]) {
							$_SESSION["processing"][$i]['jenis_pengerjaan'] 				= $pengerjaan['jenis_pengerjaan'];
							$_SESSION["processing"][$i]['id_jenis_layanan_sparepart']		= $idPengerjaan;
							$_SESSION["processing"][$i]['nama_jenis_layanan_sparepart'] 	= ($idSparepart != NULL) ? $pengerjaan['nama_sparepart'] : $pengerjaan['nama_jenis_layanan'];
							$_SESSION["processing"][$i]['harga'] 							= $pengerjaan['harga'];
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
					// $pengerjaanKe = mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH)['pengerjaan_ke'];
				$idPemesanan = mysqli_fetch_array(getDetailPemesananById($id), MYSQLI_BOTH)['id_pemesanan'];
				mysqli_query($koneksi, "DELETE FROM `data_pemesanan_detail` WHERE `id_pemesanan_detail` = '$id';") or die($koneksi);
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
			$redirect = "?content=pemesanan_detail&id=" . $idPemesanan;
			break;
		case 'remove_processing':
			try {
				// $pengerjaanKe = mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH)['pengerjaan_ke'];
				$idPemesanan = null;
				// mysqli_query($koneksi, "DELETE FROM `data_pemesanan_detail` WHERE `id_pemesanan_detail` = '$id';") or die($koneksi);
				if (!empty($_SESSION["processing"])) {
					$array = array_keys($_SESSION["processing"]);
					for ($i = 0; $i <= end($array); $i++) {
						if ($id == array_keys($array)[$i]) {
							$idPemesanan = $_SESSION["processing"][$i]['id_pemesanan'];
							unset($_SESSION["processing"][$i]);
						}
					}
					if (empty($_SESSION["processing"])) {
						unset($_SESSION["processing"]);
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
			$redirect = "?content=pemesanan_detail&id=" . $idPemesanan;
			break;
		case 'finish':
			try {
				mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `status_pemesanan` = 'selesai' WHERE `id_pemesanan` = '$idPemesanan';") or die($koneksi);
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
			break;
		case 'cancel':
			try {
				mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `status_pemesanan` = 'batal' WHERE `id_pemesanan` = '$idPemesanan';") or die($koneksi);
				array_push(
					$messages,
					array("success", "Data berhasil dibatalkan.")
				);
			} catch (Exception $e) {
				array_push(
					$messages,
					array("danger", "Data gagal dibatalkan.")
				);
			}
			break;
		default:
			# code...
			break;
	}

	if (!empty($messages)) {
		saveNotifikasi($messages);
	}

	echo "<script>window.location.replace('$redirect');</script>";
?>