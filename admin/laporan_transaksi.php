<?php

    include_once '../load_files.php';

    include_once '../plugins/dompdf/autoload.inc.php';

    $dateNow = date('Y-m-d');
    if ((isset($_POST['tanggal_awal']) AND !empty($_POST['tanggal_awal'])) OR (isset($_POST['tanggal_akhir']) AND !empty($_POST['tanggal_akhir']))) {
        $tglAwal = (isset($_POST['tanggal_awal']) AND !empty($_POST['tanggal_awal'])) ? $_POST['tanggal_awal'] : date('Y') . date('') ;
        $tglAkhir = (isset($_POST['tanggal_akhir']) AND !empty($_POST['tanggal_akhir'])) ? $_POST['tanggal_akhir'] : $dateNow ;
    }
    $tglCondition = (isset($tglAwal) AND isset($tglAkhir)) ? "((data_pemesanan.tanggal_pesan >= '$tglAwal 00:00:00') AND (data_pemesanan.tanggal_pesan <= '$tglAkhir 23:59:00')) AND" : "" ;

    $idPelanggan = (isset($_POST['id_pelanggan']) AND (!empty($_POST['id_pelanggan']) AND $_POST['id_pelanggan'] != 'all')) ? $_POST['id_pelanggan'] : "" ;
    $idKategori = (isset($_POST['id_kategori']) AND !empty($_POST['id_kategori'])) ? $_POST['id_kategori'] : "" ;
    $idTeknisi = (isset($_POST['id_teknisi']) AND !empty($_POST['id_teknisi'])) ? $_POST['id_teknisi'] : "" ;
    $rating = (isset($_POST['rating']) AND !empty($_POST['rating'])) ? $_POST['rating'] : "" ;

    $transaksiAll = mysqli_query($koneksi, "SELECT data_pemesanan.id_pemesanan, data_pemesanan.no_pemesanan, data_pemesanan.tanggal_pesan, data_pemesanan.tanggal_kerja, data_pemesanan.id_kategori, data_layanan_kategori.nama_kategori_layanan, data_pemesanan.id_pelanggan, data_pelanggan.nama_lengkap AS `nama_pelanggan`, data_pemesanan.id_teknisi, data_teknisi.nama_lengkap AS `nama_teknisi`, data_pemesanan.status_pemesanan, data_pemesanan.rating FROM `data_pemesanan` INNER JOIN `data_layanan_kategori` ON data_pemesanan.id_kategori = data_layanan_kategori.id_layanan_kategori INNER JOIN `data_pelanggan` ON data_pemesanan.id_pelanggan = data_pelanggan.id_pelanggan LEFT JOIN `data_teknisi` ON data_pemesanan.id_teknisi = data_teknisi.id_teknisi WHERE " . $tglCondition . " data_pemesanan.id_pelanggan LIKE '$idPelanggan%' AND data_pemesanan.id_kategori LIKE '$idKategori%' AND data_pemesanan.id_teknisi LIKE '$idTeknisi%' AND data_pemesanan.rating LIKE '$rating%' ORDER BY data_pemesanan.no_pemesanan ASC");

    // $count5Star = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_pemesanan`) AS `count` FROM `data_pemesanan` WHERE " . $tglCondition . " data_pemesanan.id_pelanggan LIKE '$idPelanggan%' AND data_pemesanan.id_kategori LIKE '$idKategori%' AND data_pemesanan.id_teknisi LIKE '$idTeknisi%' AND data_pemesanan.rating LIKE '5%'"))['count'];
    $count5Star = 0 ;
    $count4Star = 0 ;
    $count3Star = 0 ;
    $count2Star = 0 ;
    $count1Star = 0 ;
    foreach ($transaksiAll as $data) {
        if ($data['rating'] == 5) { $count5Star++; }
        if ($data['rating'] == 4) { $count4Star++; }
        if ($data['rating'] == 3) { $count3Star++; }
        if ($data['rating'] == 2) { $count2Star++; }
        if ($data['rating'] == 1) { $count1Star++; }
    }

    $countTunggu = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_pemesanan`) AS `count` FROM `data_pemesanan` WHERE " . $tglCondition . " data_pemesanan.id_pelanggan LIKE '$idPelanggan%' AND data_pemesanan.id_kategori LIKE '$idKategori%' AND data_pemesanan.id_teknisi LIKE '$idTeknisi%' AND `rating` LIKE '$rating%' AND `status_pemesanan` = 'tunggu'"))['count'];
    $countProses = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_pemesanan`) AS `count` FROM `data_pemesanan` WHERE " . $tglCondition . " data_pemesanan.id_pelanggan LIKE '$idPelanggan%' AND data_pemesanan.id_kategori LIKE '$idKategori%' AND data_pemesanan.id_teknisi LIKE '$idTeknisi%' AND `rating` LIKE '$rating%' AND `status_pemesanan` = 'proses'"))['count'];
    $countSelesai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_pemesanan`) AS `count` FROM `data_pemesanan` WHERE " . $tglCondition . " data_pemesanan.id_pelanggan LIKE '$idPelanggan%' AND data_pemesanan.id_kategori LIKE '$idKategori%' AND data_pemesanan.id_teknisi LIKE '$idTeknisi%' AND `rating` LIKE '$rating%' AND `status_pemesanan` = 'selesai'"))['count'];
    $countBatal = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_pemesanan`) AS `count` FROM `data_pemesanan` WHERE " . $tglCondition . " data_pemesanan.id_pelanggan LIKE '$idPelanggan%' AND data_pemesanan.id_kategori LIKE '$idKategori%' AND data_pemesanan.id_teknisi LIKE '$idTeknisi%' AND `rating` LIKE '$rating%' AND `status_pemesanan` = 'batal'"))['count'];

	$i = 1;

    // reference the Dompdf namespace
	use Dompdf\Dompdf;

	// instantiate and use the dompdf class
	$dompdf = new Dompdf();

    ob_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Laporan Nilai</title>
		<style>
            .text-center {
                text-align: center;
            }
            @font-face{
                font-family:'FontAwesome';
                src:url('../assets/frontend/fonts/fontawesome-webfont.eot?v=4.7.0');
                src:url('../assets/frontend/fonts/fontawesome-webfont.eot?#iefix&v=4.7.0') format('embedded-opentype'), url('../assets/frontend/fonts/fontawesome-webfont.woff2?v=4.7.0') format('woff2'), url('../assets/frontend/fonts/fontawesome-webfont.woff?v=4.7.0') format('woff'), url('../assets/frontend/fonts/fontawesome-webfont.ttf?v=4.7.0') format('truetype'), url('../assets/frontend/fonts/fontawesome-webfont.svg?v=4.7.0#fontawesomeregular') format('svg');
                font-weight:normal;
                font-style:normal;
            }
            .fa {
                display: inline-block;
                font: normal normal normal 14px/1 FontAwesome;
                font-size: inherit;
                text-rendering: auto;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .fa-star:before {
                content: "\f005";
            }
            .star-checked {
                color: orange;
            }
            h1, h2, h3 {
                text-align: center;
            }
            div.cover {
                text-align: center;
                vertical-align: middle;
                margin: 40% 0% 60% 0%;
                padding: auto;
            }
            table.table {
                border-collapse: collapse;
                border: 2px solid black;
                font-size: 8pt;
                width: 100%;
            }
            table.table thead {
                border-bottom: 2px solid black;
            }
            table.table thead tr th {
                border: 2px solid black;
                padding: 1.5px 2px 1.5px 2px;
                background-color: #6d7878;
                color: white;
                height: 1px;
                font-size: 8pt;
                text-align: center;
            }
            table.table tbody tr td {
                border: 1px solid black;
                border-right: 2px solid black;
                padding: 6px;
            }
            table.table tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            div.page-brake {
                page-break-before: always;
                /* page-break-after: always; */
            }
		</style>
    </head>
    <body>
        <?php $i = 1; ?>
        <p class="" style="">
            <h2 class="" style="margin-bottom: none;">
                Laporan Data Transakai <br>
                Tahun <?php echo date('Y'); ?><br>
                <?php //echo $konfigurasiUmum['nama_sekolah']; ?>
            </h2>
            <div class="text-center" style="margin-bottom: none; margin-top: none;"><?php //echo $konfigurasiUmum['alamat_sekolah']; ?></div>
        </p>
        <p>
            <table class="" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="text-align: right; width: 65%;" <?php if ($idTeknisi != 'all') echo "colspan='3'"; ?> >
                            Tanggal : <?php echo date('d-m-Y'); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </p>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-condensed">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>ID / No. Pemesanan</th>
                        <th>Tanggal Transaksi</th>
                        <th>Kategori</th>
                        <th>Nama Pelanggan</th>
                        <th>Nama Teknisi</th>
                        <th>Status Transaksi</th>
                        <th>Rating (dari 5 Bintang)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($transaksiAll) > 0) : ?>
                        <?php foreach ($transaksiAll AS $transaksi) : ?>
                            <tr>
                                <td style="text-align: center;">
                                    <?php echo $i; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $transaksi['id_pemesanan'] . " / " . $transaksi['no_pemesanan']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo format($transaksi['tanggal_pesan'], 'datetime'); ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $transaksi['nama_kategori_layanan']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $transaksi['nama_pelanggan']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo $transaksi['nama_teknisi']; ?>
                                </td>
                                <td style="text-align: center;">
                                    <?php echo normalizeString($transaksi['status_pemesanan'], 'ucf'); ?>
                                </td>
                                <td>
                                    <div style="vertical-align: middle; margin-top: 5px;">
                                        <?php echo showRating($transaksi['rating'], 15) . " [" . $transaksi['rating'] . "]"; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="11" style="text-align: center; vertical-align: middle; margin: 48% 0% 40% 0%; padding: auto;">
                                Tidak ada Data Transaksi..!
                            </td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <table class="" style="">
            <tbody>
                <tr>
                    <td colspan="3">
                        <b>Keterangan</b>
                    </td>
                </tr>
                <tr><td colspan="3">Berdasarkan Rating</td></tr>
                <tr>
                    <td style="vertical-align: middle; width: 100px;">
                        <?php echo showRating(5, 20); ?>
                    </td>
                    <td style="vertical-align: middle;">
                        :
                    </td>
                    <td>
                        <?php echo $count5Star; ?> Transaksi
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 100px;">
                        <?php echo showRating(4, 20); ?>
                    </td>
                    <td style="vertical-align: middle;">
                        :
                    </td>
                    <td>
                        <?php echo $count4Star; ?> Transaksi
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 100px;">
                        <?php echo showRating(3, 20); ?>
                    </td>
                    <td style="vertical-align: middle;">
                        :
                    </td>
                    <td>
                        <?php echo $count3Star; ?> Transaksi
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 100px;">
                        <?php echo showRating(2, 20); ?>
                    </td>
                    <td style="vertical-align: middle;">
                        :
                    </td>
                    <td>
                        <?php echo $count2Star; ?> Transaksi
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align: middle; width: 100px;">
                        <?php echo showRating(1, 20); ?>
                    </td>
                    <td style="vertical-align: middle;">
                        :
                    </td>
                    <td>
                        <?php echo $count1Star; ?> Transaksi
                    </td>
                </tr>
                <tr><td colspan="3">Berdasarkan Status</td></tr>
                <tr>
                    <td>
                        Tunggu
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <?php echo $countTunggu; ?> Transaksi
                    </td>
                </tr>
                <tr>
                    <td>
                        Proses
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <?php echo $countProses; ?> Transaksi
                    </td>
                </tr>
                <tr>
                    <td>
                        Selesai
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <?php echo $countSelesai; ?> Transaksi
                    </td>
                </tr>
                <tr>
                    <td>
                        Batal
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <?php echo $countBatal; ?> Transaksi
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
<?php
    $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper(array(0, 0, 609.4488, 935.433), 'landscape');
	// $dompdf->setPaper(array(0, 0, 550, 300));

	$dompdf->loadHtml(utf8_encode($html));

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream("Laporan_Data_Transaksi_" . $dateNow . ".pdf", array("Attachment" => 0));

	// exit(0);
?>