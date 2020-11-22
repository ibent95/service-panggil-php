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
		// if ($proses == 'edit') {
			$id 				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : antiInjection($_GET['id']);
        // }
        // $noPemesanan    		= (isset($_POST['noPemesanan'])) ? antiInjection($_POST['noPemesanan']) : antiInjection($_GET['noPemesanan']);
        // $idPelanggan    		= (isset($_POST['id_pelanggan'])) ? $_POST['id_pelanggan'] : NULL;
        // $namaPelanggan  		= (isset($_POST['nama_pelanggan'])) ? $_POST['nama_pelanggan'] : NULL;
        // $keluhan				= (isset($_POST['keluhan']) AND !empty($_POST['keluhan'])) ? antiInjection($_POST['keluhan']) : NULL;
		$rating = (isset($_POST['rating'])) ? $_POST['rating'] : NULL ;
		$ulasan = (isset($_POST['ulasan'])) ? $_POST['ulasan'] : NULL ;
		// $idTeknisi				= "";
		// $namaTeknisi			= "";
        // $statusPemesanan    	= "tunggu";
		// $teknisiCheck			= "belum";
		// $persetujuanPelanggan	= "belum";
        // $pengerjaanKe			= "0";

		// $softwareIdAll 			= (isset($_POST['softwareId'])) ? $_POST['softwareId'] : NULL ;
		// $hardwareIdAll 			= (isset($_POST['hardwareId'])) ? $_POST['hardwareId'] : NULL ;
        // $sparepartIdAll 		= (isset($_POST['sparepartId'])) ? $_POST['sparepartId'] : NULL ;

        // $fotoKerusakan 			= (isset($_FILES['foto_kerusakan'])) ? uploadFile($_FILES['foto_kerusakan'], 'foto_kerusakan', 'img', 'full') : NULL ;
        $totalHarga             = 0;
    }
    $messages = array();
    $sql		= "";
    $redirect	= "";

    switch ($proses) {
        case 'setuju':
            try {
                // Data Pemesanan Detail
                $sql = "UPDATE `data_pemesanan_detail` SET `persetujuan_pelanggan` = 'ya' WHERE `id_pemesanan` = '$id' AND `persetujuan_pelanggan` = 'belum'";
                mysqli_query($koneksi, $sql) or die($koneksi);
                // Data Pemesanan
                $pengerjaanKe = mysqli_fetch_array(getDetailPemesananByIdPemesanan($id), MYSQLI_BOTH)['pengerjaan_ke'];
                mysqli_query($koneksi, "UPDATE `data_pemesanan` SET `pengerjaan_ke` = '$pengerjaanKe' WHERE `id_pemesanan` = '$id'") or die($koneksi);
                array_push($messages, array("success", "Anda telah menyetujui pengerjaan..!"));
                $redirect = "?content=profil";
                $transaction = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
                $technician = mysqli_fetch_array(getTeknisiById($transaction['id_teknisi']), MYSQLI_BOTH);
                // Kirim email
                sendEmail("ibnu.tuharea@stimednp.ac.id", $technician["email"], "customer_workmanship_agreed", array("pengerjaan_ke" => $pengerjaanKe, "id_pemesanan" => $transaction['id_pemesanna'], "no_pemesanan" => $transaction['no_pemesanan'], "link" => class_static_value::$URL_BASE . "/teknisi/?content=pemesanan"), NULL);
                mysqli_query($koneksi, "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`) VALUES ('info', 'Pengerjaan disetujui!', 'Pengerjaan baru telah disetujui..!', 'teknisi')") or die($koneksi);
            } catch (Exception $e) {
                array_push($messages, array("danger", "Persetujuan gagal dilakukan, silahkan coba lagi..!"));
            }
            break;
        case 'tidak_setuju':
            try {
                // Data Pemesanan Detail
                $sql = "UPDATE `data_pemesanan_detail` SET `persetujuan_pelanggan` = 'tidak' WHERE `id_pemesanan` = '$id' AND `persetujuan_pelanggan` = 'belum'";
                mysqli_query($koneksi, $sql) or die($koneksi);
                array_push($messages, array("success", "Pengerjaan berhasil ditolak..!"));
                $redirect = "?content=profil";
                $transaction = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
                $technician = mysqli_fetch_array(getTeknisiById($transaction['id_teknisi']), MYSQLI_BOTH);
                // Kirim email
                sendEmail("ibnu.tuharea@stimednp.ac.id", $technician["email"], "customer_workmanship_disagreed", array("pengerjaan_ke" => $pengerjaanKe, "id_pemesanan" => $transaction['id_pemesanan'], "no_pemesanan" => $transaction['no_pemesanan'], "link" => class_static_value::$URL_BASE . "/teknisi/?content=pemesanan"), NULL);
                mysqli_query($koneksi, "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`) VALUES ('warning', 'Pengerjaan tidak disetujui!', 'Pengerjaan baru tidak disetujui..!', 'teknisi')") or die($koneksi);
            } catch (Exception $e) {
                array_push($messages, array("danger", "Penolakan pengerjaan tidak berhasil dilakukan, silahkan coba lagi..!"));
            }
            break;
        case 'batal':
            try {
                // Data Pemesanan
                $sql = "UPDATE `data_pemesanan` SET `status_pemesanan` = 'batal' WHERE `id_pemesanan` = '$id'";
                mysqli_query($koneksi, $sql) or die($koneksi);
                $sql = "UPDATE `data_pemesanan_detail` SET `persetujuan_pelanggan` = 'tidak' WHERE `id_pemesanan` = '$id' AND `persetujuan_pelanggan` = 'belum'";
                mysqli_query($koneksi, $sql) or die($koneksi);
                $_SESSION['message-type'] = "success";
                $_SESSION['message-content'] = "Silahkan tunggu konfirmasi dari Administrator..!";
                $sparepart = mysqli_query($koneksi, "SELECT `id_pemesanan_detail` FROM `data_pemesanan_detail` WHERE `id_pemesanan` = '$id' AND `jenis_pengerjaan` = 'sparepart' AND `persetujuan_pelanggan` = 'ya'");
                $redirect = (mysqli_num_rows($sparepart) > 0) ? "?content=pembayaran_lunas_form&action=tambah&noPemesanan=" . mysqli_fetch_assoc(getPemesananById($id))['no_pemesanan'] : "?content=profil";
                $transaction = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
                $customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
                $technician = mysqli_fetch_array(getTeknisiById($transaction['id_teknisi']), MYSQLI_BOTH);
                // Kirim email
                sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "customer_cancel_transaction", array("id_pelanggan" => $transaction['id_pelanggan'], "nama_pelanggan" => $customer['nama_lengkap'], "id_pemesanan" => $transaction['id_pemesanan'], "no_pemesanan" => $transaction['no_pemesanan'], "link" => class_static_value::$URL_BASE . "/admin/?content=pemesanan_riwayat_batal&id=" . $transaction['id_pemesanan']), NULL);
                sendEmail("ibnu.tuharea@stimednp.ac.id", $technician["email"], "customer_cancel_transaction", array("id_pelanggan" => $transaction['id_pemesanan'], "nama_pelanggan" => $customer['nama_lengkap'], "id_pemesanan" => $transaction['id_pemesanan'], "no_pemesanan" => $transaction['no_pemesanan'], "link" => class_static_value::$URL_BASE . "/teknisi/?content=pemesanan_riwayat_batal&id=" . $transaction['id_pemesanan']), NULL);
                mysqli_query($koneksi, "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`) VALUES ('danger', 'Pemesanan Batal!', 'Pemesanan telah dibatalkan..!', 'administrator'), ('danger', 'Pemesanan Batal!', 'Pemesanan telah dibatalkan..!', 'teknisi');") or die($koneksi);
            } catch (Exception $e) {
                $_SESSION['message-type'] = "danger";
                $_SESSION['message-content'] = "Pemesanan tidak berhasil dilakukan, silahkan coba lagi..!";
            }
            break;
        case 'finish':
            try {
                // Data Pemesanan
                $sql = "UPDATE`data_pemesanan` SET `status_pemesanan` = 'selesai' WHERE `id_pemesanan` = '$id'";
                mysqli_query($koneksi, $sql) or die($koneksi);
                $_SESSION['message-type'] = "success";
                $_SESSION['message-content'] = "Transaksi telah selesai..!";
                $redirect = "?content=perbaikan_rating_form&id=" . $id ;
                // Kirim email
                $transaction = mysqli_fetch_array(getPemesananById($id), MYSQLI_BOTH);
                $customer = mysqli_fetch_array(getPelangganById($transaction['id_pelanggan']), MYSQLI_BOTH);
                $technician = mysqli_fetch_array(getTeknisiById($transaction['id_teknisi']), MYSQLI_BOTH);
                sendEmail("ibnu.tuharea@stimednp.ac.id", $technician["email"], "customer_finish_transaction", array("id_pelanggan" => $customer['id_pelanggan'], "nama_pelanggan" => $customer['nama_lengkap'], "no_pemesanan" => $transaction['no_pemesanan']), NULL);
                sendEmail("ibnu.tuharea@stimednp.ac.id", "ibnu.tuharea@stimednp.ac.id", "customer_finish_transaction", array("id_pelanggan" => $customer['id_pelanggan'], "nama_pelanggan" => $customer['nama_lengkap'], "no_pemesanan" => $transaction['no_pemesanan']), NULL);
                mysqli_query($koneksi, "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`) VALUES ('success', 'Pemesanan Selesai!', 'Pemesanan telah selesai..!', 'administrator'), ('success', 'Pemesanan Selesai!', 'Pemesanan telah selesai..!', 'teknisi');") or die($koneksi);
            } catch (Exception $e) {
                $_SESSION['message-type'] = "danger";
                $_SESSION['message-content'] = "Pemesanan tidak berhasil dilakukan, silahkan coba lagi..!";
            }
            break;
        case 'add_rating':
            try {
                $sql = "UPDATE`data_pemesanan` SET `rating` = '$rating', `ulasan` = '$ulasan' WHERE `id_pemesanan` = '$id'";
                mysqli_query($koneksi, $sql) or die($koneksi);
                $_SESSION['message-type'] = "success";
                $_SESSION['message-content'] = "Transaksi telah selesai..!";
                $redirect = "?content=profil" ;
            } catch (Exception $e) {
                $_SESSION['message-type'] = "danger";
                $_SESSION['message-content'] = "Pemesanan tidak berhasil dilakukan, silahkan coba lagi..!";
            }
            break;
        default:
            # code...
            break;
    }

    if (!empty($messages)) {
        saveNotifikasi($messages);
    }

    echo "<script> window.location.replace('$redirect'); </script>";
?>