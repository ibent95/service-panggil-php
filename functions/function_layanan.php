<?php
	// Kategori
	function getKategoriAll($order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_kategori`
			ORDER BY `id_layanan_kategori` $order
		") or die($koneksi);
		return $data;
	}

	function getKategoriLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_kategori`
			ORDER BY `id_layanan_kategori` DESC
			LIMIT $limit, $offset
		") or die($koneksi);
		return $data;
	}

	function getKategoriById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_kategori`
			WHERE `id_layanan_kategori` = '$id'
		") or die($koneksi);
		return $data;
	}

	// Jenis
	function getJenisLayananAll($order = "DESC") {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_layanan_jenis` ORDER BY `id_layanan_kategori` $order") or die($koneksi);
		return $data;
	}

	function getJenisLayananByIdKategori($id, $order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_layanan_jenis` WHERE `id_kategori` = '$id' ORDER BY `id_layanan_kategori` $order") or die($koneksi);
		return $data;
	}
	function getJenisLayananJoinKategoriAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori` 
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			ORDER BY data_layanan_jenis.id DESC
		") or die($koneksi);
		return $data;
	}

	function getJenisLayananJoinKategoriById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis` 
			INNER JOIN `data_layanan_kategori` 
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.id = '$id'
		") or die($koneksi);
		return $data;
	}

	// Jenis Sub Kategori Hardware
	function getJenisHardwareAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			WHERE `sub_kategori` = 'Hardware'
			ORDER BY `id_layanan_jenis` DESC
		") or die($koneksi);
		return $data;
	}

	function getJenisHardwareById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT * 
			FROM `data_layanan_jenis` 
			WHERE `sub_kategori` = 'Hardware' 
			AND `id_layanan_jenis` = '$id' 
		") or die($koneksi);
		return $data;
	}

	function getJenisHardwareByIdKategori($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			WHERE `sub_kategori` = 'Hardware' 
			AND `id_kategori` = '$id'
		") or die($koneksi);
		return $data;
	}

	function getJenisHardwareJoinKategoriAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis` 
			INNER JOIN `data_layanan_kategori` 
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.sub_kategori = 'Hardware' 
			ORDER BY data_layanan_jenis.id_layanan_jenis DESC
		") or die($koneksi);
		return $data;
	}

	function getJenisHardwareJoinKategoriLimitAll($page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.sub_kategori = 'Hardware'
			ORDER BY data_layanan_jenis.id_layanan_jenis $order
			LIMIT $limit, $offset
		") or die($koneksi);
		return $data;
	}

	function getJenisHardwareJoinKategoriById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.id_layanan_jenis = '$id'
		") or die($koneksi);
		return $data;
	}

	function getJenisHardwareJoinKategoriByIdKategori($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.id_kategori = '$id'
			AND data_layanan_jenis.sub_kategori = 'Hardware'
		") or die($koneksi);
		return $data;
	}

	// Jenis Sub Kategori Software
	function getJenisSoftwareAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			WHERE `sub_kategori` = 'Software'
			ORDER BY `id_layanan_jenis` DESC
		") or die($koneksi);
		return $data;
	}

	function getJenisSoftwareById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			WHERE `sub_kategori` = 'Software'
			AND `id_layanan_jenis` = '$id'
		") or die($koneksi);
		return $data;
	}

	function getJenisSoftwareByIdKategori($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			WHERE `sub_kategori` = 'Software' 
			AND `id_kategori` = '$id'
		") or die($koneksi);
		return $data;
	}

	function getJenisSoftwareJoinKategoriAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.sub_kategori = 'Software'
			ORDER BY data_layanan_jenis.id_layanan_jenis DESC
		") or die($koneksi);
		return $data;
	}

	function getJenisSoftwareJoinKategoriLimitAll($page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$perPage = 3;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.sub_kategori = 'Software'
			ORDER BY data_layanan_jenis.id_layanan_jenis $order
			LIMIT $limit, $offset
		") or die($koneksi);
		return $data;
	}

	function getJenisSoftwareJoinKategoriById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.id_layanan_jenis = '$id'
		") or die($koneksi);
		return $data;
	}

	function getJenisSoftwareJoinKategoriByIdKategori($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.id_kategori = '$id'
			AND data_layanan_jenis.sub_kategori = 'Software'
		") or die($koneksi);
		return $data;
	}

	// ========================== MODEL ========================== 

	function searchKategoriByKeyWord($keyWord, $order = "DESC") {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_layanan_kategori`
			WHERE `nama_kategori_layanan` LIKE '$keyWord%'
		";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_layanan_kategori.id_layanan_kategori $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function searchJenisHardwareByKeyWord($keyWord, $order = "DESC") {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.sub_kategori = 'Hardware'
			AND (data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'
			OR data_layanan_jenis.nama_jenis_layanan LIKE '$keyWord%'
			OR data_layanan_jenis.harga LIKE '$keyWord%')
		";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_layanan_jenis.id_layanan_jenis $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function searchJenisSoftwareByKeyWord($keyWord, $order = "DESC") {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_layanan_jenis`
			INNER JOIN `data_layanan_kategori`
			ON data_layanan_jenis.id_kategori = data_layanan_kategori.id_layanan_kategori
			WHERE data_layanan_jenis.sub_kategori = 'Software'
			AND (data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'
			OR data_layanan_jenis.nama_jenis_layanan LIKE '$keyWord%'
			OR data_layanan_jenis.harga LIKE '$keyWord%')
		";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_layanan_jenis.id_layanan_jenis $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

?>