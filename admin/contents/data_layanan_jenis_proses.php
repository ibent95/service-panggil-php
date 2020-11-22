<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
			$id = antiInjection($_POST['id']);
		}
		$id_kategori = antiInjection($_POST['id_kategori']);
		$nama_jenis = antiInjection($_POST['nama_jenis_layanan']);
		$harga = antiInjection($_POST['harga']);
	}

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "
					INSERT INTO `data_layanan_jenis` (`id_kategori`, `nama_jenis_layanan`, `harga`) VALUES ('$id_kategori', '$nama_jenis', '$harga')") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_layanan_jenis` SET `id_kategori` = '$id_kategori', `nama_jenis_layanan` = '$nama_jenis', `harga` = '$harga' WHERE `id_layanan_jenis` = '$id';") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_layanan_jenis` WHERE `id_layanan_jenis` = '$id'") or die ($koneksi);
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

	echo "<script>window.location.replace('?content=data_layanan_jenis');</script>";
?>