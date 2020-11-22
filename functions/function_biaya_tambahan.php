<?php
	
	function getBiayaTambahanAll() {
		global $koneksi;
		$sql = "SELECT * FROM `data_biaya_tambahan`";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

	function getBiayaTambahanById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_biaya_tambahan` WHERE `id_biaya_tambahan` = '$id'");
        return $data;
	}

	function getBiayaTambahanByIdPemesanan($idPemesanan) {
		global $koneksi;
		$sql = "SELECT * FROM `data_biaya_tambahan` WHERE `id_pemesanan` = '$idPemesanan'";
		$data = mysqli_query($koneksi, $sql);
		return $data;
	}

?>