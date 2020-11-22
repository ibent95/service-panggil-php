<?php
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET ['id']);
	} else {
		if ($proses == 'edit' OR $proses == 'konfirmasi_pembayaran_panjar' OR $proses == 'konfirmasi_pembayaran_lunas') {
			$id = antiInjection($_POST['id']);
		}
		// $tanggal_pesan = (isset($_POST['tanggal_pesan'])) ? antiInjection($_POST['tanggal_pesan']) : date("Y-m-d") ;
		// $id_user_pelanggan = antiInjection($_POST['id_user_pelanggan']);
		// $id_kategori = antiInjection($_POST['id_kategori']);
		// $tanggal_kerja = antiInjection($_POST['tanggal_kerja']);
		// $longlat = antiInjection($_POST['longlat']);
		// $keluhan = antiInjection($_POST['keluhan']);
		$id_teknisi 		= (isset($_POST['id_teknisi'])) ? antiInjection($_POST['id_teknisi']) : 0 ;
		$status_pemesanan 	= (isset($_POST['status_pemesanan'])) ? antiInjection($_POST['status_pemesanan']) : 'tunggu' ;
		$konfirmasi_admin 	= (isset($_POST['konfirmasi_admin'])) ? antiInjection($_POST['konfirmasi_admin']) : 'tunggu' ;
	}
	$messages = array();
	$sql = "";
	$redirect = "?content=pemesanan";

	switch ($proses) {
		case 'add':
			try {
				$namaTeknisi = mysqli_fetch_array(getTeknisiById($id_teknisi), MYSQLI_BOTH)['nama_lengkap'];
				mysqli_query ($koneksi, "INSERT INTO `data_pemesanan` (`id_teknisi`, `nama_teknisi`, `status_pemesanan`) VALUES ('$id_teknisi', '$namaTeknisi', '$status_pemesanan')") or die ($koneksi);
				array_push($messages, array( "success", "Data berhasil ditambahkan"));
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Data gagal ditambahkan"));
			}
			break;
		case 'edit':
			try {
				$teknisi = mysqli_fetch_array(getTeknisiById($id_teknisi), MYSQLI_BOTH);
				mysqli_query($koneksi, "UPDATE `data_pemesanan`SET `id_teknisi` = '$id_teknisi', `nama_teknisi` = '" . $teknisi['nama_lengkap'] . "', `status_pemesanan` = '$status_pemesanan' WHERE `id_pemesanan` = '$id'") or die ($koneksi);
				// mysqli_query($koneksi, "UPDATE `data_pemesanan`SET `id_teknisi` = '$id_teknisi', `nama_teknisi` = '" . $teknisi['nama_lengkap'] . "', `status_pemesanan` = '$status_pemesanan' WHERE `id_pemesanan` = '$id'") or die ($koneksi);
				array_push($messages, array( "success", "Data berhasil diubah"));
				// Kirim Email
				$transaksi = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
				$customer = mysqli_fetch_array(getPelangganById($transaksi['id_pelanggan']), MYSQLI_BOTH);
				$kategoriLayanan = mysqli_fetch_array(getKategoriById($transaksi['id_kategori']), MYSQLI_BOTH);
				$technician = mysqli_fetch_array(getTeknisiById($transaksi['id_teknisi']), MYSQLI_BOTH);
				sendEmail("ibnu.tuharea@stimednp.ac.id", $customer["email"], "assign_technician", array("no_pemesanan" => $transaksi['no_pemesanan'], "nama_teknisi" => $technician['nama_lengkap'], "alamat" => $technician['alamat'], "no_telp" => $technician['no_hp']), NULL);
				sendEmail("ibnu.tuharea@stimednp.ac.id", $technician["email"], "technician_transaction_in", array("tanggal" => date('d/m/Y'), "no_pemesanan" => $transaksi['no_pemesanan'], "nama_kategori_layanan" => $kategoriLayanan['nama_kategori_layanan'], "nama_pelanggan" => $customer['nama_lengkap'], "no_telp" => $transaksi['no_telp']), NULL);
				mysqli_query($koneksi, "INSERT INTO `data_notifikasi_teknisi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `id_teknisi`) VALUES ('warning', 'Baru!', 'Pemesanan Baru telah masuk..!', '$teknisi[id_teknisi]');") or die($koneksi);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Data gagal diubah"));
			}
			break;
		case 'konfirmasi_pembayaran_panjar':
			try {
				mysqli_query($koneksi, "UPDATE `data_riwayat_pembayaran` SET `konfirmasi_admin` = '$konfirmasi_admin' WHERE `id_pemesanan` = '$id' AND `info_pembayaran` = 'panjar' AND `konfirmasi_admin` != 'tidak'") or die ($koneksi);
				array_push($messages, array( "success", "Data berhasil diubah"));
				// Kirim Email
				$transaksi = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
				$pembayaran = mysqli_fetch_array(getBuktiPembayaranByIdPemesanan($id, "panjar", "DESC"), MYSQLI_BOTH);
				$customer = mysqli_fetch_array(getPelangganById($transaksi['id_pelanggan']), MYSQLI_BOTH);
				$kategoriLayanan = mysqli_fetch_array(getKategoriById($transaksi['id_kategori']), MYSQLI_BOTH);
				$technician = mysqli_fetch_array(getTeknisiById($transaksi['id_teknisi']), MYSQLI_BOTH);
				sendEmail("ibnu.tuharea@stimednp.ac.id", $customer["email"], "send_confirm_result_to_customer", array("tanggal_pembayaran" => $pembayaran['tgl_pembayaran'], "no_pemesanan" => $transaksi['no_pemesanan'], "nama_pelanggan" => $customer['nama_lengkap'], "hasil_konfirmasi" => $pembayaran['konfirmasi_admin']), NULL);
				sendEmail("ibnu.tuharea@stimednp.ac.id", $technician["email"], "send_confirm_result_to_technician", array("tanggal_pembayaran" => $pembayaran['tgl_pembayaran'], "no_pemesanan" => $transaksi['no_pemesanan'], "nama_pelanggan" => $customer['nama_lengkap'], "hasil_konfirmasi" => $pembayaran['konfirmasi_admin']), NULL);
				mysqli_query($koneksi, "INSERT INTO `data_notifikasi_teknisi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `id_teknisi`) VALUES ('warning', 'Baru!', 'Pembayaran panjar untuk Transaksi dengan no $transaksi[no_pemesanan] telah dilakukan..!', '$technician[id_teknisi]');") or die($koneksi);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Data gagal diubah"));
			}
			break;
		case 'konfirmasi_pembayaran_lunas':
			try {
				// $teknisi = mysqli_fetch_array(getTeknisiById($id_teknisi), MYSQLI_BOTH);
				mysqli_query($koneksi, "UPDATE `data_riwayat_pembayaran` SET `konfirmasi_admin` = '$konfirmasi_admin' WHERE `id_pemesanan` = '$id' AND `info_pembayaran` = 'lunas' AND `konfirmasi_admin` != 'tidak'") or die ($koneksi);
				array_push($messages, array( "success", "Data berhasil diubah"));
				// Kirim Email
				$transaksi = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
				$pembayaran = mysqli_fetch_array(getBuktiPembayaranByIdPemesanan($id, "lunas", "DESC"), MYSQLI_BOTH);
				$customer = mysqli_fetch_array(getPelangganById($transaksi['id_pelanggan']), MYSQLI_BOTH);
				$kategoriLayanan = mysqli_fetch_array(getKategoriById($transaksi['id_kategori']), MYSQLI_BOTH);
				$technician = mysqli_fetch_array(getTeknisiById($transaksi['id_teknisi']), MYSQLI_BOTH);
				sendEmail("ibnu.tuharea@stimednp.ac.id", $customer["email"], "send_confirm_result_to_customer", array("tanggal_pembayaran" => $pembayaran['tgl_pembayaran'], "no_pemesanan" => $transaksi['no_pemesanan'], "nama_pelanggan" => $customer['nama_lengkap'], "hasil_konfirmasi" => $pembayaran['konfirmasi_admin']), NULL);
				sendEmail("ibnu.tuharea@stimednp.ac.id", $technician["email"], "send_confirm_result_to_technician", array("tanggal_pembayaran" => $pembayaran['tgl_pembayaran'], "no_pemesanan" => $transaksi['no_pemesanan'], "nama_pelanggan" => $customer['nama_lengkap'], "hasil_konfirmasi" => $pembayaran['konfirmasi_admin']), NULL);
				mysqli_query($koneksi, "INSERT INTO `data_notifikasi_teknisi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `id_teknisi`) VALUES ('warning', 'Baru!', 'Pembayaran lunas untuk Transaksi dengan no $transaksi[no_pemesanan] telah dilakukan..!', '$technician[id_teknisi]');") or die($koneksi);
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Data gagal diubah"));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_pemesanan` WHERE `id_pemesanan` = '$id'") or die ($koneksi);
				array_push($messages, array( "success", "Data berhasil dihapus"));
			} catch (Exception $e) {
				array_push($messages, array( "danger", "Data gagal dihapus"));
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