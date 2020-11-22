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
		$password = (isset($_POST['password'])) ? md5($_POST['password']) : "" ;
		// $id_kecamatan = $_POST['id_kecamatan'];
		// $id_kelurahan = $_POST['id_kelurahan'];
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$email = $_POST['email'];
		// $hak_akses = $_POST['hak_akses'];
		$status_akun = $_POST['status_akun'];

		$file_foto = uploadFile($_FILES['url_foto'], "img/pelanggan");
	}

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "
					INSERT INTO `data_pelanggan` (
						`nama_lengkap`, 
						`no_hp`, 
						`email`, 
						`alamat`, 
						`username`, 
						`password`, 
						`url_foto`, 
						`status_akun`
					) VALUES (
						'$nama_lengkap',
						'$no_hp',
						'$email',
						'$alamat',
						'$username',
						'$password',
						'$file_foto',
						'$status_akun'
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
					UPDATE `data_pelanggan` 
					SET 
						`nama_lengkap`	= '$nama_lengkap', 
						`no_hp`			= '$no_hp', 
						`email`			= '$email', 
						`alamat`		= '$alamat', 
						`username`		= '$username', 
						`status_akun`	= '$status_akun'
					WHERE `id`			= '$id'
				") or die ($koneksi);
				if ($password != NULL | $password != "" | !empty($password)) {
					mysqli_query($koneksi, "
						UPDATE `data_pelanggan` 
						SET 
							`password` = '$password'
						WHERE `id` = '$id'
					") or die ($koneksi);
				}
				if ($file_foto != NULL | $file_foto != "" | !empty($file_foto)) {
					mysqli_query($koneksi, "
						UPDATE `data_pelanggan` 
						SET 
							`url_foto` = '$file_foto'
						WHERE `id` = '$id'
					") or die ($koneksi);
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
				mysqli_query($koneksi, "
					DELETE FROM `data_pelanggan` 
					WHERE `id` = '$id'
				") 
					or die ($koneksi);
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

	// echo "
	// 	<script>
	// 		location.replace('?content=data_pengguna_pelanggan');
	// 	</script>
	// ";
?>