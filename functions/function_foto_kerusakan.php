<?php
	
	function getFotoKerusakanAll() {
		global $koneksi;
		$sql = "SELECT * FROM `data_foto_kerusakan`";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getFotoKerusakanById($id) {
		global $koneksi;
		$sql = "SELECT * FROM `data_foto_kerusakan` WHERE `id` = '$id'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getFotoKerusakanByIdPemesanan($idPemesanan) {
		global $koneksi;
		$sql = "SELECT * FROM `data_foto_kerusakan` WHERE `id_pemesanan` = '$idPemesanan'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

?>