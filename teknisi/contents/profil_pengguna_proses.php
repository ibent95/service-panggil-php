<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = $_GET ['id'];
	} else {
		if ($proses == 'edit') {
			$id = $_POST['id'];
		}
		$nama_lengkap = $_POST['nama_lengkap'];
		$username = $_POST['username'];
		// $password = (isset($_POST['password'])) ? $_POST['password'] : NULL ;
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$email = $_POST['email'];
		// $jenis_akun = $_POST['jenis_akun'];
		$url_foto = ($_FILES['url_foto'] != NULL OR !empty($_FILES['url_foto'])) ? uploadFile($_FILES['url_foto'], "/img/teknisi/") : NULL ;
		$message = array();
		// $status_akun = $_POST['status_akun'];
	}

	switch ($proses) {
		case 'add':
			try {
				if (is_array($url_foto)) {
					saveNotifikasi($url_foto);
					echo "
						<script>
							window.history.go(-1);
						</script>
					";
					// header("location:javascript://history.go(-1)");
				} else {
					mysqli_query ($koneksi, "
						INSERT INTO `data_teknisi` (
							`nama_lengkap`, 
							`username`, 
							`alamat`, 
							`no_hp`, 
							`email`, 
							`url_foto`
						) VALUES (
							'$nama_lengkap',
							'$username',
							'$alamat',
							'$no_hp',
							'$email',
							'$url_foto' 
						)
					") or die ($koneksi);
					array_push($message, array('success', 'Data berhasil ditambahkan'));
					// $_SESSION['message-type'] = "success";
					// $_SESSION['message-content'] = "Data berhasil ditambahkan";
				}
			} catch (Exception $e) {
				array_push($message, array('danger', 'Data tidak berhasil ditambahkan'));
				// $_SESSION['message-type'] = "danger";
				// $_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				if (is_array($url_foto)) {
					saveNotifikasi($url_foto);
					echo "
						<script>
							window.history.go(-1);
						</script>
					";
					// header("location:javascript://history.go(-1)");
				} else {
					mysqli_query($koneksi, "
						UPDATE `data_teknisi` 
						SET 
							`nama_lengkap`	= '$nama_lengkap',
							`username`		= '$username',
							`alamat`		= '$alamat',
							`no_hp`			= '$no_hp',
							`email`			= '$email'
						WHERE `id_teknisi`	= '$id'
					") or die ($koneksi);

					if ($url_foto != "" | $url_foto != NULL | !empty($url_foto)) {
						mysqli_query ($koneksi, "
							UPDATE `data_teknisi`
							SET 
								`url_foto` 		= '$url_foto'
							WHERE `id_teknisi` 	= '$id'
						") or die ($koneksi);
					}
					array_push($message, array('success', 'Data berhasil diubah'));
					// $_SESSION['message-type'] = "success";
					// $_SESSION['message-content'] = "Data berhasil diubah";
				}
			} catch (Exception $e) {
				array_push($message, array('danger', 'Data gagal diubah'));
				// $_SESSION['message-type'] = "danger";
				// $_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "
					DELETE FROM `data_teknisi` 
					WHERE `id_teknisi` = '$id'
				") or die ($koneksi);
				array_push($message, array('success', 'Data berhasil dihapus'));
				// $_SESSION['message-type'] = "success";
				// $_SESSION['message-content'] = "Data berhasil dihapus";
			} catch (Exception $e) {
				array_push($message, array('danger', 'Data berhasil dihapus'));
				// $_SESSION['message-type'] = "danger";
				// $_SESSION['message-content'] = "Data gagal dihapus";
			}
			break;
		case 'ganti-password':
			
			break;
		default:
			# code...
			break;
	}
	saveNotifikasi($message);
	echo "
		<script>
			location.replace('?content=profil_pengguna');
		</script>
	";
?>