<?php

	// Data Pemesanan
	function getPemesananAll($order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` ORDER BY `id_pemesanan` $order") or die($koneksi);
		return $data;
	}

	function getPemesananById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` WHERE `id_pemesanan` = '$id'") or die($koneksi);
		return $data;
	}

	function getPemesananByNoPemesanan($noPemesanan) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` WHERE `no_pemesanan` = '$noPemesanan'") or die($koneksi);
		return $data;
	}

	function getPemesananLimitAll($page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` ORDER BY `id_pemesanan` $order LIMIT $limit, $off_pemesananset") or die($koneksi);
		return $data;
	}

	function getPemesananJoinDetailAll($order = "DESC") {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` INNER JOIN `data_pemesanan_detail` ON data_pemesanan.id_pemesanan = data_pemesanan_detail.id_pemesanan ORDER BY data_pemesanan.id_pemesanan $order") or die($koneksi);
		return $data;
	}

	function getPemesananJoinDetailById($id, $order = "DESC") {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` INNER JOIN `data_pemesanan_detail` ON data_pemesanan.id_pemesanan = data_pemesanan_detail.id_pemesanan WHERE data_pemesanan.id_pemesanan = '$id' ORDER BY data_pemesanan.id_pemesanan $order") or die($koneksi);
		return $data;
	}

	function getPemesananJoinDetailLimitAll($page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` INNER JOIN `data_pemesanan_detail` ON data_pemesanan.id_pemesanan = data_pemesanan_detail.id_pemesanan ORDER BY data_pemesanan.id_pemesanan $order LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getPemesananJoinLimitAll($page, $recordCount = 12, $order = "DESC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` INNER JOIN `data_layanan_kategori` ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan ORDER BY data_pemesanan.id_pemesanan $order LIMIT $limit, $offset") or die($koneksi);
		return $data;
	}

	function getPemesananSubJoinLimitAll($page, $recordCount = 12, $sub = 'pending', $idTeknisi = 0, $order = 'DESC') {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$sql = "SELECT * FROM `data_pemesanan` INNER JOIN `data_layanan_kategori` ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan WHERE (data_pemesanan.status_pemesanan LIKE '%$sub' ";
		if ($sub == "proses") {
			$sql .= "OR data_pemesanan.status_pemesanan LIKE '%tunggu' ";
		} elseif ($sub == "tunggu") {
			$sql .= "OR data_pemesanan.status_pemesanan LIKE '%proses' ";
		}
		$sql .= ") AND data_pemesanan.id_teknisi LIKE '%$idTeknisi' ORDER BY data_pemesanan.id_pemesanan $order LIMIT $limit, $offset";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getPemesananSubJoinAll($sub = 'pending', $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT * FROM `data_pemesanan` INNER JOIN `data_layanan_kategori` ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan ";
		if ($sub == 'proses' || $sub == 'selesai') {
			$sql .= "INNER JOIN `data_teknisi` ON data_pemesanan.id_teknisi = data_teknisi.id_teknisi ";
		}
		$sql .= "WHERE data_pemesanan.status_pemesanan = '$sub' ORDER BY data_pemesanan.id_pemesanan $order";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getPemesananSubJoinAllById($id, $sub = 'pending', $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT * FROM `data_pemesanan` INNER JOIN `data_layanan_kategori` ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan ";
		if ($sub == 'proses' || $sub == 'selesai') {
			$sql .= "INNER JOIN `data_teknisi` ON data_pemesanan.id_teknisi = data_teknisi.id_teknisi ";
		}
		$sql .= "WHERE data_pemesanan.id_pemesanan = '$id' AND data_pemesanan.status_pemesanan = '$sub' ORDER BY data_pemesanan.id_pemesanan $order";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getPemesananJoinById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` INNER JOIN `data_layanan_kategori` ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan WHERE data_pemesanan.id_pemesanan = '$id'") or die($koneksi);
		return $data;
	}

	function getPemesananJoinAllById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "SELECT * FROM `data_pemesanan` INNER JOIN `data_layanan_kategori` ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan INNER JOIN `data_teknisi` ON data_pemesanan.id_teknisi = data_teknisi.id_teknisi WHERE data_pemesanan.id_pemesanan = '$id'") or die($koneksi);
		return $data;
	}

	function getPemesananSubJoinLimitByIdTeknisi($page, $recordCount = 12, $sub = 'pending', $idTeknisi, $teknisiCheck = NULL, $order = "DESC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$sql = "
			SELECT *
			FROM `data_pemesanan`
			INNER JOIN `data_layanan_kategori`
			ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori
			INNER JOIN `data_pelanggan`
			ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan
			WHERE data_pemesanan.id_teknisi = '$idTeknisi'
			AND (data_pemesanan.status_pemesanan = '$sub' OR data_pemesanan.status_pemesanan = 'tunggu')
		";

		if ($teknisiCheck != NULL) {
			$sql .= "
				AND data_pemesanan.teknisi_check = '$teknisiCheck'
			";
		}

		$sql .= "
			ORDER BY data_pemesanan.id_pemesanan $order
			LIMIT $limit, $offset
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getPemesananSubJoinByIdTeknisi($sub = 'pending', $idTeknisi = "", $order = "DESC") {
		global $koneksi;
		$sql = "
			SELECT *
			FROM `data_pemesanan`
			INNER JOIN `data_layanan_kategori`
			ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori
			INNER JOIN `data_pelanggan`
			ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan
			WHERE data_pemesanan.id_teknisi LIKE '%$idTeknisi'
			AND (data_pemesanan.status_pemesanan LIKE '%$sub' OR data_pemesanan.status_pemesanan LIKE '%tunggu')
			ORDER BY data_pemesanan.id_pemesanan $order
		";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getPemesananSubJoinLimitByIdPelanggan($page, $recordCount = 12, $sub = 'pending', $idPelanggan, $pelangganCheck = null, $order = "DESC") {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset = $recordCount;
		$sql = "
				SELECT *
				FROM `data_pemesanan`
			";
			// $sql .= "
			// 	INNER JOIN `data_layanan_kategori`
			// 	ON data_pemesanan.id_kategori = data_layanan_kategori.id
			// ";
		$sql .= "
				INNER JOIN `data_pelanggan`
				ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan
			";
			// if ($sub == 'proses' || $sub == 'selesai') {
			// 	$sql .= "
			// 		INNER JOIN `data_teknisi`
			// 		ON data_pemesanan.id_teknisi = data_teknisi.id
			// 	";
			// }
		$sql .= "
				WHERE data_pemesanan.id_pelanggan = '$idPelanggan'
				AND data_pemesanan.status_pemesanan = '$sub'
			";

			// if ($teknisiCheck != NULL) {
			// 	$sql .= "
			// 		AND data_pemesanan.teknisi_check = '$pelangganCheck'
			// 	";
			// }

		$sql .= "
				ORDER BY data_pemesanan.id_pemesanan $order
				LIMIT $limit, $offset
			";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getPemesananSubJoinByIdPelanggan($idPelanggan, $sub = 'pending', $order = "DESC") {
		global $koneksi;
		$sql		= "SELECT * FROM `data_pemesanan` INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan WHERE data_pemesanan.id_pelanggan = '$idPelanggan' AND ";
		if ($sub == 'proses_batal') {
			$sql	.= "(data_pemesanan.status_pemesanan = 'proses' OR data_pemesanan.status_pemesanan = 'batal') ";
		} else {
			$sql	.= "data_pemesanan.status_pemesanan = '$sub' ";
		}
		$sql		.= "ORDER BY data_pemesanan.id_pemesanan $order";
		$data		= mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	// Data Pemesanan Detail
	function getDetailPemesananAll() {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pemesanan_detail`
			ORDER BY `id_pemesanan_detail` DESC
		") or die($koneksi);
		return $data;
	}

	function getDetailPemesananById($id) {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pemesanan_detail`
			WHERE `id_pemesanan_detail` = '$id'
			ORDER BY `id_pemesanan_detail` DESC
		") or die($koneksi);
		return $data;
	}

	function getDetailJoinPemesananAll($order = "DESC") {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pemesanan_detail`
			INNER JOIN `data_pemesanan`
			ON data_pemesanan_detail.id_pemesanan = data_pemesanan.id_pemesanan
			ORDER BY data_pemesanan_detail.id_pemesanan_detail $order
		") or die($koneksi);
		return $data;
	}

	function getDetailJoinPemesananById($id, $order = 'DESC') {
		global $koneksi;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pemesanan_detail`
			INNER JOIN `data_pemesanan`
			ON data_pemesanan_detail.id_pemesanan = data_pemesanan.id_pemesanan
			ORDER BY data_pemesanan_detail.id $order
			WHERE data_pemesanan_detail.id_pemesanan_detail = '$id'
			ORDER BY data_pemesanan_detail.id_pemesanan_detail $order
		") or die($koneksi);
		return $data;
	}

	function getDetailJoinPemesananLimitAll($page, $recordCount = 12, $order = 'DESC') {
		global $koneksi;
		$limit = ($page * $recordCount) - $recordCount;
		$offset= $recordCount;
		$data = mysqli_query($koneksi, "
			SELECT *
			FROM `data_pemesanan_detail`
			INNER JOIN `data_pemesanan`
			ON data_pemesanan_detail.id_pemesanan = data_pemesanan.id_pemesanan
			ORDER BY data_pemesanan_detail.id_pemesanan_detail $order
			LIMIT $limit, $offset
		") or die($koneksi);
		return $data;
	}

	function getDetailPemesananByIdPemesanan($idPemesanan, $jenisPengerjaan = '', $pengerjaan = '', $persetujuanPelanggan = '', $order = 'DESC') {
		global $koneksi;
		$sql = "
			SELECT 
				data_pemesanan_detail.id_pemesanan_detail,
				data_pemesanan_detail.id_pemesanan,
				data_layanan_jenis.id_kategori,
				data_pemesanan_detail.jenis_pengerjaan,
				data_pemesanan_detail.id_jenis_layanan_sparepart,
				data_layanan_jenis.nama_jenis_layanan,
				data_sparepart.nama_sparepart,
				data_sparepart.harga AS `harga_sparepart`,
				data_pemesanan_detail.harga,
				data_pemesanan_detail.pengerjaan_ke,
				data_pemesanan_detail.persetujuan_pelanggan,
				data_biaya_tambahan.id_biaya_tambahan,
				data_biaya_tambahan.keterangan,
				data_biaya_tambahan.jumlah AS `harga_biaya_tambahan`
			FROM `data_pemesanan_detail`
			LEFT JOIN `data_layanan_jenis`
			ON data_pemesanan_detail.id_jenis_layanan_sparepart = data_layanan_jenis.id_layanan_jenis
			LEFT JOIN `data_sparepart`
			ON data_pemesanan_detail.id_jenis_layanan_sparepart = data_sparepart.id_sparepart
			LEFT JOIN `data_biaya_tambahan`
			ON data_pemesanan_detail.id_jenis_layanan_sparepart = data_biaya_tambahan.id_biaya_tambahan
			WHERE data_pemesanan_detail.jenis_pengerjaan LIKE '%$jenisPengerjaan'
			AND data_pemesanan_detail.id_pemesanan LIKE '%$idPemesanan'
			AND data_pemesanan_detail.pengerjaan_ke LIKE '%$pengerjaan'
		";
		if ($persetujuanPelanggan == 'not_ya') {
			$sql .= "
				AND data_pemesanan_detail.persetujuan_pelanggan NOT LIKE '%ya'
			";
		} elseif ($persetujuanPelanggan == 'not_tidak') {
			$sql .= "
				AND data_pemesanan_detail.persetujuan_pelanggan NOT LIKE '%tidak'
			";
		} elseif ($persetujuanPelanggan == 'not_belum') {
			$sql .= "
				AND data_pemesanan_detail.persetujuan_pelanggan NOT LIKE '%belum'
			";
		} else {
			$sql .= "
				AND data_pemesanan_detail.persetujuan_pelanggan LIKE '%$persetujuanPelanggan'
			";
		}
		$sql .= "
			ORDER BY data_pemesanan_detail.id_pemesanan_detail $order
		";
		// echo $sql . "<br>";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function getPersetujuanPelangganTerakhir($idPemesanan, $persetujuan = NULL) {
		$persetujuanTerakhir 	= FALSE;
		$detailPemesananAll 	= getDetailPemesananByIdPemesanan($idPemesanan, '', '', '', 'ASC');
		if (mysqli_num_rows($detailPemesananAll) > 0) {
			foreach ($detailPemesananAll as $data) {
				if ($persetujuan !== NULL) {
					if ($data['persetujuan_pelanggan'] === $persetujuan) {
						$persetujuanTerakhir = TRUE;
					} else {
						$persetujuanTerakhir = FALSE;
					}
				} else {
					$persetujuanTerakhir = $data['persetujuan_pelanggan'];
				}
			}
		}
		return $persetujuanTerakhir;
	}

	function getDetailPemesananByPengerjaanKe($idPemesanan, $pengerjaanKe = '1') {
		$data 	= getDetailPemesananByIdPemesanan($idPemesanan, '', $pengerjaanKe, '', 'ASC');
		return $data;
	}

	function getTotalHargaPemesanan($idPemesanan = NULL) {
		global $koneksi;
		$data = 0;
		if ($idPemesanan != NULL) {
			$totalHarga = 0;
			$pemesanan			= mysqli_fetch_assoc(getPemesananById($idPemesanan));
			$diagnosisSoftware  = ($pemesanan['status_pemesanan'] != 'batal') ? getDetailPemesananByIdPemesanan($idPemesanan, 'software', '', 'ya', 'ASC') : mysqli_query($koneksi, "SELECT * FROM `data_pemesanan_detail` LEFT JOIN `data_pemesanan` ON data_pemesanan_detail.id_pemesanan = data_pemesanan.id_pemesanan WHERE data_pemesanan_detail.id_pemesanan = '$idPemesanan' AND data_pemesanan.status_pemesanan NOT LIKE 'batal'");
			$diagnosisHardware  = ($pemesanan['status_pemesanan'] != 'batal') ? getDetailPemesananByIdPemesanan($idPemesanan, 'hardware', '', 'ya', 'ASC') : mysqli_query($koneksi, "SELECT * FROM `data_pemesanan_detail` LEFT JOIN `data_pemesanan` ON data_pemesanan_detail.id_pemesanan = data_pemesanan.id_pemesanan WHERE data_pemesanan_detail.id_pemesanan = '$idPemesanan' AND data_pemesanan.status_pemesanan NOT LIKE 'batal'");
			$diagnosisSparepart = getDetailPemesananByIdPemesanan($idPemesanan, 'sparepart', '', 'ya', 'ASC');
			$biayaTambahan      = ($pemesanan['status_pemesanan'] != 'batal') ? getDetailPemesananByIdPemesanan($idPemesanan, 'biaya_tambahan', '', 'ya', 'ASC') : mysqli_query($koneksi, "SELECT * FROM `data_pemesanan_detail` LEFT JOIN `data_pemesanan` ON data_pemesanan_detail.id_pemesanan = data_pemesanan.id_pemesanan WHERE data_pemesanan_detail.id_pemesanan = '$idPemesanan' AND data_pemesanan.status_pemesanan NOT LIKE 'batal'");
			if (mysqli_num_rows($diagnosisSoftware) > 0) {
				foreach ($diagnosisSoftware as $data) {
					$totalHarga += $data['harga'];
					// echo $data['harga'] . "<br>";
				}
			}
			if (mysqli_num_rows($diagnosisHardware) > 0) {
				foreach ($diagnosisHardware as $data) {
					$totalHarga += $data['harga'];
					// echo $data['harga'] . "<br>";
				}
			}
			if (mysqli_num_rows($diagnosisSparepart) > 0) {
				foreach ($diagnosisSparepart as $data) {
					$totalHarga += $data['harga_sparepart'];
					// echo $data['harga_sparepart'] . "<br>";
				}
			}
			if (mysqli_num_rows($biayaTambahan) > 0) {
				foreach ($biayaTambahan as $data) {
					$totalHarga += $data['harga'];
					// echo $data['harga_biaya_tambahan'] . "<br>";
				}
			}
			$data = $totalHarga;
		}
		return $data;
	}

	function getSisaPembayaranPemesanan($idPemesanan = NULL) {
		$data = 0;
		if ($idPemesanan != NULL) {
			$totalHarga = (int) getTotalHargaPemesanan($idPemesanan);
			$riwayatPembayaran  = getBuktiPembayaranByIdPemesanan($idPemesanan, '', 'ASC');
			$sisaPembayaran     = 0;
			if ($totalHarga != 0) {
				$sisaPembayaran += $totalHarga;
			}
			if (mysqli_num_rows($riwayatPembayaran) > 0) {
				foreach ($riwayatPembayaran as $data) {
					$sisaPembayaran -= $data['jumlah'];
				}
			}
			$data = $sisaPembayaran;
		}
		return $data;
	}

	// ========================== MODEL ==========================

	function searchPemesananByKeyWord($keyWord, $status = '', $order = "DESC") {
		global $koneksi;
		$sql = "";
		if ($status == 'tunggu' | $status == 'pending' | $status == 'batal' | $status == 'tolak') {
			$sql = "
				SELECT
					data_pemesanan.id_pemesanan,
					data_pemesanan.tanggal_pesan,
					data_pemesanan.id_pelanggan,
					data_pelanggan.nama_lengkap,
					data_teknisi.id_teknisi,
					data_teknisi.nama_lengkap,
					data_pelanggan.alamat,
					data_pemesanan.id_kategori,
					data_pemesanan.tanggal_kerja,
					data_pemesanan.keluhan,
					data_pemesanan.teknisi_check,
					data_pemesanan.status_pemesanan
				FROM `data_pemesanan`
				INNER JOIN `data_pelanggan`
				ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan
				LEFT JOIN `data_teknisi`
				ON data_pemesanan.id_teknisi = data_teknisi.id_teknisi
				INNER JOIN `data_layanan_kategori`
				ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori
				WHERE data_pemesanan.status_pemesanan = '$status'
				AND ((
						data_pemesanan.tanggal_pesan LIKE '$keyWord%'
						OR data_pemesanan.tanggal_kerja LIKE '$keyWord%'
						OR data_pemesanan.keluhan LIKE '%$keyWord%'
					) OR (data_pelanggan.nama_lengkap LIKE '$keyWord%'
						OR data_pelanggan.username LIKE '$keyWord%'
						OR data_pelanggan.alamat LIKE '$keyWord%'
					) OR (
						data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'
					)
				)
			";
		// } elseif ($status == 'proses' | $status == 'selesai') {
		// 	$sql = "
		// 		SELECT
		// 			data_pemesanan.id,
		// 			data_pemesanan.tanggal_pesan,
		// 			data_pemesanan.id_pelanggan,
		// 			data_pelanggan.nama_lengkap,
		// 			data_pelanggan.alamat,
		// 			data_pemesanan.id_kategori,
		// 			data_pemesanan.tanggal_kerja,
		// 			data_pemesanan.keluhan,
		// 			data_pemesanan.id_teknisi,
		// 			data_teknisi.nama_lengkap,
		// 			data_teknisi.alamat,
		// 			data_pemesanan.status_pemesanan
		// 		FROM `data_pemesanan`
		// 		INNER JOIN `data_pelanggan`
		// 		ON data_pemesanan.id_pelanggan = data_pelanggan.id
		// 		INNER JOIN `data_layanan_kategori`
		// 		ON data_pemesanan.id_kategori = data_layanan_kategori.id
		// 		INNER JOIN `data_teknisi`
		// 		ON data_pemesanan.id_teknisi = data_teknisi.id
		// 		WHERE data_pemesanan.status_pemesanan = '$status'
		// 		AND ((
		// 				data_pemesanan.tanggal_pesan LIKE '$keyWord%'
		// 				OR data_pemesanan.tanggal_kerja LIKE '$keyWord%'
		// 				OR data_pemesanan.keluhan LIKE '%$keyWord%'
		// 			) OR (data_pelanggan.nama_lengkap LIKE '$keyWord%'
		// 				OR data_pelanggan.username LIKE '$keyWord%'
		// 				OR data_pelanggan.alamat LIKE '$keyWord%'
		// 			) OR (data_teknisi.nama_lengkap LIKE '$keyWord%'
		// 				OR data_teknisi.username LIKE '$keyWord%'
		// 				OR data_teknisi.alamat LIKE '$keyWord%'
		// 			) OR (
		// 				data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'
		// 			)
		// 		)
		// 	";
		} else {
			$sql = "
				SELECT
					data_pemesanan.id_pemesanan,
					data_pemesanan.tanggal_pesan,
					data_pemesanan.id_pelanggan,
					data_pelanggan.nama_lengkap,
					data_pelanggan.alamat,
					data_pemesanan.id_kategori,
					data_pemesanan.tanggal_kerja,
					data_pemesanan.keluhan,
					data_pemesanan.id_teknisi,
					data_teknisi.nama_lengkap,
					data_teknisi.alamat,
					data_pemesanan.status_pemesanan
				FROM `data_pemesanan`
				INNER JOIN `data_pelanggan`
				ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan
				INNER JOIN `data_layanan_kategori`
				ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori
				INNER JOIN `data_teknisi`
				ON data_pemesanan.id_teknisi = data_teknisi.id_teknisi
				WHERE data_pemesanan.status_pemesanan = '$status'
				AND ((
						data_pemesanan.tanggal_pesan LIKE '$keyWord%'
						OR data_pemesanan.tanggal_kerja LIKE '$keyWord%'
						OR data_pemesanan.keluhan LIKE '%$keyWord%'
					) OR (data_pelanggan.nama_lengkap LIKE '$keyWord%'
						OR data_pelanggan.username LIKE '$keyWord%'
						OR data_pelanggan.alamat LIKE '$keyWord%'
					) OR (data_teknisi.nama_lengkap LIKE '$keyWord%'
						OR data_teknisi.username LIKE '$keyWord%'
						OR data_teknisi.alamat LIKE '$keyWord%'
					) OR (
						data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'
					)
				)
			";
		}
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_pemesanan.id_pemesanan $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function searchPemesananByIdTeknisiKeyWord($keyWord, $idTeknisi, $status = '', $order = "DESC") {
		global $koneksi;
		$sql = "";
		if ($status == 'tunggu' | $status == 'pending' | $status == 'batal' | $status == 'tolak') {
			$sql = "
				SELECT
					data_pemesanan.id_pemesanan,
					data_pemesanan.tanggal_pesan,
					data_pemesanan.id_pelanggan,
					data_pelanggan.nama_lengkap,
					data_pelanggan.alamat,
					data_pemesanan.id_kategori,
					data_pemesanan.tanggal_kerja,
					data_pemesanan.keluhan,
					data_pemesanan.teknisi_check,
					data_pemesanan.status_pemesanan
				FROM `data_pemesanan`
				INNER JOIN `data_pelanggan`
				ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan
				INNER JOIN `data_layanan_kategori`
				ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori
				WHERE data_pemesanan.status_pemesanan = '$status'
				AND ((
						data_pemesanan.tanggal_pesan LIKE '$keyWord%'
						OR data_pemesanan.tanggal_kerja LIKE '$keyWord%'
						OR data_pemesanan.keluhan LIKE '%$keyWord%'
					) OR (data_pelanggan.nama_lengkap LIKE '$keyWord%'
						OR data_pelanggan.username LIKE '$keyWord%'
						OR data_pelanggan.alamat LIKE '$keyWord%'
					) OR (
						data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'
					)
				)
			";
		} else {
			$sql = "
				SELECT
					data_pemesanan.id_pemesanan,
					data_pemesanan.tanggal_pesan,
					data_pemesanan.id_pelanggan,
					data_pelanggan.nama_lengkap,
					data_pelanggan.alamat,
					data_pemesanan.id_kategori,
					data_pemesanan.tanggal_kerja,
					data_pemesanan.keluhan,
					data_pemesanan.id_teknisi,
					data_teknisi.nama_lengkap,
					data_teknisi.alamat,
					data_pemesanan.teknisi_check,
					data_pemesanan.status_pemesanan
				FROM `data_pemesanan`
				INNER JOIN `data_pelanggan`
				ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan
				INNER JOIN `data_layanan_kategori`
				ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori
				INNER JOIN `data_teknisi`
				ON data_pemesanan.id_teknisi = data_teknisi.id_teknisi
				WHERE data_pemesanan.id_teknisi = '$idTeknisi'
				AND data_pemesanan.status_pemesanan = '$status'
				AND ((
						data_pemesanan.tanggal_pesan LIKE '$keyWord%'
						OR data_pemesanan.tanggal_kerja LIKE '$keyWord%'
						OR data_pemesanan.keluhan LIKE '%$keyWord%'
					) OR (data_pelanggan.nama_lengkap LIKE '$keyWord%'
						OR data_pelanggan.username LIKE '$keyWord%'
						OR data_pelanggan.alamat LIKE '$keyWord%'
					) OR (data_teknisi.nama_lengkap LIKE '$keyWord%'
						OR data_teknisi.username LIKE '$keyWord%'
						OR data_teknisi.alamat LIKE '$keyWord%'
					) OR (
						data_layanan_kategori.nama_kategori_layanan LIKE '$keyWord%'
					)
				)
			";
		}
		$sql .= ($keyWord == '' | $keyWord == NULL | empty($keyWord)) ? "ORDER BY data_pemesanan.id_pemesanan $order" : "" ;
		$data = mysqli_query($koneksi, $sql) or die('Error, ' . mysqli_error($koneksi));
		return $data;
	}

	function countPemesanan($sub = "", $idTeknisi = "", $teknisiCheck = "", $order = 'DESC') {
		global $koneksi;
		$sql = "SELECT COUNT(*) AS `jumlah` FROM `data_pemesanan` INNER JOIN `data_layanan_kategori` ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan WHERE (data_pemesanan.status_pemesanan LIKE '%$sub' ";
		$sql .= ($sub == "proses") ? "OR data_pemesanan.status_pemesanan LIKE '%tunggu' " : "" ;
		$sql .= ($sub == "tunggu") ? "OR data_pemesanan.status_pemesanan LIKE '%proses' " : "" ;
		$sql .= ") AND data_pemesanan.id_teknisi LIKE '%$idTeknisi' AND data_pemesanan.teknisi_check LIKE '%$teknisiCheck' ORDER BY data_pemesanan.id_pemesanan $order ";
		$data = mysqli_fetch_array(mysqli_query($koneksi, $sql), MYSQLI_BOTH);
		return $data['jumlah'];
	}

?>