<?php
	
	function getPimpinanAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pimpinan`
			ORDER BY `id` DESC
		") or die($koneksi);
		return $data;
	}

	function getPimpinanById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pimpinan`
			WHERE `id` = '$id'
			ORDER BY `id` DESC
		") or die($koneksi);
		return $data;
	}

?>