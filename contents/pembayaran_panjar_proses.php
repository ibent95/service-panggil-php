<?php
	$proses  = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
    if ($proses == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Proses belum ditentukan..!";
        echo "<script>window.history.go(-1)</script>";
    }
    if ($proses == 'remove') {
		$id 			= antiInjection($_GET['id']);
	} else {
		// if ($proses == 'edit') {
		$id 				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
        // }
		$tglPembayaran 		= date('Y-m-d');
		$buktiPembayaran 	= (isset($_FILES['bukti_pembayaran'])) ? uploadFile($_FILES['bukti_pembayaran'], 'bukti_pembayaran', 'img', 'short') : NULL ;
		$jumlah 			= $_POST['jumlah'];
		$infoPembayaran 	= "panjar";
		$statusPemesanan	= "tunggu";
    }
    $messages   = array();
    $sql		= "";
    $redirect	= "";

    switch ($proses) {
        case 'add':
			if (isset($_POST['checkout'])) {
				try {
					mysqli_query($koneksi, "INSERT INTO `data_riwayat_pembayaran`(`tgl_pembayaran`, `id_pemesanan`, `jumlah`, `bukti_pembayaran`, `info_pembayaran`) VALUES ('$tglPembayaran', '$id', '$jumlah', '$buktiPembayaran', '$infoPembayaran')") or die(mysqli_error($koneksi));
					mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `status_pemesanan` = '$statusPemesanan' WHERE `id_pemesanan` = '$id'") or die(mysqli_error($koneksi));
					array_push(
						$messages,
						array("success", "Upload bukti pembayaran berhasil, silahkan tunggu konfirmasi dari pihak Admin..!")
					);
					$redirect = "?content=perbaikan_detail&id=$id";
					// Kirim Email
					$transaction = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
					$customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
					$technician = mysqli_fetch_array(getTeknisiById($transaction['id_teknisi']), MYSQLI_BOTH);
					sendEmail("ibnu.tuharea@stimednp.ac.id", $technician["email"], "Pengiriman bukti pembayaran panjar telah dilakukan untuk Transaksi Perbaikan " . $transaction['no_pemesanan'], "Pelanggan [" . $customer['id_pelanggan'] . "] ". $customer['nama_lengkap'] . " telah melakukan proses pengiriman bukti pembayran untuk Transaksi Perbaikan dengan nomor " . $transaction['no_pemesanan'] . " pada tanggal " . date('d/m/Y') . ". <a href='" . class_static_value::$URL_BASE. "/teknisi/?content=pemesanan'>Klik disini</a>", NULL);
					sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "Pengiriman bukti pembayaran panjar telah dilakukan untuk Transaksi Perbaikan " . $transaction['no_pemesanan'], "Pelanggan [" . $customer['id_pelanggan'] . "] ". $customer['nama_lengkap'] . " telah melakukan proses pengiriman bukti pembayran untuk Transaksi Perbaikan dengan nomor " . $transaction['no_pemesanan'] . " pada tanggal " . date('d/m/Y') . ". <a href='" . class_static_value::$URL_BASE. "/admin/?content=pemesanan'>Klik disini</a>", NULL);
					mysqli_query($koneksi, "INSERT INTO `data_notifikasi_administrator` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`) VALUES ('warning', 'Bukti Pembayaran!', 'Bukti Pembayaran Lunas telah dikirim..!');") or die($koneksi);
				} catch (Exception $e) {
					array_push(
						$messages,
						array("danger", "Upload bukti pembayaran tidak berhasil, silahkan coba lagi..!")
					);
					$redirect = "?content=profil";
				}
			}
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