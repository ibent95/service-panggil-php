<?php
    $proses             = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
    if ($proses == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Proses belum ditentukan..!";
        echo "<script>window.history.go(-1)</script>";
    }
    if ($proses == 'remove') {
		$id 			= antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
			$id 				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
        }
        $noPemesanan    		= (isset($_POST['noPemesanan'])) ? antiInjection($_POST['noPemesanan']) : antiInjection($_GET['noPemesanan']);
        $idPelanggan    		= (isset($_POST['id_pelanggan'])) ? $_POST['id_pelanggan'] : NULL;
        $namaPelanggan  		= (isset($_POST['nama_pelanggan'])) ? $_POST['nama_pelanggan'] : NULL;
        $keluhan				= (isset($_POST['keluhan']) AND !empty($_POST['keluhan'])) ? antiInjection($_POST['keluhan']) : NULL;
		$idTeknisi				= "";
		$namaTeknisi			= "";
        $statusPemesanan    	= "tunggu";
		$teknisiCheck			= "belum";
		$persetujuanPelanggan	= "ya";
        $pengerjaanKe			= (isset($_POST['softwareId']) OR isset($_POST['hardwareId']) OR isset($_POST['sparepartId'])) ? 0 : 0 ;

		$softwareIdAll 			= (isset($_POST['softwareId'])) ? $_POST['softwareId'] : NULL ;
		$hardwareIdAll 			= (isset($_POST['hardwareId'])) ? $_POST['hardwareId'] : NULL ;
        $sparepartIdAll 		= (isset($_POST['sparepartId'])) ? $_POST['sparepartId'] : NULL ;

        $fotoKerusakan 			= (isset($_FILES['foto_kerusakan'])) ? uploadFile($_FILES['foto_kerusakan'], 'foto_kerusakan', 'img', 'short') : NULL ;
        $totalHarga             = 0;
    }
    $messages = array();
    $sql		= "";
    $redirect	= "";

    switch ($proses) {
        case 'add':
            if (isset($_POST['simpan'])) {
                // if (isset($_SESSION['data_pemesanan'])) {
                //     print_r($_SESSION['data_pemesanan']);
                // }
                try {
                    $sql = "INSERT INTO `data_pemesanan`(`no_pemesanan`, `id_kategori`, `tanggal_pesan`, `id_pelanggan`, `nama_pelanggan`, `no_telp`, `datang_ke_lokasi`, `tanggal_kerja`, `alamat`, `longlat`, `keluhan`, `status_pemesanan`, `pengerjaan_ke`) VALUES ('" . $_SESSION['data_pemesanan']['no_pemesanan'] . "', '" . $_SESSION['data_pemesanan']['id_kategori'] . "', '" . $_SESSION['data_pemesanan']['tanggal_pesan'] . "', '" . $_SESSION['data_pemesanan']['id_pelanggan'] . "', '" . $_SESSION['data_pemesanan']['nama_pelanggan'] . "', '" . $_SESSION['data_pemesanan']['no_telp'] . "', '" . $_SESSION['data_pemesanan']['datang_ke_lokasi'] . "', '" . $_SESSION['data_pemesanan']['tanggal_kerja'] . "', '" . $_SESSION['data_pemesanan']['alamat'] . "', '" . $_SESSION['data_pemesanan']['longlat'] . "', '" . $keluhan . "', '" . $_SESSION['data_pemesanan']['status_pemesanan'] . "', '" . $pengerjaanKe . "')";
                    mysqli_query($koneksi, $sql) or die($koneksi);
                } catch (Exception $e) {
                    //throw $th;
                }

                /**
                 * ===========================================================================================
                 */

                try {
                    $pemesanan = mysqli_fetch_array(getPemesananByNoPemesanan($noPemesanan), MYSQLI_BOTH);
                    // Data Pemesanan Detail
                    if (isset($_POST['softwareId'])) {
                        for ($i=0; $i < count($softwareIdAll); $i++) {
                            $hargaLayanan = mysqli_fetch_array(getJenisSoftwareById($softwareIdAll[$i]), MYSQLI_BOTH)['harga'];
                            $totalHarga += $hargaLayanan;
                            mysqli_query($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$pemesanan[id_pemesanan]', 'software', '$softwareIdAll[$i]', '$hargaLayanan', '$pengerjaanKe', '$persetujuanPelanggan')") or die ($koneksi);
                        }
                    }
                    if (isset($_POST['hardwareId'])) {
                        for ($i=0; $i < count($hardwareIdAll); $i++) {
                            $hargaLayanan = mysqli_fetch_array(getJenisHardwareById($hardwareIdAll[$i]), MYSQLI_BOTH)['harga'];
                            $totalHarga += $hargaLayanan;
                            mysqli_query($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$pemesanan[id_pemesanan]', 'hardware', '$hardwareIdAll[$i]', '$hargaLayanan', '$pengerjaanKe', '$persetujuanPelanggan')") or die ($koneksi);
                        }
                    }
                    if (isset($_POST['sparepartId'])) {
                        for ($i=0; $i < count($sparepartIdAll); $i++) {
                            $hargaSparepart = mysqli_fetch_array(getSparepartById($sparepartIdAll[$i]), MYSQLI_BOTH)['harga'];
                            $totalHarga += $hargaSparepart;
                            mysqli_query($koneksi, "INSERT INTO `data_pemesanan_detail` (`id_pemesanan`, `jenis_pengerjaan`, `id_jenis_layanan_sparepart`, `harga`, `pengerjaan_ke`, `persetujuan_pelanggan`) VALUES ('$pemesanan[id_pemesanan]', 'sparepart', '$sparepartIdAll[$i]', '$hargaSparepart', '$pengerjaanKe', '$persetujuanPelanggan')") or die ($koneksi);
                        }
                    }

                    // Data Pemesanan
                    $sql = "UPDATE `data_pemesanan` SET `total_harga` = '$totalHarga' WHERE `no_pemesanan` = '$noPemesanan'";
                    mysqli_query($koneksi, $sql) or die($koneksi);

                    // Foto Kerusakan
                    if (is_array($fotoKerusakan)) {
                        for ($i = 0; $i < count($fotoKerusakan); $i++) {
                            mysqli_query($koneksi, "INSERT INTO `data_foto_kerusakan`(`id_pemesanan`, `url_file`) VALUES ('$pemesanan[id_pemesanan]', '$fotoKerusakan[$i]')") or die($koneksi);
                        }
                    }

                    array_push($messages, array("success", "Pemesanan berhasil dilakukan, silahkan tunggu konfirmasi dari Administrator..!"));

                    // Kirim Email
                    $user = mysqli_fetch_array(getPelangganById($_SESSION['data_pemesanan']['id_pelanggan']), MYSQLI_BOTH);
                    $transaksi = mysqli_fetch_array(getPemesananByNoPemesanan($_SESSION['data_pemesanan']['no_pemesanan']), MYSQLI_BOTH);
                    $kategoriLayanan = mysqli_fetch_array(getKategoriById($transaksi['id_kategori']), MYSQLI_BOTH);
                    sendEmail("ibnu.tuharea@stimednp.ac.id", $user["email"], "transaction_out", array("no_pemesanan" => $transaksi['no_pemesanan'], "tanggal" => date( 'd/m/Y'), "nama_kategori_layanan" => $kategoriLayanan['nama_kategori_layanan']), NULL);
                    sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "transaction_in", array("tanggal" => date('d/m/Y'), "no_pemesanan" => $transaksi['no_pemesanan'], "nama_kategori_layanan" => $kategoriLayanan['nama_kategori_layanan'], "nama_pelanggan" => $user['nama_lengkap'], "no_telp" => $transaksi['no_telp']), NULL);
                    mysqli_query($koneksi, "INSERT INTO `data_notifikasi_administrator` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`) VALUES ('info', 'Baru!', 'Pemesanan baru telah masuk..!')") or die($koneksi);
                    $redirect = "?content=profil";
                } catch (Exception $e) {
                    array_push($messages, array("danger", "Pemesanan tidak berhasil dilakukan, silahkan coba lagi..!"));
                    $redirect = "?content=pemesanan";
                }
            }
            break;

        default:
            # code...
            break;
    }

    if (!empty($messages)) {
        saveNotifikasi($messages);
    }

    echo "
        <script>
            window.location.replace('$redirect');
        </script>
    ";
?>