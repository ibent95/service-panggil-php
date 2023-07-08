<?php

    include 'functions/class_static_value.php';
    $csv = new class_static_value();
    

    include 'functions/koneksi.php';
    include 'functions/function_umum.php';

    include 'functions/function_konfigurasi.php';

    include 'functions/function_pengguna.php';
    include 'functions/function_pengguna_pelanggan.php';
    include 'functions/function_pengguna_teknisi.php';
    include 'functions/function_pengguna_pimpinan.php';

    include 'functions/function_layanan.php';
    include 'functions/function_sparepart.php';
    include 'functions/function_pemesanan.php';
    include 'functions/function_biaya_tambahan.php';
    include 'functions/function_foto_kerusakan.php';
    include 'functions/function_bukti_pembayaran.php';

    include 'functions/Zebra_Pagination.php';
