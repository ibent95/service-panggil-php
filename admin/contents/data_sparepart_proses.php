<?php
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
			$id = antiInjection($_POST['id']);
		}
		$nama_sparepart = antiInjection($_POST['nama_sparepart']);
		$harga = antiInjection($_POST['harga']);
		$persediaan = antiInjection($_POST['persediaan']);
	}
	switch ($proses) {
		case 'add':
			try {
				$nameCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`nama_sparepart`) AS `count` FROM `data_sparepart` WHERE `nama_sparepart` = '$nama_sparepart'"))['count'];
				if ($nameCount == 0) {
					mysqli_query ($koneksi, "INSERT INTO `data_sparepart` (`nama_sparepart`, `harga`, `persediaan`) VALUES ('$nama_sparepart', '$harga', '$persediaan')") or die ($koneksi);
					$_SESSION['message-type'] = "success";
					$_SESSION['message-content'] = "Data berhasil ditambahkan";
				} else {
					$_SESSION['message-type'] = "danger";
					$_SESSION['message-content'] = "Data yang dimasukan sudah ada. Silahkan cari yang lain...";
					echo "<script>window.history.go(-1);</script>";
					break;
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_sparepart` SET `nama_sparepart` = '$nama_sparepart', `harga` = '$harga', `persediaan` = '$persediaan' WHERE `id_sparepart` = '$id';") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_sparepart` WHERE `id_sparepart` = '$id'") or die ($koneksi);
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
	echo "<script>window.location.replace('?content=data_sparepart');</script>";
?>