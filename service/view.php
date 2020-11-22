<?php
error_reporting(0);

include '../functions/class_static_value.php';
    $csv = new class_static_value();
include '../functions/koneksi.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// $conn = new mysqli("localhost", "root", "", "tokobright");
// $api = '123454321';
// $conn = new mysqli("localhost", "root", "", "bantuin");

$data = array();
// Getting posted data and decodeing json
$_POST = json_decode(file_get_contents('php://input'), true);

$view = !empty($_GET['view']) && isset($_GET['view']) ? $_GET['view'] : '';
$data = array();
switch ($view) {
	case 'teknisi':
		$sql = mysqli_query($koneksi,"SELECT * FROM data_teknisi order by id");
		while ($d = mysqli_fetch_assoc($sql)) {
			$data[] = $d; 
		}
	break;
	// case 'search':
	// 	$cari = $_GET['cari'];
	// 	$sql = mysqli_query($koneksi,"SELECT * FROM tbl_bengkel where nma_bengkel like '%$cari%' or alamat like '%$cari%'")or die(mysqli_error($koneksi));
	// 	while ($d = mysqli_fetch_assoc($sql)) {
	// 		$ta[] = $d; 
	// 	}
	// break;

	case 'detail_teknisi':
		$id = $_GET['id'];
		$sql = mysqli_query($koneksi,"SELECT * FROM data_teknisi where id = '$id'")or die(mysqli_error($koneksi));
		while ($d = mysqli_fetch_assoc($sql)) {
			$data = $d; 
		}
	break;

	// case 'pemilik':
	// 	$id_tbl_bengkel = $_GET['id'];
	// 	$sql_temp = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM tbl_bengkel where id_tbl_bengkel = '$id_tbl_bengkel'"));

	// 	$sql = mysqli_query($koneksi,"SELECT * FROM tbl_pemilikbengkel where id_pemilikbengkel = '$sql_temp[Id_pemilikbengkel]'")or die(mysqli_error($koneksi));
	// 	while ($d = mysqli_fetch_assoc($sql)) {
	// 		$data = $d; 
	// 	}
	// break;

	// case 'mobil_kostumer':
	// 	$id_costumer = $_GET['id'];
	// 	$sql = mysqli_query($koneksi,"SELECT * FROM tbl_mobil_costumer,tbl_merekmobil,tbl_tipe where tbl_merekmobil.Id_merekmobil = tbl_tipe.id_merekmobil  and tbl_mobil_costumer.id_tipe_mobil = tbl_tipe.Id_tipemobil and  tbl_mobil_costumer.id_costumer = '$id_costumer' group by tbl_mobil_costumer.id_mobil_costumer")or die(mysqli_error($koneksi));
	// 	while ($d = mysqli_fetch_assoc($sql)) {
	// 		$data[] = $d; 
	// 	}
	// break;

	case 'layanan_kategori':
		$sql = mysqli_query($koneksi,"SELECT * FROM data_layanan_kategori order by id_layanan_kategori");
		while ($d = mysqli_fetch_assoc($sql)) {
			$data[] = $d; 
		}
	break;
	case 'layanan_jenis':
	 $id_kategori = $_GET['id_kategori'];
		$sql = mysqli_query($koneksi,"SELECT * FROM data_layanan_jenis WHERE id_kategori = '$id_kategori'  order by id_layanan_jenis");
		while ($d = mysqli_fetch_assoc($sql)) {
			$data[] = $d; 
		}
	break;

	// case 'merek_mobil':
	// 	$sql = mysqli_query($koneksi,"SELECT * FROM tbl_merekmobil");
	// 	while ($d = mysqli_fetch_assoc($sql)) {
	// 		$data[] = $d; 
	// 	}
	// break;

	// case 'type_mobil':
	// 	$Id_merekmobil = $_GET['id'];
	// 	$sql = mysqli_query($koneksi,"SELECT * FROM tbl_tipe WHERE id_merekmobil = '$Id_merekmobil'");
	// 	while ($d = mysqli_fetch_assoc($sql)) {
	// 		$data[] = $d; 
	// 	}
	// break;

	case 'feedback':
		$id_teknisi = $_GET['id_teknisi'];
		$nfeedback = $_GET['nfeedback'];
		$sql = mysqli_query($koneksi,"SELECT * FROM feedback WHERE id_teknisi = '$id_teknisi' and feedback = '$nfeedback'");
		while ($d = mysqli_fetch_assoc($sql)) {
			$data[] = $d; 
		}
	break;

	case 'history_pemesanan':
		$id_pelanggan = $_GET['id_kustomer'];
		$sql = mysqli_query($koneksi,"SELECT * FROM data_pemesanan WHERE id_pelanggan = '$id_pelanggan' order by id Desc");
		while ($d = mysqli_fetch_assoc($sql)) {
			$data[] = $d; 
		}
	break;

	case 'pemesanan':
		$id_pelanggan = $_GET['id_pelanggan'];
		$status = $_GET['status'];
		$sql = mysqli_query($koneksi,"SELECT * FROM data_pemesanan,data_pelanggan WHERE 
			data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan 
			and	data_pemesanan.id_pelanggan = '$id_pelanggan' and data_pemesanan.status_pemesanan = '$status'");
		while ($d = mysqli_fetch_assoc($sql)) {
			$data[] = $d; 
		}
	break;

	case 'detail_pemesanan':
		$id_pemesanan = $_GET['id_pemesanan'];

		$sql_pemesanan = mysqli_query($koneksi, "SELECT data_pemesanan.* FROM data_pemesanan, data_pelanggan WHERE data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan AND  data_pemesanan.id_pemesanan = '$id_pemesanan'");
		$sql_teknisi = mysqli_query($koneksi,"SELECT data_teknisi.* FROM data_pemesanan, data_teknisi WHERE data_pemesanan.id_teknisi = data_teknisi.id_teknisi AND tbl_pemesanan.id_pemesanan= '$id_pemesanan'");
		$sql_diagnosa = mysqli_query($koneksi,"SELECT data_pemesanan_detail.* FROM data_pemesanan_detail WHERE data_pemesanan_detail.id_pemesanan= '$id_pemesanan'");

		
		

		while ($d = mysqli_fetch_assoc($sql_pemesanan)) {
			$data['pemesanan'] = $d; 
		}
		if (mysqli_num_rows($sql_teknisi) > 0){
			while ($d = mysqli_fetch_assoc($sql_teknisi)) {
				$data['teknisi'] = $d; 
			}
		}
		if (mysqli_num_rows($sql_diagnosa) > 0){
			while ($d = mysqli_fetch_assoc($sql_diagnosa)) {
				$data['dpemesanan'] = $d; 
			}
		}
		// while ($d = mysqli_fetch_assoc($sql_bengkel)) {
		// 	$sql_feedback_rating = mysqli_query($koneksi,"select round(((select count(id_feedback)from feedback where id_bengkel = '$d[Id_tbl_bengkel]' and feedback = '1')/count(id_feedback))*(100/100),2) as feedback_rating from feedback where id_bengkel = '$d[Id_tbl_bengkel]'");
		// 	$sql_feedback_komentar = mysqli_query($koneksi,"select (count(id_feedback)) as feedback_komentar from feedback where id_bengkel = '$d[Id_tbl_bengkel]' and komentar <> ''");
		// 	$sql_feedback_positif = mysqli_query($koneksi,"select (count(id_feedback)) as feedback_positif from feedback where id_bengkel = '$d[Id_tbl_bengkel]' and feedback = '1'");
		// 	$sql_feedback_negatif = mysqli_query($koneksi,"select (count(id_feedback)) as feedback_negatif from feedback where id_bengkel = '$d[Id_tbl_bengkel]' and feedback = '0' ");
		// 	if (mysqli_num_rows($sql_feedback_positif) > 0) {
		// 		$d += mysqli_fetch_assoc($sql_feedback_positif); 
		// 	}
		// 	if (mysqli_num_rows($sql_feedback_negatif)  > 0) {
		// 		$d += mysqli_fetch_assoc($sql_feedback_negatif); 
		// 	}
		// 	if (mysqli_num_rows($sql_feedback_komentar) > 0) {
		// 		$d += mysqli_fetch_assoc($sql_feedback_komentar); 
		// 	}
		// 	if (mysqli_num_rows($sql_feedback_rating) > 0) {
		// 		$d += mysqli_fetch_assoc($sql_feedback_rating); 
		// 	}
		// 	$data['bengkel'] = $d; 

		// }
		while ($d = mysqli_fetch_assoc($sql_costumer)) {
			$data['costumer'] = $d; 
		}
		while ($d = mysqli_fetch_assoc($sql_mobil_costumer)) {
			$data['mobil_costumer'] = $d; 
		}
		
	break;


}
	echo json_encode($data);

	// print_r($data);

?>