<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = (isset($_GET['id']) AND !empty($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
	} else {
		if ($proses == 'edit') {
			$id = (isset($_POST['id']) AND !empty($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		}
		$idKategori 	= (isset($_POST['id_kategori']) AND !empty($_POST['id_kategori'])) ? antiInjection($_POST['id_kategori']) : NULL;
		$namaJenis 	= (isset($_POST['nama_jenis_layanan']) AND !empty($_POST['nama_jenis_layanan'])) ? antiInjection($_POST['nama_jenis_layanan']) : NULL;
		$harga 			= (isset($_POST['harga']) AND !empty($_POST['harga'])) ? antiInjection($_POST['harga']) : NULL;
		$deskripsi 		= (isset($_POST['deskripsi_jenis_layanan']) AND !empty($_POST['deskripsi_jenis_layanan'])) ? $_POST['deskripsi_jenis_layanan'] : NULL;
	}

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "INSERT INTO `data_layanan_jenis` (`id_kategori`, `sub_kategori`, `nama_jenis_layanan`, `harga`, `deskripsi_jenis_layanan`) VALUES ('$idKategori', 'Hardware', '$namaJenis', '$harga', '$deskripsi')") or die ($koneksi);
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil ditambahkan";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_layanan_jenis` SET `id_kategori` = '$idKategori', `sub_kategori` = 'Hardware', `nama_jenis_layanan` = '$namaJenis', `harga` = '$harga', `deskripsi_jenis_layanan` = '$deskripsi' WHERE `id_layanan_jenis` = '$id';") or die ($koneksi);
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

	if ($proses == 'remove') {
		echo "<script>window.location.replace('?content=data_layanan_jenis_hardware');</script>";
	} else {
		echo "<script>window.history.go(-2);</script>";
	}
?>