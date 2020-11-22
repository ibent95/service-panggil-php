<?php
// session_start();
error_reporting(0);
include '../functions/class_static_value.php';
    $csv = new class_static_value();
include '../functions/koneksi.php';

function cek_status($id_pemesanan){
	global $koneksi;
	$sql = mysqli_query($koneksi,"SELECT * FROM tbl_pemesanan WHERE Id_pemesanan = '$id_pemesanan'");
	$data_sql = mysqli_fetch_assoc($sql);
	if ($data_sql['id_bengkel'] == '' ){
		cek_status($id_pemesanan);
	}else{
		return true;
	}
}
// include 'fungsi/upload_gambar.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$errors = array();
$pesan = array();
// Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

function no_orders() {
  global $koneksi;
  $q = mysqli_query($koneksi,"SELECT COUNT(id_pemesanan) AS nomor FROM data_pemesanan WHERE MONTH(tanggal_pesan) = '" . date('n') . "' AND YEAR(tanggal_pesan) = '" . date('Y') . "'");
  $c = $q->num_rows;
  
  if (!$c) {
    $no = 1;
  } else {
    $r = $q->fetch_assoc();
    $no = $r['nomor'] + 1;
  }  
  return date('m') . date('y') . $no;
}
$aksi= isset($_GET['aksi']) && !empty($_GET['aksi']) ? $_GET['aksi'] : '';

	switch ($aksi) {
		case 'login':
			$username = $_POST['username'];
			$password = md5($_POST['password']);

			$sql = mysqli_query($koneksi,"SELECT * FROM data_pelanggan WHERE email = '$username' and password = '$password'") or die(mysqli_error($koneksi));
			if ($sql && mysqli_num_rows($sql) == 1){
				$temp_id_kustomer = mysqli_fetch_assoc($sql);
				$id_kustomer = $temp_id_kustomer['id_pelanggan'];

				$pesan['users'] = $temp_id_kustomer;
				$pesan['pesan'] = "Selamat Datang ".$temp_id_kustomer['nama_lengkap'] ;
			}else{
				$pesan['error'] = "Username Atau Password anda Salah";
			}
		break;
		

		case 'batal_order':
			$id_pemesanan = isset($_POST['id_pemesanan']) && !empty($_POST['id_pemesanan']) ? $_POST['id_pemesanan'] : '';

			$result = mysqli_query($koneksi,"UPDATE tbl_pemesanan SET status='Batal' where Id_pemesanan='$id_pemesanan' ");
			if ($result){
				$pesan['pesan']='Orderan Telah di Batalkan';
			}else{
			  	$pesan['error'] = 'Mohon Coba Beberapa Saat lagi';
	        }
		
		break;

		case 'selesai_order':
			$id_pemesanan = isset($_POST['Id_pemesanan']) && !empty($_POST['Id_pemesanan']) ? $_POST['Id_pemesanan'] : '';

			$result = mysqli_query($koneksi,"UPDATE tbl_pemesanan SET status='Selesai' where Id_pemesanan='$id_pemesanan' ");
			if ($result){
				$pesan['pesan']='Orderan Telah Selesai';
			}else{
			  	$pesan['error'] = 'Mohon Coba Beberapa Saat lagi';
	        }
		
		break;

		case 'cek_pesanan':
			$id_pemesanan = isset($_POST['id_pemesanan']) && !empty($_POST['id_pemesanan']) ? $_POST['id_pemesanan'] : '';
			;

			$result1 = mysqli_query($koneksi,"SELECT * FROM tbl_pemesanan  where Id_pemesanan='$id_pemesanan'");
			$result = mysqli_fetch_assoc($result1);
			if ( ($result['status'] == 'Proses') && (!empty($result['id_bengkel']))){
				$pesan['pesan']='Data Berhasil di Hapus';
			}else{
			  	$pesan['error'] = 'Maaf Silahkan Mencoba Beberapa Saat Lagi';
	        }
		break;


		case 'delete_mobil':
			$id_mobil_costumer = $_GET['id'];
			$result = mysqli_query($koneksi,"DELETE FROM tbl_mobil_costumer where id_mobil_costumer='$id_mobil_costumer' ");
			if ($result){
				$pesan['pesan']='Data Berhasil di Hapus';
			}else{
			  	$pesan['error'] = 'Maaf Silahkan Mencoba Beberapa Saat Lagi';
	        }
		
		break;

		case 'daftar':
			$nama 			= isset($_POST['nama']) && !empty($_POST['nama']) ? $_POST['nama'] : '';
			$alamat			= isset($_POST['alamat']) && !empty($_POST['alamat']) ? $_POST['alamat'] : '';
			$email			= isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '';
			$no_telp			= isset($_POST['no_telp']) && !empty($_POST['no_telp']) ? $_POST['no_telp'] : '';
			$password 		= isset($_POST['password']) && !empty($_POST['password']) ? md5($_POST['password']) : '';
			// $newnama_foto		= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';

			$cek_email = mysqli_query($koneksi,"SELECT email FROM data_pelanggan WHERE email = '$email'");
			$cek_telpon = mysqli_query($koneksi,"SELECT no_hp FROM data_pelanggan WHERE no_hp = '$no_telp'");
			if (mysqli_num_rows($cek_email) >= 1){
				$pesan['error'] = "Email Sudah di Gunakan Oleh Pendaftar Lain";
			}else if(mysqli_num_rows($cek_telpon) >= 1){
				$pesan['error'] = "Telpon Sudah di Gunakan Oleh Pendaftar Lain";
			}else if(empty($nama) OR empty($alamat) OR empty($email) OR empty($no_telp) OR empty($password)){
				$pesan['error'] = "Masih Ada Data Kosong";
			}else{
				// if (!empty($newnama_foto)){
				// 	$foto = $foto_user.$newnama_foto;
				// }else{
				// 	$foto = '';
				// }
			  $query = "INSERT INTO data_pelanggan SET  
			                               nama_lengkap		= '$nama', 
			                               no_hp          = '$no_telp', 
			                               email		   	= '$email',
			                               alamat       	= '$alamat',
			                               password        	= '$password', 
			                               status_akun		= 'aktif',		                               
			                               tgl_daftar        = '" . date('Y-m-d H:i:s') . "'";
			  $result = mysqli_query($koneksi,$query);
			  if ($result===true){
			      $pesan['pesan'] = 'Data Anda Telah Tersimpan Mohon Login Kembali';
			  }
			}
		break;

		case 'pemesanan':
			$id_pelanggan		= isset($_POST['id_pelanggan']) && !empty($_POST['id_pelanggan']) ? $_POST['id_pelanggan'] : '';
			$id_layanan_kategori 			= isset($_POST['id_layanan_kategori']) && !empty($_POST['id_layanan_kategori']) ? $_POST['id_layanan_kategori'] : '';
			$id_layanan_jenis 			= isset($_POST['id_layanan_jenis']) && !empty($_POST['id_layanan_jenis']) ? $_POST['id_layanan_jenis'] : '';
			$lokasi				= isset($_POST['lokasi']) && !empty($_POST['lokasi']) ? $_POST['lokasi'] : '';
			$keluhan	= isset($_POST['keluhan']) && !empty($_POST['keluhan']) ? $_POST['keluhan'] : '';
			// $keluhan	= isset($_POST['keluhan']) && !empty($_POST['keluhan']) ? $_POST['id_mobil_costumer'] : '';

			// $newnama_foto		= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';

			if(empty($id_pelanggan) OR empty($lokasi) OR empty($keluhan) OR empty($id_layanan_kategori)){
				$pesan['error'] = "Masih Ada Data Kosong";
			}else{
				// if (!empty($newnama_foto)){
				// 	$foto = $foto_user.$newnama_foto;
				// }else{
				// 	$foto = '';
				// }
				$no_order = no_orders();
			  $query = "INSERT INTO data_pemesanan SET  
			                               id_pelanggan		= '$id_pelanggan', 
			                               no_pemesanan		= '$no_order', 
			                               id_kategori 		= '$id_layanan_kategori',
			                               datang_ke_lokasi	= 'ya',
			                               longlat			= '$lokasi', 
			                               keluhan			= '$keluhan',                             
			                               tanggal_pesan    = '" . date('Y-m-d H:i:s') . "'";
			  $result = mysqli_query($koneksi,$query);
			  if ($result===true){
			      $pesan['pesan'] = 'Selamat Orderan Berhasil di Kirim';
			      // $pesan['id_pemesanan'] = mysqli_insert_id($koneksi);
			  }else{
			  	$pesan['error'] = "Silahkan Coba Beberapa Saat Lagi";
			  }
			}
		break;

		case 'feedback':
			$feedbackn 			= isset($_POST['feedbackn']) && !empty($_POST['feedbackn']) ? $_POST['feedbackn'] : '0';
			$komentar			= isset($_POST['komentar']) && !empty($_POST['komentar']) ? $_POST['komentar'] : '';
			$id_bengkel			= isset($_POST['id_bengkel']) && !empty($_POST['id_bengkel']) ? $_POST['id_bengkel'] : '';
			$id_kustomer			= isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';

			if(empty($id_bengkel) OR empty($id_kustomer) OR empty($komentar)){
				$pesan['error'] = "Masih Ada Data Kosong";
			}else{
			  $query = "INSERT INTO tbl_feedback SET  
			                               id_bengkel    		= '$id_bengkel', 
			                               id_kustomer  		= '$id_kustomer', 
			                               feedback				= '$feedbackn', 
			                               komentar				= '$komentar',                               
			                               tgl_feedback        = '" . date('Y-m-d H:i:s') . "'";
			  $result = mysqli_query($koneksi,$query);
			  if ($result===true){
			      $pesan['pesan'] = 'Terima Kasih Telah Memberikan Feedback';
			      $pesan['id_pemesanan'] = mysqli_insert_id($koneksi);
			  }else{
			  	$pesan['error'] = mysqli_error($koneksi);
			  }
			}
		break;

		// case 'simpan_mobil':
		// 	$no_plat 			= isset($_POST['no_plat']) && !empty($_POST['no_plat']) ? $_POST['no_plat'] : '';
		// 	$id_kustomer			= isset($_POST['Id_costumer']) && !empty($_POST['Id_costumer']) ? $_POST['Id_costumer'] : '';
		// 	$no_rangka			= isset($_POST['no_rangka']) && !empty($_POST['no_rangka']) ? $_POST['no_rangka'] : '';
		// 	$no_mesin			= isset($_POST['no_mesin']) && !empty($_POST['no_mesin']) ? $_POST['no_mesin'] : '';
		// 	$id_type_mobil			= isset($_POST['id_type_mobil']) && !empty($_POST['id_type_mobil']) ? $_POST['id_type_mobil'] : '';
		// 	$id_merek_mobil			= isset($_POST['id_merek_mobil']) && !empty($_POST['id_merek_mobil']) ? $_POST['id_merek_mobil'] : '';
		// 	// $newnama_foto		= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';
		// 	$cek_mobil = mysqli_query($koneksi,"SELECT id_costumer FROM tbl_mobil_costumer WHERE (no_plat = '$no_plat' or no_rangka = '$no_rangka' or no_mesin = '$no_mesin') and id_merekmobil = '$id_merek_mobil' and id_tipe_mobil = '$id_type_mobil' and id_costumer = '$id_kustomer'");

		// 	if(empty($no_plat) OR empty($id_kustomer) OR empty($no_rangka) OR empty($no_mesin) OR empty($id_type_mobil) OR empty($id_merek_mobil)){
		// 		$pesan['error'] = "Masih Ada Data Kosong";
		// 	}else{
		// 		// if (!empty($newnama_foto)){
		// 		// 	$foto = $foto_user.$newnama_foto;
		// 		// }else{
		// 		// 	$foto = '';
		// 		// }

		// 	  $query = "INSERT INTO tbl_mobil_costumer SET  
		// 	                               id_costumer		= '$id_kustomer', 
		// 	                               no_rangka          = '$no_rangka', 
		// 	                               id_merekmobil		   	= '$id_merek_mobil',
		// 	                               id_tipe_mobil       	= '$id_type_mobil',
		// 	                               no_mesin        	= '$no_mesin', 		                               
		// 	                               no_plat        = '$no_plat'";
		// 	  $result = mysqli_query($koneksi,$query);
		// 	  if ($result===true){
		// 	      $pesan['pesan'] = 'Data Anda Telah Tersimpan';
		// 	  }else{

		// 	      $pesan['error'] = 'Data Gagal Tersimpan Mohon Ulangi Beberapa Saat Lagi';
		// 	  }
		// 	}
		// break;



		case 'update_kustomer':

			$id_kustomer 	= isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';

			$nama_lengkap 	= isset($_POST['nama_lengkap']) && !empty($_POST['nama_lengkap']) ? $_POST['nama_lengkap'] : '';
			$username 	= isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : '';

			$id_kota			= isset($_POST['id_kota']) && !empty($_POST['id_kota']) ? $_POST['id_kota'] : '';
			$alamat			= isset($_POST['alamat']) && !empty($_POST['alamat']) ? $_POST['alamat'] : '';
			$email			= isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '';
			$telpon			= isset($_POST['telpon']) && !empty($_POST['telpon']) ? $_POST['telpon'] : '';  
			$longitude		= isset($_POST['longitude']) && !empty($_POST['longitude']) ? $_POST['longitude'] : '';
			$latitude		= isset($_POST['latitude']) && !empty($_POST['latitude']) ? $_POST['latitude'] : '';
			$newnama_foto 	= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';
			$fotoidentitas 	= isset($_POST['foto_identitas']) && !empty($_POST['foto_identitas']) ? $_POST['foto_identitas'] : '';

			$cek_email = mysqli_query($koneksi,"SELECT email FROM kustomer WHERE email = '$email'");
			$cek_telpon = mysqli_query($koneksi,"SELECT telpon FROM kustomer WHERE telpon = '$telpon'");
			if(empty($nama_lengkap) OR empty($alamat) OR empty($email) OR empty($telpon) OR empty($longitude) OR empty($latitude)){
				$pesan['error'] = "Masih Ada Data Kosong";
			}else{
				if ($newnama_foto != ''){
			  		$identitas = $foto_identitas.$newnama_foto;
				}else{
					$identitas = $fotoidentitas;
				}
			  $query = "UPDATE data_pelanggan SET 
			  							   nama_lengkap		= '$nama', 
			                               no_hp          = '$no_telp', 
			                               email		   	= '$email',
			                               alamat       	= '$alamat',
			                               username 		= '$username',
			                               password        	= '$password', 
			                               status_akun		= 'aktif'	
			                               tgl_update  = '" . date('Y-m-d H:i:s') . "'
			                               WHERE id_pelanggan = '$id_pelanggan'";
			  $result = mysqli_query($koneksi,$query);
			  if ($result===true){
			      $pesan['pesan'] = 'Data Anda Telah Terupdate';
			  }
			}
		break;

		case 'update_password':
			$id_pelanggan 	= isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';
			$username 		= isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : '';
			$password 		= isset($_POST['password']) && !empty($_POST['password']) ? md5($_POST['password']) : '';
			$password_lama 		= isset($_POST['password_lama']) && !empty($_POST['password_lama']) ? md5($_POST['password_lama']) : '';

			$cek_password_lama = mysqli_query($koneksi,"SELECT id_pelanggan FROM data_pelanggan WHERE id_pelanggan = '$id_pelanggan' and password = '$password_lama'");
			if ($cek_password_lama->num_rows == 0){
				$pesan['error'] = "Password Lama Anda Salah";
			}else{
			  $query = "UPDATE data_pelanggan SET 
			                               username 		= '$username',
			                               password        = '$password', 
			                               tgl_update  = '" . date('Y-m-d H:i:s') . "'
			                               WHERE id_pelanggan = '$id_kustomer'";
			  $result = mysqli_query($koneksi,$query);
			  if ($result===true){
			      $pesan['pesan'] = 'Password Anda Telah di Rubah Mohon Login Kembali';
			  }else{
			  	$pesan['error'] = "Server Sedang Sibuk Mohon Coba Beberapa Saat Lagi";
			  }
			}
		break;
		// case 'upload_identitas':
		// 	$id_kustomer 	= isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';
		// 	$newnama_foto 	= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';
			
		// 	if(!isset($newnama_foto) OR empty($newnama_foto)) {
		// 		$pesan['error'] = "Anda Belum Mengisi Foto";
		// 	} else{
		// 	  $identitas = $foto_identitas.$newnama_foto;
		// 	  $query = "UPDATE kustomer SET foto_identitas    = '$identitas'
		// 	                               WHERE id_kustomer = '$id_kustomer'";
		// 	  $result = mysqli_query($koneksi,$query);
		// 	  if ($result===true){
		// 	  	$pesan['pesan'] = "$identitas";
		// 	  }else{
		// 	  	$pesan['error'] = "Mohon Lakukan Beberapa Saat Lagi";
		// 	  }
		// 	}
		// break;

		case 'upload_foto_profil':
			$id_kustomer 	= isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';
			$newnama_foto 	= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';
			
			if(!isset($newnama_foto) OR empty($newnama_foto)) {
				$pesan['error'] = "Anda Belum Mengisi Foto";
			} else{
				if ($newnama_foto != ''){
			  		$foto = $foto_user.$newnama_foto;
				}else{
					$foto = '';
				}
			  $query = "UPDATE kustomer SET foto    = '$foto'
			                               WHERE id_kustomer = '$id_kustomer'";
			  $result = mysqli_query($koneksi,$query);
			  if ($result===true){
			  	$pesan['pesan'] = "Upload Foto Profil Berhasil";
			  }else{
			  	$pesan['error'] = "Mohon Lakukan Beberapa Saat Lagi";
			  }
			}
		break;

		case 'upload_gambar':
			$upload 	= isset($_GET['upload']) && !empty($_GET['upload']) ? $_GET['upload'] : '';
			if ($upload == 'upload_bukti_pembayaran'){
				$newnama_fotoile = $_FILES['file']['name'];
				UploadImage($nama_file,$folder_bukti);
			// }else if ($upload == 'upload_identitas'){
			// 	$nama_file = $_FILES['file']['name'];
			// 	UploadImage($nama_file,$folder_identitas);
			}elseif($upload = 'upload_foto_profil'){
				$nama_file = $_FILES['file']['name'];
				UploadImage($nama_file,$folder_user);
			}
			if(!empty(basename($_FILES['file']['name']))) {
				$data['pesan']='Berhasil';
			} else{
				$data['errors']='Gagal';
			}
		break;
		default:
		break;
	}

  echo json_encode($pesan);
  
  // print_r($pesan);
  // $conn->close();

?>