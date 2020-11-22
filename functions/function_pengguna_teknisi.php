<?php

	function getTeknisiAll($orderBy = 'DESC', $available = "") {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_teknisi` WHERE `status_tersedia` LIKE '$available%' ORDER BY `id_teknisi` $orderBy") or die($koneksi);
		return $data;
	}

	function getTeknisiLimitAll($page, $recordCount = 12) {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_teknisi` ORDER BY `id_teknisi` DESC LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getTeknisiById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_teknisi` WHERE `id_teknisi` = '$id'") or die($koneksi);
		return $data;
	}

	function getTeknisiCountRatingByIdTeknisi($idTeknisi, $star) {
		global $koneksi;
		$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '$star' AND `id_teknisi` = '$idTeknisi'"))['count'];
		return $data;
	}

	// ========================== MODEL ==========================

	function searchTeknisiByKeyWord($keyWord) {
		global $koneksi;
		$sql = "SELECT * FROM `data_teknisi` WHERE `nama_lengkap` LIKE '$keyWord%' OR `no_hp` LIKE '$keyWord%' OR `email` LIKE '$keyWord%' OR `alamat` LIKE '$keyWord%' OR `username` LIKE '$keyWord%' OR `status_akun` LIKE '$keyWord%'";
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_teknisi.id_teknisi DESC" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function changePasswordTeknisi($oldPass, $newPass, $id) {
		global $koneksi;
		$result = FALSE;
		$oldPass = md5($oldPass);
		$newPass = md5($newPass);
		$userPass = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT `password` FROM `data_teknisi` WHERE `id_teknisi` = '$id'"));
		if ($oldPass == $userPass['password']) {
			mysqli_query($koneksi, "UPDATE `data_teknisi` SET `password` = '$newPass' WHERE `id_teknisi` = '$id'") or die($koneksi);
			$_SESSION['message-type'] = 'success';
			$_SESSION['message-content'] = 'Password berhasil diubah';
			$result = TRUE;
		} else {
			$_SESSION['message-type'] = 'danger';
			$_SESSION['message-content'] = 'Password lama yang anda masukan salah..!';
		}
		return $result;
	}

?>