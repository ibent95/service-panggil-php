<?php 
    $proses = $_GET['proses'];
	if ($proses == 'remove') {
		$id = $_GET ['id'];
	} else {
		if ($proses == 'edit') {
			$id = $_POST['id'];
		}
		$nama_lengkap = $_POST['nama_lengkap'];
		$jk = $_POST['jk'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$id_kecamatan = $_POST['id_kecamatan'];
		$id_kelurahan = $_POST['id_kelurahan'];
		$alamat = $_POST['alamat'];
		$no_hp = $_POST['no_hp'];
		$email = $_POST['email'];
		$hak_akses = $_POST['hak_akses'];
		$status_akun = $_POST['status_akun'];
	}

	switch ($proses) {
		case 'add':
			try {
				mysqli_query ($koneksi, "
					INSERT INTO `user` (
						`nama_lengkap`, 
						`jk`, 
						`username`, 
						`password`, 
						`id_kecamatan`, 
						`id_kelurahan`, 
						`alamat`, 
						`no_hp`, 
						`email`, 
						`hak_akses`, 
						`status_akun`
					) VALUES (
						'$nama_lengkap',
						'$jk',
						'$username',
						'$password',
						'$id_kecamatan',
						'$id_kelurahan',
						'$alamat',
						'$no_hp',
						'$email',
						'$hak_akses',
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
					UPDATE `user` 
					SET 
						`nama_lengkap`	= '$nama_lengkap',
						`jk`			= '$jk',
						`username`		= '$username',
						`password`		= '$password',
						`id_kecamatan`	= '$id_kecamatan',
						`id_kelurahan`	= '$id_kelurahan',
						`alamat`		= '$alamat',
						`no_hp`			= '$no_hp',
						`email`			= '$email',
						`hak_akses`		= '$hak_akses',
						`status_akun`	= '$status_akun' 
						WHERE `id`		= '$id'
				") 		or die ($koneksi);
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
			location.replace('?content=data-pengguna-pembeli');
		</script>
	";
?>