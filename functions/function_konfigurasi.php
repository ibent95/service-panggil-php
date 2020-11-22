<?php
	// Semua Pengguna
	function getMenuUserAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pengguna`
			ORDER BY `id` DESC
		") or die($koneksi);
		return $data;
	}

	function getMenuUserLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pengguna`
			ORDER BY `id` DESC
			LIMIT $limit, $offset
		") or die($koneksi);
		return $data;
	}

	function getMenuUserById($id, $type = NULL) {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_pengguna`
			WHERE `id` = '$id'
		";
		if ($type != NULL || $type != "") {
			$sql .= "AND `jenis_akun` = '$type'";
		}
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getMenuUserByUserType($type = NULL) {
		global $koneksi;
		$sql = "
			SELECT *
			FROM
		";
		if ($type == NULL) {
			$sql .= "`data_konfigurasi_menu_admin`";
		} else {
			$sql .= "`data_konfigurasi_menu_$type`";
		}
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getMenuUserByIdUserType($id, $type = NULL) {
		global $koneksi;
		$sql = "
			SELECT *
			FROM
		";
		if ($type == NULL) {
			$sql .= "
				`data_konfigurasi_menu_admin`
				WHERE `id_konfigurasi_menu_admin`
			";
		} else {
			$sql .= "
				`data_konfigurasi_menu_$type`
				WHERE `id_konfigurasi_menu_$type`
			";
		}
		$sql .= "
			 = '$id'
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getMenuUserByUserTypeLimitAll($page, $recordCount = 12, $type = NULL, $order = "ASC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset = $recordCount;
		$sql = "
			SELECT *
			FROM
		";
		if ($type == NULL) {
			$sql .= "
				`data_konfigurasi_menu_admin`
				ORDER BY `id_konfigurasi_menu_admin`
			";
		} else {
			$sql .= "
				`data_konfigurasi_menu_$type`
				ORDER BY `id_konfigurasi_menu_$type`
			";
		}
		$sql .= "
			 $order
			LIMIT $limit, $offset
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getMenuUserByUserTypeAll($type = NULL, $order = "ASC") {
		global $koneksi;
		$sql = "
			SELECT *
			FROM
		";
		if ($type == NULL) {
			$sql .= "
				`data_konfigurasi_menu_admin`
				ORDER BY `id_konfigurasi_menu_admin`
			";
		} else {
			$sql .= "
				`data_konfigurasi_menu_$type`
				ORDER BY `id_konfigurasi_menu_$type`
			";
		}
		$sql .= "
			 $order
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	/**
	 * Syarat & Ketentuan
	 */
	function getSyaratKetentuanAll($order = "DESC") {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_konfigurasi_syarat_ketentuan`
			ORDER BY `id_konfigurasi_syarat_ketentuan` $order
		") or die($koneksi);
		return $data;
	}

	function getSyaratKetentuanLimitAll($page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_konfigurasi_syarat_ketentuan`
			ORDER BY `id_konfigurasi_syarat_ketentuan` $order
			LIMIT $limit, $offset
		") or die($koneksi);
		return $data;
	}

	function getSyaratKetentuanById($id, $order = "DESC") {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_konfigurasi_syarat_ketentuan`
			WHERE `id_konfigurasi_syarat_ketentuan` = '$id'
			ORDER BY `id_konfigurasi_syarat_ketentuan` $order
		") or die($koneksi);
		return $data;
	}

	function searchSyaratKetentuanByKeyWord($keyWord, $order = "DESC") {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_konfigurasi_syarat_ketentuan`
			WHERE `id_konfigurasi_syarat_ketentuan` LIKE '$keyWord%'
		";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_konfigurasi_syarat_ketentuan.id_konfigurasi_syarat_ketentuan $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

?>