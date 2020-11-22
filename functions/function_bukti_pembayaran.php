<?php

    function getBuktiPembayaranAll($order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_riwayat_pembayaran` ORDER BY `id_riwayat_pembayaran` $order ";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

    function getBuktiPembayaranById($id, $order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_riwayat_pembayaran` WHERE `id_riwayat_pembayaran` = '$id' ORDER BY `id_riwayat_pembayaran` $order";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

    function getBuktiPembayaranByIdPemesanan($idPemesanan, $typePembayaran = 'panjar', $order = 'DESC') {
        global $koneksi;
        $sql = "SELECT * FROM `data_riwayat_pembayaran` WHERE `id_pemesanan` = '$idPemesanan' AND `info_pembayaran` LIKE '%$typePembayaran' ORDER BY `id_riwayat_pembayaran` $order";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

?>