<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET ['id']);
	} else {
		if ($proses == 'edit') {
			$id = antiInjection($_POST['id']);
		}
		$tanggal_pesan = (isset($_POST['tanggal_pesan'])) ? antiInjection($_POST['tanggal_pesan']) : date("Y-m-d") ;
		$id_pelanggan = antiInjection($_POST['id_pelanggan']);
		$id_kategori = antiInjection($_POST['id_kategori']);
		$tanggal_kerja = antiInjection($_POST['tanggal_kerja']);
		$longlat = antiInjection($_POST['longlat']);
		$keluhan = antiInjection($_POST['keluhan']);
		$id_teknisi = ($proses == 'edit') ? antiInjection($_POST['id_teknisi']) : 0 ;
		$status_pemesanan = ($proses == 'edit') ? antiInjection($_POST['status_pemesanan']) : 'tunggu' ;
	}
	$redirect = '?content=pemesanan';

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "
					INSERT INTO `data_pemesanan` (
						`tanggal_pesan`,
						`id_pelanggan`,
						`id_kategori`,
						`tanggal_kerja`,
						`longlat`,
						`keluhan`,
						`id_teknisi`,
						`status_pemesanan`
					) VALUES (
						'$tanggal_pesan',
						'$id_pelanggan',
						'$id_kategori',
						'$tanggal_kerja',
						'$longlat',
						'$keluhan',
						'$id_teknisi',
						'$status_pemesanan'
					)
				") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "
					UPDATE `data_pemesanan`
					SET
						`tanggal_pesan`		= '$tanggal_pesan',
						`id_pelanggan`		= '$id_pelanggan',
						`id_kategori`		= '$id_kategori',
						`tanggal_kerja`		= '$tanggal_kerja',
						`longlat`			= '$longlat',
						`keluhan`			= '$keluhan',
						`id_teknisi`		= '$id_teknisi',
						`status_pemesanan`	= '$status_pemesanan'
					WHERE `id_pemesanan`	= '$id'
				") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "
					DELETE FROM `data_pemesanan`
					WHERE `id_pemesanan` 	= '$id'
				") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil dihapus";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal dihapus";
			}
			break;
		default:
			# code...
			break;
	}

	echo "<script>window.location.replace('$redirect');</script>";
?>