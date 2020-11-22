<?php

    include_once '../load_files.php';

    include_once '../plugins/dompdf/autoload.inc.php';

    $dateNow = date('Y-m-d');
    $idTeknisi = (isset($_POST['id_teknisi']) AND !empty($_POST['id_teknisi'])) ? $_POST['id_teknisi'] : NULL ;
    if ($idTeknisi AND $idTeknisi == 'all') {
        $teknisiAll = getTeknisiAll('ASC') ;
        $countTeknisiAktif = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_teknisi` WHERE `status_akun` = 'aktif'"))['count'];
        $countTeknisiNonAktif = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_teknisi` WHERE `status_akun` = 'blokir'"))['count'];
        // echo $idTeknisi;
    } elseif ($idTeknisi AND $idTeknisi != 'all') {
        $teknisi = mysqli_fetch_array(getTeknisiById($idTeknisi), MYSQLI_BOTH);
        $totalRating = 0;
        $star5 = getTeknisiCountRatingByIdTeknisi($idTeknisi, 5);
        $star4 = getTeknisiCountRatingByIdTeknisi($idTeknisi, 4);
        $star3 = getTeknisiCountRatingByIdTeknisi($idTeknisi, 3);
        $star2 = getTeknisiCountRatingByIdTeknisi($idTeknisi, 2);
        $star1 = getTeknisiCountRatingByIdTeknisi($idTeknisi, 1);
        $totalRating = calculateAllRating(
            array(
                array('star' => 5, 'count' => $star5),
                array('star' => 4, 'count' => $star4),
                array('star' => 3, 'count' => $star3),
                array('star' => 2, 'count' => $star2),
                array('star' => 1, 'count' => $star1)
            )
        );
    } else {
        
    }

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
        <title>Laporan Data Teknisi</title>
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
                Laporan Data Teknisi <br>
                Tahun <?php echo date('Y'); ?><br>
                <?php //echo $konfigurasiUmum['nama_sekolah']; ?>
            </h2>
            <div class="text-center" style="margin-bottom: none;margin-top: none;"><?php //echo $konfigurasiUmum['alamat_sekolah']; ?></div>
        </p>
        <p>
            <table class="" style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="text-align: right; width: 65%;" <?php if ($idTeknisi != 'all') echo "colspan='3'"; ?> >
                            Tanggal : <?php echo date('d-m-Y'); ?>
                        </td>
                        <?php if ($idTeknisi != 'all') : ?>
                            </tr>
                            <tr>
                                <td style="width: 0%;">
                                    Nama Teknisi
                                </td>
                                <td style="text-align: left; width: 1px;">
                                    :
                                </td>
                                <td style="text-align: left; width: 150%;">
                                    <?php echo $teknisi['nama_lengkap']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 0%;">
                                    No. HP
                                </td>
                                <td style="text-align: left; width: 1px;">
                                    :
                                </td>
                                <td style="text-align: left; width: 150%;">
                                    <?php echo $teknisi['no_hp']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 0%;">
                                    Email
                                </td>
                                <td style="text-align: left; width: 1px;">
                                    :
                                </td>
                                <td style="text-align: left; width: 150%;">
                                    <?php echo $teknisi['email']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 0%;">
                                    Alamat
                                </td>
                                <td style="text-align: left; width: 1px;">
                                    :
                                </td>
                                <td style="text-align: left; width: 150%;">
                                    <?php echo $teknisi['alamat']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 0%;">
                                    Status Akun
                                </td>
                                <td style="text-align: left; width: 1px;">
                                    :
                                </td>
                                <td style="text-align: left; width: 150%;">
                                    <?php echo $teknisi['status_akun']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 0%;">
                                    Tanggal Daftar
                                </td>
                                <td style="text-align: left; width: 1px;">
                                    :
                                </td>
                                <td style="text-align: left; width: 150%;">
                                    <?php echo $teknisi['tgl_daftar']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 0%; vertical-align: top;">
                                    Rating
                                </td>
                                <td style="text-align: left; width: 1px; vertical-align: top;">
                                    :
                                </td>
                                <td style="text-align: left; width: 150%; vertical-align: top;">
                                    <p style="vertical-align: top;"><?= (isset($totalRating)) ? $totalRating : 0 ?> dari 5 Bintang</p>
                                    <?= showRating(5, 20) ?> : <?= (isset($star5)) ? $star5 : 0 ?> kali Penilaian <br>
                                    <?= showRating(4, 20) ?> : <?= (isset($star4)) ? $star4 : 0 ?> kali Penilaian <br>
                                    <?= showRating(3, 20) ?> : <?= (isset($star3)) ? $star3 : 0 ?> kali Penilaian <br>
                                    <?= showRating(2, 20) ?> : <?= (isset($star2)) ? $star2 : 0 ?> kali Penilaian <br>
                                    <?= showRating(1, 20) ?> : <?= (isset($star1)) ? $star1 : 0 ?> kali Penilaian
                                </td>
                        <?php endif ?>
                    </tr>
                </tbody>
            </table>
        </p>
        <?php if ($idTeknisi == 'all'): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID</th>
                            <th>Nama Teknisi</th>
                            <th>No. HP</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Status Akun</th>
                            <th>Rating (dari 5 Bintang)</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($teknisiAll) > 0) : ?>
                            <?php foreach ($teknisiAll AS $teknisi) : ?>
                                <tr>
                                    <td style="text-align: center;">
                                        <?php echo $i; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $teknisi['id_teknisi']; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $teknisi['nama_lengkap']; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $teknisi['no_hp']; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $teknisi['email']; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo $teknisi['alamat']; ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo normalizeString($teknisi['status_akun'], 'ucf'); ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php 
                                            $totalRating = 0;
                                            $star5 = getTeknisiCountRatingByIdTeknisi($teknisi['id_teknisi'], 5);
                                            $star4 = getTeknisiCountRatingByIdTeknisi($teknisi['id_teknisi'], 4);
                                            $star3 = getTeknisiCountRatingByIdTeknisi($teknisi['id_teknisi'], 3);
                                            $star2 = getTeknisiCountRatingByIdTeknisi($teknisi['id_teknisi'], 2);
                                            $star1 = getTeknisiCountRatingByIdTeknisi($teknisi['id_teknisi'], 1);
                                            $totalRating = calculateAllRating(
                                                array(
                                                    array('star' => 5, 'count' => $star5),
                                                    array('star' => 4, 'count' => $star4),
                                                    array('star' => 3, 'count' => $star3),
                                                    array('star' => 2, 'count' => $star2),
                                                    array('star' => 1, 'count' => $star1)
                                                )
                                            );
                                            echo (isset($totalRating)) ? $totalRating : 0 ; 
                                        ?>
                                    </td>
                                    <td style="text-align: center;">
                                        <?php echo format($teknisi['tgl_daftar'], 'date'); ?>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="11" style="text-align: center; vertical-align: middle; margin: 48% 0% 40% 0%; padding: auto;">
                                    Tidak ada Data Teknisi..!
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
                    <tr>
                        <td style="vertical-align: top;">
                            Jumlah Teknisi
                        </td>
                        <td style="vertical-align: top;">
                            :
                        </td>
                        <td>
                            <?php echo mysqli_num_rows($teknisiAll); ?> Orang
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Aktif
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?php echo $countTeknisiAktif; ?> Orang
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tidak Aktif
                        </td>
                        <td>
                            :
                        </td>
                        <td>
                            <?php echo $countTeknisiNonAktif; ?> Orang
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endif ?>
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
	$dompdf->stream("Laporan_Data_Teknisi_" . $dateNow . ".pdf", array("Attachment" => 0));

	// exit(0);
?>