<?php
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
    $proses 				= (isset($_GET['proses'])) ? antiInjection($_GET['proses']) : NULL ;
    $user 					= (isset($_GET['user'])) ? antiInjection($_GET['user']) : NULL ;
	if ($proses == NULL | $user == NULL) {
		$_SESSION['message-type'] 		= "danger";
		$_SESSION['message-content'] 	= "Proses dan Jenis User belum ditentukan..!";
		echo "
			<script>
				window.location.replace('login.php');
			</script>
		";
	}
	if ($proses == 'remove') {
		$id 				= antiInjection($_GET['id']);
	} else {
		if ($proses == 'register') {
			$nama_lengkap 	= (isset($_POST['nama_lengkap'])) ? antiInjection($_POST['nama_lengkap']) : null;
			$no_hp 			= (isset($_POST['no_hp'])) ? antiInjection($_POST['no_hp']) : null;
			$email 			= (isset($_POST['email'])) ? antiInjection($_POST['email']) : null;
			$alamat 		= (isset($_POST['alamat'])) ? antiInjection($_POST['alamat']) : null;
			$url_foto 		= (isset($_FILES['url_foto'])) ? uploadFile($_FILES['url_foto'], $user, "img", "short") : null;
			$status_akun 	= "blokir";
		}
		$username 			= antiInjection($_POST['username']);
		$password 			= md5(antiInjection($_POST['password']));
		$sql 				= "";
	}
    $messages   = array();
    $sql		= "";
	$redirect = class_static_value::$URL_BASE;

	switch ($proses) {
		case 'login':
			if ($user == 'pelanggan') {
				$sql .= "SELECT * FROM `data_pelanggan` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif' ";
			} elseif ($user == 'teknisi') {
				$sql .= "SELECT * FROM `data_teknisi` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif' ";
			} elseif ($user == 'pengguna') {
				$sql .= "SELECT * FROM `data_pengguna` WHERE `username` = '$username' AND `password` = '$password' AND `status_akun` = 'aktif' ";
			}
			try {
				$result = mysqli_query($koneksi, $sql) or die ($koneksi);
				if (mysqli_num_rows($result) == 0) {
					$_SESSION['message-type'] 		= "danger";
					$_SESSION['message-content'] 	= "Maaf, username atau password salah..!";
					echo "
						<script>
							window.history.go(-1);
						</script>
					";
				} elseif (mysqli_num_rows($result) == 1) {
					$data = mysqli_fetch_array($result, MYSQLI_BOTH);
					// $_SESSION['id'] 				= $data[0];
					$_SESSION['nama_lengkap'] 		= $data['nama_lengkap'];
					$_SESSION['no_hp'] 				= $data['no_hp'];
					$_SESSION['email'] 				= $data['email'];
					$_SESSION['alamat'] 			= $data['alamat'];
					$_SESSION['username'] 			= $data['username'];
					$_SESSION['password'] 			= $data['password'];
					$_SESSION['url_foto'] 			= $data['url_foto'];

					if ($user == 'pelanggan') {
						$_SESSION['id'] 			= $data['id_pelanggan'];
						$_SESSION['jenis_akun'] 	= 'pelanggan';
					} elseif ($user == 'teknisi') {
						$_SESSION['id'] 			= $data['id_teknisi'];
						$_SESSION['jenis_akun'] 	= 'teknisi';
					} elseif ($user == 'pengguna') {
						$_SESSION['id'] 			= $data['id_pengguna'];
						$_SESSION['jenis_akun'] 	= $data['jenis_akun'];
					}

					$_SESSION['logged-in']			= TRUE;

					$redirect = ($_SESSION['jenis_akun'] == 'pelanggan') ? class_static_value::$URL_BASE : class_static_value::$URL_BASE . "/$_SESSION[jenis_akun]/";

					$_SESSION['message-type'] 		= "success";
					$_SESSION['message-content'] 	= "Anda berhasil login..!";
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Maaf, username atau password salah..!";
			}
			break;
		case 'register':
			try {
				if ($user == "pelanggan") {
					if (mysqli_num_rows(mysqli_query($koneksi, "SELECT `email` FROM `data_pelanggan` WHERE `email` = '$email'")) == 0) {
						$token = generateToken();
						mysqli_query($koneksi, "INSERT INTO `data_pelanggan` (`nama_lengkap`, `no_hp`, `email`, `alamat`, `username`, `password`, `url_foto`, `status_akun`, `user_token`) VALUES ('$nama_lengkap', '$no_hp', '$email', '$alamat', '$username', '$password', '$url_foto', '$status_akun', '$token')") or die($koneksi);
	                    array_push($messages, array("success", "Pendaftaran berhasil dilakukan, silahkan lakukan verifikasi email untuk mengaktifkan akun anda..!"));
	                    $customer = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` WHERE `email` = '$email' AND `username` = '$username' AND `user_token` = '$token' "), MYSQLI_BOTH);
						sendEmail("ibnu.tuharea@stimednp.ac.id", $email, "Verifikasi akun Service Makassar.", "Anda telah mendaftar di layanan Service Makassar. Untuk mengaktifkan akun anda sebagai Pelanggan [" . $nama_lengkap . "], silahkan akses ling berikut <a href='" . class_static_value::$URL_BASE. "/?content=authentication_proses&proses=confirm_account&user_id=" . $customer['id_pelanggan'] . "&email=" . $customer['email'] . "&token=" . $token . "'>Klik disini</a>.", NULL);
					} else {
						$_SESSION['message-type'] = "danger";
						$_SESSION['message-content'] = "Pendaftaran tidak berhasil dilakukan, email yang anda masukan sudah digunakan untuk akun lain. Silahkan gunakan email lain..!";
						// array_push($messages, array("danger", "Pendaftaran tidak berhasil dilakukan, email yang anda masukan sudah digunakan untuk akun lain. Silahkan gunakan email lain..!"));
						echo "<script>window.history.go(-1);</script>";
					}
				} elseif ($user == "teknisi") {
					mysqli_query($koneksi, "INSERT INTO `data_teknisi` (`nama_lengkap`, `no_hp`, `email`, `alamat`, `username`, `password`, `url_foto`, `status_akun`) VALUES ('$nama_lengkap', '$no_hp', '$email', '$alamat', '$username', '$password', '$url_foto', '$status_akun')") or die($koneksi);
                    $_SESSION['message-type'] = "success";
                    $_SESSION['message-content'] = "Anda berhasil mendaftar..!";
				}
			} catch (Exception $e) {
				$_SESSION['message-type'] = "danger";
				$_SESSION['message-content'] = "Pendaftaran gagal dilakukan. Silahkan coba lagi..!";
			}
			break;

		case 'logout':
			session_destroy();
			$_SESSION['message-content'] = 'Logout berhasil..!';
			$_SESSION['message-type'] = 'success ';
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