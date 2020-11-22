<?php
    if (isset($_GET['page'])) {
        $page = antiInjection($_GET['page']);
    } else {
        $page = 1;
    }
    if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
        class_static_value::$record_count = $_GET['record_count'];
    }
    $pemesananAll = getPemesananSubJoinLimitByIdTeknisi($page, $_SESSION['record-count'], 'proses', $_SESSION['id']);
    $technician = mysqli_fetch_array(getTeknisiById($_SESSION['id']), MYSQLI_BOTH);
    $pagination = new Zebra_Pagination();
    $pagination->records(mysqli_num_rows(getPemesananSubJoinByIdTeknisi('proses', $_SESSION['id'])));
    $pagination->records_per_page($_SESSION['record-count']);
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Transaksi</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Transaksi</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-title">
                    <h4>Daftar Transaksi</h4>
                </div>
                <div class="card-body">
                    <?php getNotifikasi(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($_SESSION['jenis_akun'] == 'admin') : ?>
                                <p>
                                    <a class="btn btn-primary float-left" href="?content=pemesanan_form&action=tambah">
                                        Tambah Data
                                    </a>
                                </p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <!-- <div class="form-inline" id="record_form" >
                                    <div class="form-group form-group-md">
                                        <label class="control-label" for="record_per_page">Record per Page :&nbsp; </label>
                                        <select class="form-control" id="record_per_page" onchange="refreshPageForChangeRecordCount('<?php //echo $_GET['content']; 
                                                                                                                                        ?>');">
                                            <option
                                                value="3"
                                                <?php //if (class_static_value::$record_count == 3): 
                                                ?>
                                                    selected
                                                <?php //endif 
                                                ?>
                                            >
                                                3
                                            </option>
                                            <option
                                                value="5"
                                                <?php //if (class_static_value::$record_count == 5): 
                                                ?>
                                                    selected
                                                <?php //endif 
                                                ?>
                                            >
                                                5
                                            </option>
                                            <option
                                                value="10"
                                                <?php //if (class_static_value::$record_count == 10): 
                                                ?>
                                                    selected
                                                <?php //endif 
                                                ?>
                                            >
                                                10
                                            </option>
                                            <option
                                                value="20"
                                                <?php //if (class_static_value::$record_count == 20): 
                                                ?>
                                                    selected
                                                <?php //endif 
                                                ?>
                                            >
                                                20
                                            </option>
                                            <option
                                                value="50"
                                                <?php //if (class_static_value::$record_count == 50): 
                                                ?>
                                                    selected
                                                <?php //endif 
                                                ?>
                                            >
                                                50
                                            </option>
                                            <option
                                                value="100"
                                                <?php //if (class_static_value::$record_count == 100): 
                                                ?>
                                                    selected
                                                <?php //endif 
                                                ?>
                                            >
                                                100
                                            </option>
                                        </select>
                                    </div>
                                </div> -->
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-auto">
                                <div class="form-inline float-right" id="cari">
                                    <div class="form-group form-group-md mx-sm-2 mb-2">
                                        <label for="kata_kunci" class="control-label">Pencarian :&nbsp; </label>
                                        <input type="text" class="form-control" name="kata_kunci" id="kata_kunci" placeholder="Kata Kunci Pencarian" onchange="search(
                                                <?php echo $page; ?>,
                                                <?php echo $_SESSION['record-count']; ?>,
                                                '<?php echo $_GET['content']; ?>',
                                                $('input#kata_kunci').val()
                                            );" />
                                    </div>
                                    <button class="btn btn-secondary mb-2" onclick="search(
                                            <?php echo $page; ?>,
                                            <?php echo $_SESSION['record-count']; ?>,
                                            '<?php echo $_GET['content']; ?>',
                                            $('input#kata_kunci').val()
                                        );">
                                        Cari
                                    </button>
                                </div>
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Tanggal Pengerjaan</th>
                                    <th>Status Transaksi</th>
                                    <th>Status Check</th>
                                    <!-- <th>Konfirmasi Pelanggan</th> -->
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data_list">
                                <?php if (mysqli_num_rows($pemesananAll) <= 0) : ?>
                                    <tr>
                                        <td colspan="8">
                                            <center>
                                                Tidak ada data..!
                                            </center>
                                        </td>
                                    </tr>
                                <?php else : ?>
                                    <?php while ($data = mysqli_fetch_array($pemesananAll, MYSQLI_BOTH)) : ?>
                                        <tr>
                                            <td><?php echo $data['tanggal_pesan']; ?></td>
                                            <td><?php echo $data['nama_pelanggan']; ?></td>
                                            <td><?php echo $data['tanggal_kerja']; ?></td>
                                            <td>
                                                <?php echo setBadges($data['status_pemesanan']); ?>
                                            </td>
                                            <td><?php echo setBadges($data['teknisi_check']); ?></td>
                                            <!-- <td>
                                                        <?php
                                                        // if ($data['teknisi_check'] == 'sudah' AND $data['persetujuan_pelanggan'] == 'belum') {
                                                        //     echo setBadges('menunggu');
                                                        // } else {
                                                        //     echo setBadges($data['persetujuan_pelanggan']);
                                                        // }
                                                        ?>
                                                    </td> -->
                                            <td>
                                                <?php
                                                $pembayaran = mysqli_num_rows(getBuktiPembayaranByIdPemesanan($data[0], ''));
                                                if ($pembayaran < 1) :
                                                    ?>
                                                    <?php echo setBadges("Belum Membayar", "danger"); ?>
                                                <?php else : ?>
                                                    <?php echo setBadges("Sudah Membayar", "success"); ?>
                                                    <button class="btn btn-link btn-sm" data-toggle="modal" data-target="#modal_bukti_pembayaran" <?php echo "data-id=\"" . $data['id_pemesanan'] . "\""; ?> <?php echo "data-content=\"" . $content . "\""; ?> id="bukti_pembayaran">
                                                        Lihat Bukti Pembayaran
                                                    </button>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <?php
                                                $lastCustomerAgreement    = getPersetujuanPelangganTerakhir($data['id_pemesanan']);
                                                $costumerPayment        = mysqli_num_rows(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], 'panjar'));
                                                // echo $lastCustomerAgreement . " " . $costumerPayment;
                                                ?>
                                                <?php if (($data['teknisi_check'] === 'belum' or $data['teknisi_check'] === 'sudah') and ($lastCustomerAgreement != 'tidak') and ($costumerPayment == 0)) : ?>
                                                    <a class="btn btn-primary btn-sm" <?php echo "href=\"?content=pemesanan_detail&action=konfirmasi&id=" . $data['id_pemesanan'] . "\""; ?>>
                                                        <i class="fas fa-edit"></i>
                                                        Konfirmasi
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" onclick="confirm('Apakah anda yakin ingin menolak transaksi ini..?', '<?php echo "?content=pemesanan_proses&proses=decline&id=" . $data['id_pemesanan']; ?>');">
                                                        <i class="fas fa-times"></i>
                                                        Tolak
                                                    </button>
                                                <?php elseif (($data['teknisi_check'] === 'sudah') and ($data['status_pemesanan'] == 'tunggu') and ($lastCustomerAgreement == 'ya') and (mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], 'panjar', 'DESC'))['konfirmasi_admin'] == 'ya')) : ?>
                                                    <a class="btn btn-danger btn-sm" <?php echo "href=\"?content=pemesanan_proses&proses=proccess_order&id=" . $data['id_pemesanan'] . "\""; ?>>
                                                        <i class="fas fa-edit"></i>
                                                        Proses
                                                    </a>
                                                <?php elseif (($data['teknisi_check'] === 'sudah') and ($lastCustomerAgreement != 'belum') and (mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], 'panjar'))['konfirmasi_admin'] == 'ya') AND ($technician['status_tersedia'] == 'tidak')) : ?>
                                                    <a class="btn btn-success btn-sm" <?php echo "href=\"?content=pemesanan_proses&proses=finish&id=" . $data['id_pemesanan'] . "\""; ?>>
                                                        <i class="fas fa-check"></i>
                                                        Selesai
                                                    </a>
                                                    <!-- <a
                                                                    class="btn btn-danger btn-sm"
                                                                    onclick="confirm('batal', '?content=pemesanan_proses&proses=cancel&id=<?php //echo $data['id_pemesanan']; 
                                                                                                                                            ?>', '<?php //echo $data['id_pemesanan']; 
                                                                                                                                                                                    ?>');"
                                                                >
                                                                    Batal
                                                                </a> -->
                                                    <!--
                                                                <a
                                                                    class="btn btn-warning btn-sm"
                                                                    <?php //echo "href=\"?content=pemesanan_detail&action=ubah&id=" . $data['id_pemesanan'] . "\""; 
                                                                    ?>
                                                                >
                                                                    Ubah
                                                                </a>
                                                                -->
                                                <?php elseif ($data['teknisi_check'] === 'selesai' AND $technician['status_tersedia'] == 'tidak') : ?>
                                                    <a class="btn btn-success btn-sm" <?php echo "href=\"?content=pemesanan_proses&proses=set_available\""; ?>>
                                                        <i class="fas fa-check"></i>
                                                        Available
                                                    </a>
                                                <?php endif ?>
                                                <a class="btn btn-dark btn-sm" <?php echo "href=\"?content=pemesanan_detail&action=lihat&id=" . $data['id_pemesanan'] . "\""; ?>>
                                                    <i class="fas fa-list"></i>
                                                    Rincian
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endwhile ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <p>
                        <?php $pagination->render(); ?>
                    </p>
                </div>
                <!-- End Card Body -->
            </div>
            <!-- End Card -->
        </div>
        <!-- End Coloumn -->
    </div>
    <!-- End Row -->
</div>