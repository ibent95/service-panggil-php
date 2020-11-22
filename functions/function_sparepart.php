<?php

	function getSparepartAll($order = "DESC") {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_sparepart`
			ORDER BY `id_sparepart` $order
		") or die($koneksi);
		return $data;
	}

	function getSparepartLimitAll($page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_sparepart`
			ORDER BY `id_sparepart` $order
			LIMIT $limit, $offset
		") or die($koneksi);
		return $data;
	}

	function getSparepartById($id, $order = "DESC") {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_sparepart`
			WHERE `id_sparepart` = '$id'
			ORDER BY `id_sparepart` $order
		") or die($koneksi);
		return $data;
	}

	// ========================== MODEL ==========================

	function searchSparepartByKeyWord($keyWord, $order = "DESC") {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_sparepart`
			WHERE `nama_sparepart` LIKE '$keyWord%'
			OR `harga` LIKE '$keyWord%'
			OR `persediaan` LIKE '$keyWord%'
		";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_sparepart.id_sparepart $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

?>