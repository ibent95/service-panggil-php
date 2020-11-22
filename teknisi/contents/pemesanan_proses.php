<?php 
    $proses 					= $_GET['proses'];
	if ($proses == 'finish' OR $proses == 'cancel' OR $proses == 'proccess_order' OR $proses == 'decline') {
		$id 					= antiInjection($_GET ['id']);
	} else {
		if ($proses == 'edit') {
			$id 				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$id_teknisi 		= (isset($_POST['id_teknisi'])) ? antiInjection($_POST['id_teknisi']) : 0 ;
			$status_pemesanan 	= (isset($_POST['status_pemesanan'])) ? antiInjection($_POST['status_pemesanan']) : 'tunggu' ;
		} elseif ($proses == 'confirm') {
			$idPemesanan 		= (isset($_POST['id_pemesanan'])) ? antiInjection($_POST['id_pemesanan']) : NULL ;
			$statusCheckTeknisi = (isset($_POST['status_check_teknisi'])) ? antiInjection($_POST['status_check_teknisi']) : NULL ;
		}
		$tanggal_pesan			= (isset($_POST['tanggal_pesan'])) ? antiInjection($_POST['tanggal_pesan']) : date("Y-m-d") ;
		$id_pelanggan 			= (isset($_POST['id_pelanggan'])) ? antiInjection($_POST['id_pelanggan']) : NULL ;
		$id_kategori 			= (isset($_POST['id_kategori'])) ? antiInjection($_POST['id_kategori']) : NULL ;
		$tanggal_kerja 			= (isset($_POST['tanggal_kerja'])) ? antiInjection($_POST['tanggal_kerja']) : NULL ;
		$longlat 				= (isset($_POST['longlat'])) ? antiInjection($_POST['longlat']) : NULL ;
		$keluhan 				= (isset($_POST['keluhan'])) ? antiInjection($_POST['keluhan']) : NULL ;
	}
	$messages = array();
	$sql = "";
	$redirect = "?content=pemesanan";

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_pemesanan` (`tanggal_pesan`, `id_pelanggan`, `id_kategori`, `tanggal_kerja`, `longlat`, `keluhan`, `id_teknisi`, `status_pemesanan`) VALUES ('$tanggal_pesan', '$id_pelanggan', '$id_kategori', '$tanggal_kerja', '$longlat', '$keluhan', '$id_teknisi', '$status_pemesanan')") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data pemesanan berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data pemesanan gagal ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `tanggal_pesan` = '$tanggal_pesan', `id_pelanggan` = '$id_pelanggan', `id_kategori` = '$id_kategori', `tanggal_kerja` = '$tanggal_kerja', `longlat` = '$longlat', `keluhan` = '$keluhan', `id_teknisi` = '$id_teknisi', `status_pemesanan` = '$status_pemesanan' WHERE `id_pemesanan` = '$id'") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data pemesanan berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data pemesanan gagal diubah";
			}
			break;
		case 'proccess_order' :
			try {
				mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `status_pemesanan`	= 'proses' WHERE `id_pemesanan`	= '$id'") or die($koneksi);
				mysqli_query($koneksi, "UPDATE `data_teknisi` SET `status_tersedia` = 'tidak' WHERE `id_teknisi`	= '$_SESSION[id]'") or die($koneksi);
				array_push($messages, array("success", "Transaksi berhasil diproses..!"));
				// Kirim email
				$transaction = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
				$customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
				sendEmail('ibnu.tuharea@stimednp.ac.id', $customer['email'], 'technician_processed', array('no_pemesanan' => $transaction['no_pemesanan']), NUll);
				// Untuk Admin : sendEmail('ibnu.tuharea@stimednp.ac.id', $customer['email'], 'Pengerjaan untuk Transaksi Perbaikan ' . $pemesanan['no_pemesanan'], $text, NUll);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Transaksi gagal diproses..!"));
			}
			break;
		case 'finish' :
			try {
				mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `teknisi_check` = 'selesai' WHERE `id_pemesanan` = '$id'") or die($koneksi);
				array_push($messages, array("success", "Transaksi berhasil diselesaikan..!"));
				// Kirim email
				// Kirim email
                $transaction = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
                $customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
                $technician = mysqli_fetch_array(getTeknisiById($transaction['id_teknisi']), MYSQLI_BOTH);
                sendEmail("ibnu.tuharea@stimednp.ac.id", $customer["email"], "technician_finish_workmanship", array("id_teknisi" => $technician['id_teknisi'], "nama_teknisi" => $technician['nama_lengkap'], "no_pemesanan" => $transaction['no_pemesanan'], "link" => class_static_value::$URL_BASE . "/?content=profil"), NULL);
				sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "technician_finish_workmanship", array("id_teknisi" => $technician['id_teknisi'], "nama_teknisi" => $technician['nama_lengkap'], "no_pemesanan" => $transaction['no_pemesanan'], "link" => class_static_value::$URL_BASE . "/?content=pemesanan"), NULL);
				// mysqli_query($koneksi, "INSERT INTO `data_notifikasi_teknisi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `id_teknisi`) VALUES ('warning', 'Pengerjaan Selesai!', 'Pengerjaan telah selesai..!', '$technician[id_teknisi]');") or die($koneksi);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Transaksi gagal diselesaikan..!"));
			}
			break;
		case 'confirm':
			try {
				// Ambil Pengerjaan dan Total Harga
				$pemesanan			= mysqli_fetch_array(getPemesananById($idPemesanan), MYSQLI_BOTH);
				$pengerjaanKe 		= (int) $pemesanan['pengerjaan_ke'];
				$persetujuanYa		= getPersetujuanPelangganTerakhir($idPemesanan, 'ya');
				// Tambah Biaya Tambahan ke Total Biaya
				$administrasi 		= FALSE;
				$biayaTambahan 		= getBiayaTambahanByIdPemesanan($idPemesanan);
				if (mysqli_num_rows($biayaTambahan) > 0) {
					foreach ($biayaTambahan as $data) {
						if ($data['keterangan'] === 'Biaya Admninistrasi') {
							$administrasi = TRUE;
						}
					}
				}
				// print_r($biayaTambahan);
				// Jika Pengerjaan sama dengan 1, maka Tambah Biaya Administrasi ke Biaya Tambahan dan Total Biaya
				if (($administrasi === FALSE) AND ($pengerjaanKe === 0)) {
					$biayaAdministrasi	= getKonfigurasiUmum('biaya_administrasi', 'single')['nilai_konfigurasi'];
					mysqli_query ($koneksi, "INSERT INTO `data_biaya_tambahan` (`id_pemesanan`, `keterangan`, `jumlah`) VALUES ('$idPemesanan', 'Biaya Admninistrasi', '$biayaAdministrasi');") or die ($koneksi);
					$biayaTambahan = mysqli_query($koneksi, "SELECT * FROM `data_biaya_tambahan` WHERE `id_pemesanan` = '$idPemesanan' AND `keterangan` = 'Biaya Admninistrasi'");
					if (mysqli_num_rows($biayaTambahan) > 0) {
						$biayaTambahan = mysqli_fetch_array($biayaTambahan, MYSQLI_BOTH);
						mysqli_query($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$idPemesanan', 'biaya_tambahan', '$biayaTambahan[id_biaya_tambahan]', '$biayaAdministrasi', '1', 'belum')") or die($koneksi);
					}
				}
				if (isset($_SESSION['processing'])) {
					foreach ($_SESSION["processing"] as $item) {
						if ($pengerjaanKe === 0 AND $persetujuanYa === TRUE) {
							$item['pengerjaan_ke'] = $pengerjaanKe;
						}
						mysqli_query($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$item[id_pemesanan]', '$item[jenis_pengerjaan]', '$item[id_jenis_layanan_sparepart]', '$item[harga]', '$item[pengerjaan_ke]', '$item[persetujuan_pelanggan]')") or die($koneksi);
					}
					unset($_SESSION["processing"]);
				}
				if (isset($_SESSION['additional_cost'])) {
					foreach ($_SESSION["additional_cost"] as $item) {
						// mysqli_query($koneksi, "INSERT INTO `data_biaya_tambahan` (`id_pemesanan`, `keterangan`, `jumlah`) VALUES ('$idPemesanan', '$keterangan', '$jumlah')") or die($koneksi);
						if ($pengerjaanKe === 0 AND $persetujuanYa == true) {
							$item['pengerjaan_ke'] = $pengerjaanKe;
						}
						$biayaTambahan = mysqli_query($koneksi, "SELECT * FROM `data_biaya_tambahan` WHERE `id_pemesanan` = '$idPemesanan' AND `keterangan` = '$item[keterangan]'");
						if (mysqli_num_rows($biayaTambahan) > 0) {
							$biayaTambahan = mysqli_fetch_array($biayaTambahan, MYSQLI_BOTH);
							mysqli_query($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$item[id_pemesanan]', '$item[jenis_pengerjaan]', '$item[id_jenis_layanan_sparepart]', '$item[harga_biaya_tambahan]', '$item[pengerjaan_ke]', '$item[persetujuan_pelanggan]')") or die($koneksi);
						}
					}
					unset($_SESSION["additional_cost"]);
				}
				// Ubah data yang ada di dalam tabel data_pemesanan
				mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `teknisi_check` = '$statusCheckTeknisi', `pengerjaan_ke` = '$pengerjaanKe' WHERE `id_pemesanan` = '$idPemesanan'") or die($koneksi);
				array_push($messages, array("success", "Transaksi berhasil dikonfirmasi..!"));
				// Kirim email
				$text = ($pengerjaanKe === 0) ? "
					<p>
						Perbaikan anda telah diterima oleh Teknisi. Mohon lakukan persetujuan pada pengerjaan yang diberikan oleh teknisi. <a href='" . class_static_value::$URL_BASE . "/?content=perbaikan_persetujuan_form&action=persetujuan&id=" . $idPemesanan . "'>Klik disini.</a>
					</p>
				" : "
					<p>
						Perbaikan baru dari teknisi telah diterima. Segera lakukan persetujuan pada pengerjaan tersebut. <a href='" . class_static_value::$URL_BASE . "/?content=perbaikan_persetujuan_form&action=persetujuan&id=" . $idPemesanan . "'>Klik disini.</a>
					</p>
				";
				$customer = mysqli_fetch_array(getPelangganById($pemesanan['id_pelanggan']), MYSQLI_BOTH);
				sendEmail('ibnu.tuharea@stimednp.ac.id', $customer['email'], 'Pengerjaan untuk Transaksi Perbaikan ' . $pemesanan['no_pemesanan'], $text, NUll);
				// Untuk Admin : sendEmail('ibnu.tuharea@stimednp.ac.id', $customer['email'], 'Pengerjaan untuk Transaksi Perbaikan ' . $pemesanan['no_pemesanan'], $text, NUll);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Transaksi gagal dikonfirmasi..!"));
			}
			break;
		case 'decline':
			try {
				$pemesanan = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
				$technician = mysqli_fetch_array(getTeknisiById($pemesanan['id_teknisi']), MYSQLI_BOTH);
				mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `id_teknisi` = '0', `nama_teknisi` = NULL, `status_pemesanan` = 'tunggu' WHERE `id_pemesanan` = '$id'") or die ($koneksi);
				sendEmail('ibnu.tuharea@stimednp.ac.id', 'ibnu.tuharea@stimednp.ac.id', "Transaksi Perbaikan " . $pemesanan['no_pemesanan'] . " ditolak oleh Teknisi " . $technician['nama_lengkap'], "Teknisi [" . $technician['id_teknisi'] . "] " . $technician['nama_lengkap'] . " saat ini tidak bisa menangani dan menolak Transaksi Perbaikan " . $pemesanan['no_pemesanan'] . ". Silahkan tentukan Teknisi lain yang bisa menangani transaksi tersebut. <a href='" . class_static_value::$URL_BASE . "/admin/?content=pemesanan_persetujuan&action=pilih_teknisi&id=" . $pemesanan['id_pemesanan'] . "'>Klik disini.</a>", NUll);
				array_push($messages, array("success", "Transaksi berhasil dibatalkan..!"));
				mysqli_query($koneksi, "INSERT INTO `data_notifikasi_administrator` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`) VALUES ('warning', 'Pemesanan ditolak Teknisi!', 'Pemesanan ditolak oleh Teknisi. Segera tentukan Teknisi lain..!');") or die($koneksi);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Transaksi gagal dibatalkan..!"));
			}
			break;
		case 'cancel':
			try {
				mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `status_pemesanan` = 'batal' WHERE `id_pemesanan` = '$id'") or die($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Pemesanan berhasil dibatalkan..!";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Pemesanan gagal dibatalkan..!";
			}
			break;
		case 'set_available':
			try {
				mysqli_query($koneksi, "UPDATE `data_teknisi` SET `status_tersedia` = 'ya' WHERE `id_teknisi` = '$_SESSION[id]'") or die($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Status berhasil diubah..!";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Pemesanan gagal dibatalkan..!";
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