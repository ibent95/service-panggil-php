<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = (isset($_GET['id']) AND !empty($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
	} else {
		if ($proses == 'edit') {
			$id = (isset($_POST['id']) AND !empty($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		}
		$namaKategori 	= (isset($_POST['nama_kategori_layanan']) AND !empty($_POST['nama_kategori_layanan'])) ? antiInjection($_POST['nama_kategori_layanan']) : NULL ;
		$gambar 		= ($_FILES['gambar'] != NULL OR !empty($_FILES['gambar'])) ? uploadFile($_FILES['gambar'], "kategori_layanan", "img", "short") : NULL ;
		$deskripsi 		= (isset($_POST['deskripsi']) AND !empty($_POST['deskripsi'])) ? antiInjection($_POST['deskripsi']) : NULL ;
	}

	switch ($proses) {
		case 'add':
			try {
				$nameCount = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`nama_kategori_layanan`) AS `count` FROM `data_layanan_kategori` WHERE `nama_kategori_layanan` = '$namaKategori'"))['count'];
				if ($nameCount == 0) {
					mysqli_query ($koneksi, "INSERT INTO `data_layanan_kategori` (`nama_kategori_layanan`, `gambar`, `deskripsi`) VALUES ('$namaKategori', '$gambar', '$deskripsi')") or die ($koneksi);
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
				mysqli_query($koneksi, "UPDATE `data_layanan_kategori` SET `nama_kategori_layanan`	= '$namaKategori', `deskripsi` = '$deskripsi' WHERE `id_layanan_kategori` = '$id';") or die ($koneksi);
				if ($gambar != NULL | $gambar != "" | !empty($gambar)) {
					mysqli_query($koneksi, "UPDATE `data_layanan_kategori` SET `gambar` = '$gambar' WHERE `id_layanan_kategori`	= '$id'") or die ($koneksi);
				}
				$_SESSION['message-type'] = "success";
				$_SESSION['message-content'] = "Data berhasil diubah";
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_layanan_kategori` WHERE `id_layanan_kategori` = '$id'") or die ($koneksi);
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
		echo "<script>window.location.replace('?content=data_layanan_kategori');</script>";
	} else {
		echo "<script>window.history.go(-2);</script>";
	}
?>