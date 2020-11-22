<?php

    require_once 'load_files.php';

    include_once 'plugins/dompdf/autoload.inc.php';

	$dateNow = date('Y-m-d');
	$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;

	$pemesanan = mysqli_fetch_array(
		getPemesananById($id), 
		MYSQLI_BOTH
	);

    $diagnosisSoftware  = getDetailPemesananByIdPemesanan($id, 'software', '', 'ya', 'ASC');
    $diagnosisHardware  = getDetailPemesananByIdPemesanan($id, 'hardware', '', 'ya', 'ASC');
    $diagnosisSparepart = getDetailPemesananByIdPemesanan($id, 'sparepart', '', 'ya', 'ASC');
    $biayaTambahan      = getDetailPemesananByIdPemesanan($id, 'biaya_tambahan', '', 'ya', 'ASC');
    $riwayatPembayaran  = getBuktiPembayaranByIdPemesanan($id, '', 'ASC');
    $sisaPembayaran     = 0;
    foreach ($diagnosisSoftware as $data) {
        $sisaPembayaran += $data['harga'];
    }
    foreach ($diagnosisHardware as $data) {
        $sisaPembayaran += $data['harga'];
    }
    foreach ($diagnosisSparepart as $data) {
        $sisaPembayaran += $data['harga'];
    }
    foreach ($biayaTambahan as $data) {
        $sisaPembayaran += $data['harga_biaya_tambahan'];
    }
    foreach ($riwayatPembayaran as $data) {
        if ($data['konfirmasi_admin'] == 'ya' OR $data['konfirmasi_admin'] == 'belum') {
            $sisaPembayaran -= $data['jumlah'];
        }
    }
    $pemesanan['status_pembayaran'] = (mysqli_num_rows($riwayatPembayaran) !== 0 AND $sisaPembayaran === 0) ? "Lunas" : "Belum Lunas" ;
    if (!empty($pemesanan['longlat'])) {
        $longlat = explode(",", $pemesanan['longlat']);
    } else {
        $longlat[0] = 0;
        $longlat[1] = 0;
    }
    $no         = 1;
    $totalHarga = 0;
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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Nota Transaksi</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<style>
            .text-center {
                text-align: center;
            }
            .text-right {
                text-align: right;
            }
            .text-left {
                text-align: left;
            }
            .font-weight-bold {
            	font-weight: bold;
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
        <p class="text-dark">
            <h2 class="text-center">Nota Transaksi</h2>
        </p>
		<div class="">
			<table>
				<tbody>
					<tr>
						<td>No. Transaksi</td>
						<td>:</td>
						<td><?php echo $pemesanan['no_pemesanan']; ?></td>
					</tr>
					<tr>
						<td>Tanggal</td>
						<td>:</td>
						<td><?php echo $pemesanan['tanggal_pesan']; ?></td>
					</tr>
					<tr>
						<td>Nama Pelanggan</td>
						<td>:</td>
						<td><?php echo $pemesanan['nama_pelanggan']; ?></td>
					</tr>
					<tr>
						<td>No. Telp</td>
						<td>:</td>
						<td><?php echo $pemesanan['no_telp']; ?></td>
					</tr>
					<tr>
						<td>Datang ke Lokasi</td>
						<td>:</td>
						<td><?php echo $pemesanan['datang_ke_lokasi']; ?></td>
					</tr>
					<!-- <?php //if ($pemesanan['keluhan'] != null OR $pemesanan['keluhan'] != '') : ?>
						<tr>
							<td>Keluhan</td>
							<td>:</td>
							<td><?php //echo $pemesanan['keluhan']; ?></td>
						</tr>
					<?php //endif ?> -->
					<?php if ($pemesanan['datang_ke_lokasi'] != 'tidak') : ?>
						<tr>
							<td>Tanggal Kerja</td>
							<td>:</td>
							<td><?php echo $pemesanan['tanggal_kerja']; ?></td>
						</tr>
						<tr>
							<td>Alamat</td>
							<td>:</td>
							<td><?php echo $pemesanan['alamat']; ?></td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
		</div>
        <label for="table" class="">Data Pengerjaan</label>
        <!-- <div class="table-responsive"> -->
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($diagnosisSoftware) == 0 AND mysqli_num_rows($diagnosisHardware) == 0 AND mysqli_num_rows($diagnosisSparepart) == 0 AND mysqli_num_rows($biayaTambahan) == 0) : ?>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <?php if ($pemesanan['status_pemesanan'] == 'selesai' OR $pemesanan['status_pemesanan'] == 'batal') : ?>
                                    Tidak
                                <?php elseif ($pemesanan['status_pemesanan'] == 'tunggu' OR $pemesanan['status_pemesanan'] == 'proses') : ?>
                                    Belum
                                <?php endif ?>
                                ada Pengerjaan..!
                            </td>
                        </tr>
                    <?php else : ?>
                        <?php if (mysqli_num_rows($diagnosisSoftware) > 0) : ?>
                            <tr>
                                <td class="text-left font-weight-bold" colspan="2">
                                    &nbsp;&nbsp; Software
                                </td>
                            </tr>
                            <?php foreach ($diagnosisSoftware as $data): ?>
                                <tr>
                                    <td>
                                        <?php
                                            echo $no . ". " . $data['nama_jenis_layanan'];
                                            $no++;
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                            echo format($data['harga'], 'currency');
                                            $totalHarga = $totalHarga + $data['harga'];
                                        ?>

                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                        <?php if (mysqli_num_rows($diagnosisHardware) > 0) : ?>
                            <tr>
                                <td class="text-left font-weight-bold" colspan="2">
                                    &nbsp;&nbsp;  Hardware
                                </td>
                            </tr>
                            <?php foreach ($diagnosisHardware as $data): ?>
                                <tr>
                                    <td>
                                        <?php
                                            echo $no . ". " . $data['nama_jenis_layanan'];
                                            $no++;
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                            echo format($data['harga'], 'currency');
                                            $totalHarga = $totalHarga + $data['harga'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                        <?php if (mysqli_num_rows($diagnosisSparepart) > 0) : ?>
                            <tr>
                                <td class="text-left font-weight-bold" colspan="2">
                                    &nbsp;&nbsp;  Sparepart
                                </td>
                            </tr>
                            <?php foreach ($diagnosisSparepart as $data): ?>
                                <tr>
                                    <td>
                                        <?php
                                            echo $no . ". " . $data['nama_sparepart'];
                                            $no++;
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                            echo format($data['harga'], 'currency');
                                            $totalHarga = $totalHarga + $data['harga'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                        <?php if (mysqli_num_rows($biayaTambahan) > 0) : ?>
                            <tr>
                                <td class="text-left font-weight-bold" colspan="2">
                                    &nbsp;&nbsp;  Biaya Tambahan
                                </td>
                            </tr>
                            <?php foreach ($biayaTambahan as $data): ?>
                                <tr>
                                    <td>
                                        <?php
                                            echo $no . ". " . $data['keterangan'];
                                            $no++;
                                        ?>
                                    </td>
                                    <td class="text-right">
                                        <?php
                                            echo format($data['harga_biaya_tambahan'], 'currency');
                                            $totalHarga = $totalHarga + $data['harga_biaya_tambahan'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    <?php endif ?>
                    <tr style="font-weight: bold;">
                        <td style="text-align: right;">
                            <?php if ($pemesanan['status_pemesanan'] == 'selesai') : ?>
                                Total Harga
                            <?php else : ?>
                                Total Estimasi
                            <?php endif ?>
                        </td>
                        <td class="font-weight-bold text-right">
                            <?php echo format($totalHarga, 'currency'); ?>
                        </td>
                    </tr>
                    <!-- Riwayat Pembayaran -->
                    <?php if (mysqli_num_rows($riwayatPembayaran) > 0) : ?>

                        <tr style="font-weight: bold;">
                            <td style="text-align: left;" colspan="2">
                            	&nbsp;&nbsp; Riwayat Pembayaran
                            </td>
                        </tr>
                        <?php foreach ($riwayatPembayaran as $pembayaran): ?>
                            <?php if ($pembayaran['konfirmasi_admin'] == 'ya' OR $pembayaran['konfirmasi_admin'] == 'belum'): ?>
                                <tr>
                                    <td>
                                        <?php
                                            echo $no . ". ";
                                            $no++;
                                        ?>
                                        Pembayaran <?php echo $pembayaran['info_pembayaran']; ?> tanggal <?php echo format($pembayaran['tgl_pembayaran'], "date"); ?>

                                    </td>
                                    <td class="text-right">
                                        <?php
                                            echo format($pembayaran['jumlah'], "currency");
                                            $totalHarga = $totalHarga - $pembayaran['jumlah'];
                                        ?>
                                    </td>
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                    <tr>
                        <td class="text-right font-weight-bold">
                            <?php //if ($pemesanan['status_pemesanan'] == 'proses' AND $pemesanan['teknisi_check'] == 'selesai') : ?>
                                Sisa Pembayaran
                            <?php //else : ?>
                                <!-- Total Estimasi -->
                            <?php //endif ?>
                        </td>
                        <td class="font-weight-bold text-right">
                            <?php echo format($totalHarga, 'currency'); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <!-- </div> -->
    </body>
</html>
<?php
    $html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();

	// (Optional) Setup the paper size and orientation
	// $dompdf->setPaper('A4', 'potrait');
	$dompdf->setPaper(array(0, 0, 550, 600));

	$dompdf->loadHtml(utf8_encode($html));

	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream("Nota_" . $pemesanan['no_pemesanan'] . "_" . $dateNow . ".pdf", array("Attachment" => 0));

	// exit(0);
?>