<?php
    $content = (isset($_GET['content'])) ? $_GET['content'] : "beranda" ;
    if (!empty($content)) {
        $retVal = (file_exists("contents/" . $content . ".php")) ? include "contents/" . $content . ".php" : include "contents/404.php" ;
    }

    if ($content == "pemesanan" | $content == "pemesanan_riwayat_proses" | $content == "pemesanan_riwayat_selesai" | $content == "pemesanan_riwayat_batal") {
        include 'contents/components/modal_detail_pemesanan.php';
        include 'contents/components/modal_bukti_pembayaran.php';
    }

    if ($content == "profil_pengguna") {
    	include 'contents/components/modal_change_password.php';
    }

    if ($content == "data_pengguna" OR $content == "data_pengguna_pelanggan") {
        include 'contents/components/modal_detail_pengguna.php';
    }

    if ($content == "pemesanan_detail") {
        include 'contents/components/modal_edit_pengerjaan.php';
        include 'contents/components/modal_form_biaya_tambahan.php';
        include 'contents/components/modal_edit_processing.php';
        include 'contents/components/modal_form_additional_cost.php';
    }

 	// if ($content == "profil_pengguna") {
    	include 'contents/components/photoswipe.php';
    // }
?>