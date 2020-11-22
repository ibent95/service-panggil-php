<?php
session_start();
include 'fungsi/koneksi.php';
include 'fungsi/upload_gambar.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$errors = array();
$pesan = array();
// Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

function no_orders() {
	global $conn;
	$q = $conn->query("SELECT COUNT(id_orders) AS nomor FROM orders WHERE MONTH(tgl_order) = '" . date('n') . "' AND YEAR(tgl_order) = '" . date('Y') . "'");
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
			$id_session = isset($_POST['id_session']) && !empty($_POST['id_session']) ? $_POST['id_session'] : '';
			$cek_keranjang = $conn->query("SELECT id_session FROM orders_temp WHERE id_session='$id_session'");

			$sql = $conn->query("SELECT * FROM kustomer WHERE username = '$username' and password = '$password'");

			if ($sql && $sql->num_rows == 1){

				$temp_id_kustomer = $sql->fetch_array();
				$id_kustomer = $temp_id_kustomer['id_kustomer'];

				$pesan['users'] = $temp_id_kustomer;
				$pesan['pesan'] = "Selamat Datang ".$temp_id_kustomer['nama_lengkap'] ;
				if ($cek_keranjang->num_rows >=1){
					$conn->query("UPDATE orders_temp SET id_kustomer = '$id_kustomer' WHERE id_session='$id_session'");
				} 
			}else{
				$pesan['error'] = "Username dan Password Salah";
			}

		break;

		case 'konfirmasi_login':

			$username 		= isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : '';
			$password 		= isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : '';

			$sql = $conn->query("SELECT * FROM kustomer WHERE username = '$username' and password = '$password'");

			if ($sql && $sql->num_rows == 1){
				$pesan['pesan'] = "Anda Berhasil Login";
				$pesan['users'] = $sql->fetch_object(); 
			}else{
				$pesan['error'] = "Username dan Password Salah";
			}

		break;

		case 'insert_order':
			$id_kustomer 			= $_POST['id_kustomer'];
			$jenis_pembayaran 		= $_POST['jenis_pembayaran'];
			$nama_bukti_pembayaran 	= $_POST['bukti_pembayaran'];
			$ongkos_kirim		= '0';

			$query_cek_stok = "SELECT * FROM kustomer,produk,orders_temp WHERE produk.id_produk = orders_temp.id_produk and kustomer.id_kustomer = orders_temp.id_kustomer and orders_temp.jumlah > produk.stok and orders_temp.id_kustomer = '$id_kustomer' order by orders_temp.id_orders_temp";
			$cek_stok = $conn->query($query_cek_stok);


			if ($cek_stok->num_rows <= 0){
				if ($jenis_pembayaran  == 'Transfer'){
					if (isset($nama_bukti_pembayaran) && !empty($nama_bukti_pembayaran)){
						$bukti = $foto_bukti.$nama_bukti_pembayaran;
					} else {
						$pesan['error'] = 'Bukti Pembayaran Belum Ada';
					}
				$status_pembayaran = 'Lunas';
				} else {
				$status_pembayaran = 'Belum Lunas';
				}

				$query = "SELECT * FROM kustomer,produk,orders_temp WHERE produk.id_produk = orders_temp.id_produk and kustomer.id_kustomer = orders_temp.id_kustomer and orders_temp.id_kustomer = '$id_kustomer' order by orders_temp.id_orders_temp";

				$query_produk_temp = $conn->query($query);

				$query_order = $query_produk_temp->fetch_assoc();

				$no_order = no_orders();

				$insert_order = $conn->query("INSERT INTO orders SET id_kustomer = '$id_kustomer',
																	bukti_pembayaran = '$bukti',
																	no_order = '$no_order',
																	jam_order = '".date('H:i:s')."',
																	tgl_order = '".date('Y-m-d')."',
																	status_pembayaran = '$status_pembayaran',
																	jenis_pembayaran = '$jenis_pembayaran',
																	biaya_kirim = '$ongkos_kirim'");
				$id_orders = $conn->insert_id;


				$query_produk_temp = $conn->query($query);

				while ($order_temp = $query_produk_temp->fetch_assoc()){
					$order_detail = $conn->query("INSERT INTO orders_detail SET id_produk = '$order_temp[id_produk]', id_orders = '$id_orders', jumlah = '$order_temp[jumlah]', harga = '$order_temp[harga]', diskon = '$order_temp[diskon]'");

					$update_stok = "UPDATE produk set stok = stok - $order_temp[jumlah] where id_produk = '$order_temp[id_produk]'";
					$update_stok = $conn->query($update_stok);              
				}

				$cek_data = "SELECT * from orders, orders_detail where orders.id_orders = orders_detail.id_orders and orders.id_kustomer = '$id_kustomer'";
				$cek_data1 = $conn->query($cek_data);

				if ($cek_data1->num_rows >=1){
					$hapus_order = $conn->query("DELETE from orders_temp where id_kustomer = '$id_kustomer'");
					$pesan['pesan'] = "Barang Akan Kami Antarkan Kerumah Anda";
				}else{
					$hapus_order = $conn->query("DELETE from orders where id_orders = '$id_orders'");
					$hapus_order = $conn->query("DELETE from orders_detail where id_orders = '$id_orders'");
					$pesan['error'] = $id_kustomer;
				}
			} else {
				$pesan['error'] ="Maaf Stok Sudah Tidak Mencukupi";
				$pesan['stok']  = $cek_stok->fetch_assoc();
			}
				
		break;

		case 'insert_keranjang':
			$id_kustomer = isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';
			$id_produk 	 = $_POST['id_produk'];
			$jumlah 	 = $_POST['jumlah'];
			$id_session	 = isset($_POST['id_session']) && !empty($_POST['id_session']) ? $_POST['id_session'] : '';
			$query_produk = $conn->query("SELECT * FROM produk WHERE id_produk = '$id_produk'");

			$rs = $query_produk->fetch_assoc();

			$query_produk_temp = $conn->query("SELECT * FROM orders_temp WHERE id_produk = '$id_produk' and id_kustomer = '$id_kustomer'");

			if ($query_produk_temp->num_rows == 1){
				$query_jumlah = $query_produk_temp->fetch_array();
				$jumlah_temp = $query_jumlah['jumlah'] + $jumlah;
				if ($jumlah_temp >= $rs['stok']){
					$stok_temp = $query_jumlah['stok_temp'];
					$jumlah = $query_jumlah['jumlah'];
				}else{
					$jumlah = $jumlah_temp;
					$stok_temp = $rs['stok'] - $jumlah_temp;
				}
				$query = "UPDATE orders_temp SET id_session = '$id_session',id_kustomer = '$id_kustomer',jumlah = '$jumlah', stok_temp = '$stok_temp', tgl_order_temp = '" .date('Y-m-d'). "', jam_order_temp = '" . date('H:i:s') . "'WHERE id_produk = '$id_produk' AND id_kustomer = '$id_kustomer'";

			}else{            
				$stok_temp = $rs['stok'] - $jumlah;
				$query = "INSERT INTO orders_temp SET id_produk = '$id_produk', id_kustomer	= '$id_kustomer',id_session 	= '$id_session',jumlah = '$jumlah', stok_temp = '$stok_temp', tgl_order_temp = '" .date('Y-m-d')."', jam_order_temp = '".date('H:i:s')."'";
			}

			$result = $conn->query($query);
			if ($result){
				$pesan['pesan'] = 'Pesanan Anda Telah Masuk Ke keranjang';
			} else {
				$pesan['errors'] = 'Maaf, Silahkan Coba Beberapa Saat Lagi';
			}
		break;

		case 'delete_keranjang':
			$id_orders_temp = $_GET['id_orders_temp'];
			$result = $conn->query("DELETE FROM orders_temp where id_orders_temp='$id_orders_temp' ");
			if ($result) {
				$pesan['pesan']='Data Berhasil di Hapus';
			} else {
				$pesan['error'] = 'Maaf Silahkan Mencoba Beberapa Saat Lagi';
			}
		
		break;

		case 'update_jumlah':
			$jumlah = $_GET['jumlah'];
			$id_orders_temp = $_GET['id_orders_temp'];
			$result = $conn->query("UPDATE orders_temp SET jumlah = '$jumlah' WHERE id_orders_temp='$id_orders_temp'");
			if ($result) {
				$pesan['pesan']='Data Berhasil di Hapus';
			} else {
				$pesan['error'] = 'Maaf Silahkan Mencoba Beberapa Saat Lagi';
			}
		break;

		case 'daftar':
			$nama_lengkap 	= isset($_POST['nama_lengkap']) && !empty($_POST['nama_lengkap']) ? $_POST['nama_lengkap'] : '';
			$alamat			= isset($_POST['alamat']) && !empty($_POST['alamat']) ? $_POST['alamat'] : '';
			$id_kota			= isset($_POST['id_kota']) && !empty($_POST['id_kota']) ? $_POST['id_kota'] : '';
			$email			= isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '';
			$telpon			= isset($_POST['telpon']) && !empty($_POST['telpon']) ? $_POST['telpon'] : '';
			$username 		= isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : '';
			$password 		= isset($_POST['password']) && !empty($_POST['password']) ? md5($_POST['password']) : '';
			$longitude		= isset($_POST['longitude']) && !empty($_POST['longitude']) ? $_POST['longitude'] : '';
			$latitude		= isset($_POST['latitude']) && !empty($_POST['latitude']) ? $_POST['latitude'] : '';
			$newnama_foto	= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';

			$cek_email = $conn->query("SELECT email FROM kustomer WHERE email = '$email'");
			$cek_telpon = $conn->query("SELECT telpon FROM kustomer WHERE telpon = '$telpon'");
			if ($cek_email->num_rows >= 1){
				$pesan['error'] = "Email Sudah di Gunakan Oleh Pendaftar Lain";
			}else if($cek_telpon->num_rows >= 1){
				$pesan['error'] = "Telpon Sudah di Gunakan Oleh Pendaftar Lain";
			}else if(empty($nama_lengkap) OR empty($alamat) OR empty($email) OR empty($telpon) OR empty($username) OR empty($password) OR empty($longitude) OR empty($latitude)){
				$pesan['error'] = "Masih Ada Data Kosong";
			}else{
				if (!empty($newnama_foto)){
					$foto = $foto_user.$newnama_foto;
				}else{
					$foto = '';
				}
			  $query = "INSERT INTO kustomer SET id_jenis_member = '1', 
										   nama_lengkap    = '$nama_lengkap', 
										   alamat          = '$alamat', 
										   id_kota		   = '$id_kota',
										   email           = '$email',
										   longitude       = '$longitude',
										   latitude        = '$latitude', 
										   foto 		   = '$foto_user$foto',
										   telpon          = '$telpon',  
										   status          = 'aktif', 
										   username 		= '$username',
										   password        = '$password', 
										   tanggal_daftar  = '" . date('Y-m-d H:i:s') . "'";
			  $result = $conn->query($query);
			  if ($result===true){
				  $pesan['pesan'] = 'Data Anda Telah Tersimpan Mohon Login Kembali';
			  }
			}
		break;

		case 'update_kustomer':

			$id_kustomer 	= isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';

			$nama_lengkap 	= isset($_POST['nama_lengkap']) && !empty($_POST['nama_lengkap']) ? $_POST['nama_lengkap'] : '';

			$id_kota			= isset($_POST['id_kota']) && !empty($_POST['id_kota']) ? $_POST['id_kota'] : '';
			$alamat			= isset($_POST['alamat']) && !empty($_POST['alamat']) ? $_POST['alamat'] : '';
			$email			= isset($_POST['email']) && !empty($_POST['email']) ? $_POST['email'] : '';
			$telpon			= isset($_POST['telpon']) && !empty($_POST['telpon']) ? $_POST['telpon'] : '';  
			$longitude		= isset($_POST['longitude']) && !empty($_POST['longitude']) ? $_POST['longitude'] : '';
			$latitude		= isset($_POST['latitude']) && !empty($_POST['latitude']) ? $_POST['latitude'] : '';
			$newnama_foto 	= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';
			$fotoidentitas 	= isset($_POST['foto_identitas']) && !empty($_POST['foto_identitas']) ? $_POST['foto_identitas'] : '';

			$cek_email = $conn->query("SELECT email FROM kustomer WHERE email = '$email'");
			$cek_telpon = $conn->query("SELECT telpon FROM kustomer WHERE telpon = '$telpon'");
			if (empty($nama_lengkap) OR empty($alamat) OR empty($email) OR empty($telpon) OR empty($longitude) OR empty($latitude)) {
				$pesan['error'] = "Masih Ada Data Kosong";
			} else {
				if ($newnama_foto != '') {
					$identitas = $foto_identitas.$newnama_foto;
				} else {
					$identitas = $fotoidentitas;
				}
				$query = "UPDATE kustomer SET nama_lengkap = '$nama_lengkap', alamat = '$alamat', id_kota = '$id_kota', foto_identitas = '$identitas', email = '$email', longitude = '$longitude', latitude = '$latitude', telpon = '$telpon', status_update = '" . date('Y-m-d H:i:s') . "' WHERE id_kustomer = '$id_kustomer'";
				$result = $conn->query($query);
				if ($result === true) {
					$pesan['pesan'] = 'Data Anda Telah Terupdate';
				}
			}
		break;

		case 'update_password':
			$id_kustomer 	= isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';
			$username 		= isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : '';
			$password 		= isset($_POST['password']) && !empty($_POST['password']) ? md5($_POST['password']) : '';
			$password_lama 		= isset($_POST['password_lama']) && !empty($_POST['password_lama']) ? md5($_POST['password_lama']) : '';

			$cek_password_lama = $conn->query("SELECT id_kustomer FROM kustomer WHERE id_kustomer = '$id_kustomer' and password = '$password_lama'");
			if ($cek_password_lama->num_rows == 0){
				$pesan['error'] = "Password Lama Anda Salah";
			}else{
			  $query = "UPDATE kustomer SET 
										   username 		= '$username',
										   password        = '$password', 
										   status_update  = '" . date('Y-m-d H:i:s') . "'
										   WHERE id_kustomer = '$id_kustomer'";
			  $result = $conn->query($query);
			  if ($result===true){
				  $pesan['pesan'] = 'Password Anda Telah di Rubah Mohon Login Kembali';
			  }else{
			  	$pesan['error'] = "Server Sedang Sibuk Mohon Coba Beberapa Saat Lagi";
			  }
			}
		break;
		case 'upload_identitas':
			$id_kustomer 	= isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';
			$newnama_foto 	= isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';
			
			if(!isset($newnama_foto) OR empty($newnama_foto)) {
				$pesan['error'] = "Anda Belum Mengisi Foto";
			} else{
			  $identitas = $foto_identitas.$newnama_foto;
			  $query = "UPDATE kustomer SET foto_identitas    = '$identitas'
										   WHERE id_kustomer = '$id_kustomer'";
			  $result = $conn->query($query);
			  if ($result===true){
			  	$pesan['pesan'] = "$identitas";
			  }else{
			  	$pesan['error'] = "Mohon Lakukan Beberapa Saat Lagi";
			  }
			}
		break;

		case 'upload_foto_profil':
			$id_kustomer = isset($_POST['id_kustomer']) && !empty($_POST['id_kustomer']) ? $_POST['id_kustomer'] : '';
			$newnama_foto = isset($_POST['newnama_foto']) && !empty($_POST['newnama_foto']) ? $_POST['newnama_foto'] : '';
			
			if (!isset($newnama_foto) OR empty($newnama_foto)) {
				$pesan['error'] = "Anda Belum Mengisi Foto";
			} else {
				if ($newnama_foto != ''){
					$foto = $foto_user.$newnama_foto;
				} else {
					$foto = '';
				}
				$query = "UPDATE kustomer SET foto = '$foto' WHERE id_kustomer = '$id_kustomer'";
				$result = $conn->query($query);
				if ($result === true) {
					$pesan['pesan'] = "Upload Foto Profil Berhasil";
				} else {
					$pesan['error'] = "Mohon Lakukan Beberapa Saat Lagi";
				}
			}
		break;

		case 'upload_gambar':
			$upload 	= isset($_GET['upload']) && !empty($_GET['upload']) ? $_GET['upload'] : '';
			if ($upload == 'upload_bukti_pembayaran'){
				$nama_file = $_FILES['file']['name'];
				UploadImage($nama_file,$folder_bukti);
			}else if ($upload == 'upload_identitas'){
				$nama_file = $_FILES['file']['name'];
				UploadImage($nama_file,$folder_identitas);
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
  $conn->close();

?>