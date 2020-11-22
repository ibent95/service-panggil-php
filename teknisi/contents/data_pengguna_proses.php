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
		$password = (isset($_POST['password'])) ? $_POST['password'] : NULL ;
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$email = $_POST['email'];
		$jenis_akun = $_POST['jenis_akun'];
		$url_file_foto = uploadFile($_FILES['url_file_foto'], "/img/pengguna/");

		$status_akun = $_POST['status_akun'];
	}

	switch ($proses) {
		case 'add':
			try {
				if (is_array($url_file_foto)) {
					saveNotifikasi($url_file_foto);
					echo "
						<script>
							window.history.go(-1);
						</script>
					";
					// header("location:javascript://history.go(-1)");
				} else {
					mysqli_query ($koneksi, "
						INSERT INTO `data_pengguna` (
							`nama_lengkap`, 
							`username`, 
							`password`, 
							`alamat`, 
							`no_hp`, 
							`email`, 
							`jenis_akun`, 
							`url_file_foto`, 
							`status_akun`
						) VALUES (
							'$nama_lengkap',
							'$username',
							'$password',
							'$alamat',
							'$no_hp',
							'$email',
							'$jenis_akun',
							'$url_file_foto', 
							'$status_akun'
						)
					") or die ($koneksi);
					$_SESSION['message-type'] = "success";
					$_SESSION['message-content'] = "Data berhasil ditambahkan";
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data tidak berhasil ditambahkan";
			}
			break;
		case 'edit':
			try {
				if (is_array($url_file_foto)) {
					saveNotifikasi($url_file_foto);
					echo "
						<script>
							window.history.go(-1);
						</script>
					";
					// header("location:javascript://history.go(-1)");
				} else {
					mysqli_query($koneksi, "
						UPDATE `data_pengguna` 
						SET 
							`nama_lengkap`	= '$nama_lengkap',
							`username`		= '$username',
							`alamat`		= '$alamat',
							`no_hp`			= '$no_hp',
							`email`			= '$email',
							`jenis_akun`	= '$jenis_akun',
							`status_akun`	= '$status_akun' 
						WHERE `id`			= '$id'
					") or die ($koneksi);
					if ($password != "" | $password != NULL | !empty($password)) {
						mysqli_query($koneksi, "
							UPDATE `data_pengguna` 
							SET 
								`password` = '$password'
							WHERE `id` = '$id'
						") or die ($koneksi);
					}
					if ($url_file_foto != "" | $url_file_foto != NULL | !empty($url_file_foto)) {
						mysqli_query ($koneksi, "
							UPDATE `data_pengguna`
							SET 
								`url_file_foto` = '$url_file_foto'
							WHERE `id` = '$id'
						") or die ($koneksi);
					}
					$_SESSION['message-type'] = "success";
					$_SESSION['message-content'] = "Data berhasil diubah";
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Data gagal diubah";
			}
			break;
		case 'remove':
			try {
				mysqli_query($koneksi, "
					DELETE FROM `user` 
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

	echo "
		<script>
			location.replace('?content=data_pengguna');
		</script>
	";
?>