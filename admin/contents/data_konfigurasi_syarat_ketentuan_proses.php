<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
			$id = $_POST['id'];
		}
		$deskripsi = (isset($_POST['deskripsi_syarat_ketentuan'])) ? $_POST['deskripsi_syarat_ketentuan'] : NULL ;
		// $url_foto = ($_FILES['url_foto'] != NULL OR !empty($_FILES['url_foto'])) ? uploadFile($_FILES['url_foto'], 'pengguna', 'img', 'short') : NULL ;
	}
	$messages = array();
	$redirect = '?content=data_konfigurasi_syarat_ketentuan';

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "
					INSERT INTO `data_konfigurasi_syarat_ketentuan` (
						`deskripsi_syarat_ketentuan`
					) VALUES (
						'$deskripsi'
					)
				") or die ($koneksi);
				array_push($messages, array('success', 'Data berhasil ditambahkan'));
			} catch (Exception $e) {
				array_push($messages, array('danger', 'Data tidak berhasil ditambahkan'));
			}
			break;
		case 'edit':
			try {
				mysqli_query($koneksi, "UPDATE `data_konfigurasi_syarat_ketentuan` SET `deskripsi_syarat_ketentuan` = '$deskripsi' WHERE `id_konfigurasi_syarat_ketentuan`	= '$id'") or die ($koneksi);
				// if ($url_foto != "" | $url_foto != NULL | !empty($url_foto)) {
				// 	mysqli_query ($koneksi, "
				// 		UPDATE `data_konfigurasi_syarat_ketentuan` 
				// 		SET `url_foto` 		= '$url_foto' 
				// 		WHERE `id_konfigurasi_syarat_ketentuan` = '$id'
				// 	") or die ($koneksi);
				// }
				array_push($messages, array('success', 'Data berhasil diubah'));
			} catch (Exception $e) {
				array_push($messages, array('danger', 'Data gagal diubah'));
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "DELETE FROM `data_konfigurasi_syarat_ketentuan` WHERE `id_konfigurasi_syarat_ketentuan` = '$id'") or die ($koneksi);
				array_push($messages, array('success', 'Data berhasil dihapus'));
			} catch (Exception $e) {
				array_push($messages, array('danger', 'Data gagal dihapus'));
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