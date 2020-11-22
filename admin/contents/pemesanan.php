<?php
    if (isset($_GET['page'])) {
        $page = antiInjection($_GET['page']);
    } else {
        $page = 1;
    }

    if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
        class_static_value::$record_count = $_GET['record_count'];
    }

    $pemesananAll = getPemesananSubJoinLimitAll($page, $csv::$record_count, 'tunggu', "");

    $pagination = new Zebra_Pagination();
    $pagination->records(mysqli_num_rows(getPemesananSubJoinAll('tunggu')));
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
                            <p>
                                <a class="btn btn-primary float-left" href="?content=pemesanan_form&action=tambah">
                                    <i class="fas fa-plus"></i>
                                    Tambah
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <!-- <div class="form-inline" id="record_form" >
                                    <div class="form-group form-group-md">
                                        <label class="control-label" for="record_per_page">Record per Page :&nbsp; </label>
                                        <select class="form-control" id="record_per_page" onchange="refreshPageForChangeRecordCount('<?php //echo $_GET['content']; ?>');">
                                            <option
                                                value="3"
                                                <?php //if (class_static_value::$record_count == 3): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                3
                                            </option>
                                            <option
                                                value="5"
                                                <?php //if (class_static_value::$record_count == 5): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                5
                                            </option>
                                            <option
                                                value="10"
                                                <?php //if (class_static_value::$record_count == 10): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                10
                                            </option>
                                            <option
                                                value="20"
                                                <?php //if (class_static_value::$record_count == 20): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                20
                                            </option>
                                            <option
                                                value="50"
                                                <?php //if (class_static_value::$record_count == 50): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                50
                                            </option>
                                            <option
                                                value="100"
                                                <?php //if (class_static_value::$record_count == 100): ?>
                                                    selected
                                                <?php //endif ?>
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
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="kata_kunci"
                                            id="kata_kunci"
                                            placeholder="Kata Kunci Pencarian"
                                            onchange="search(
                                                <?php echo $page; ?>,
                                                <?php echo $_SESSION['record-count']; ?>,
                                                '<?php echo $_GET['content']; ?>_admin',
                                                $('input#kata_kunci').val()
                                            );"
                                        />
                                    </div>
                                    <button
                                        class="btn btn-secondary mb-2"
                                        onclick="search(
                                            <?php echo $page; ?>,
                                            <?php echo $_SESSION['record-count']; ?>,
                                            '<?php echo $_GET['content']; ?>_admin',
                                            $('input#kata_kunci').val()
                                        );"
                                    >
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
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data_list">
                                <?php if (mysqli_num_rows($pemesananAll) <= 0) : ?>
                                    <tr>
                                        <td colspan="6">
                                            <center>
                                                Tidak ada data..!
                                            </center>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php while ($data = mysqli_fetch_array($pemesananAll, MYSQLI_BOTH)) : ?>
                                        <tr>
                                            <td><?php echo $data['tanggal_pesan']; ?></td>
                                            <td><?php echo $data['nama_pelanggan']; ?></td>
                                            <td><?php echo $data['tanggal_kerja']; ?></td>
                                            <td>
                                                <?php echo setBadges($data['status_pemesanan']); ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $pembayaran = mysqli_num_rows(getBuktiPembayaranByIdPemesanan($data[0], ''));
                                                ?>
                                                <?php if ($pembayaran < 1) : ?>
                                                    <?php echo setBadges("Belum Membayar", "danger"); ?>
                                                <?php else : ?>
                                                    <?php echo setBadges("Sudah Membayar", "success"); ?>
                                                    <button
                                                        class="btn btn-link btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modal_bukti_pembayaran"
                                                        data-id="<?php echo $data['id_pemesanan']; ?>"
                                                        data-content="<?php echo $content; ?>"
                                                        id="bukti_pembayaran"
                                                    >
                                                        Lihat Bukti Pembayaran
                                                    </button>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <?php if ($data['status_pemesanan'] == 'tunggu' AND $pembayaran < 1 AND $data['id_teknisi'] == 0 AND $data['teknisi_check'] == 'belum') : ?>
                                                    <a
                                                        class="btn btn-primary btn-sm"
                                                        href="?content=pemesanan_persetujuan&action=pilih_teknisi&id=<?php echo $data[0]; ?>"
                                                    >
                                                        <i class="fas fa-user-check"></i>
                                                        Pilih Teknisi
                                                    </a>
                                                <?php //elseif ($data['status_pemesanan'] == 'tunggu' AND $pembayaran >= 1 AND $data['id_teknisi'] != 0 AND $data['teknisi_check'] == 'sudah') : ?>
                                                    <!-- <a
                                                        class="btn btn-primary btn-sm"
                                                        href="?content=pemesanan_persetujuan&action=persetujuan&id=<?php //echo $data['id_pemesanan']; ?>"
                                                    >
                                                        Approval
                                                    </a> -->
                                                <?php elseif ($data['status_pemesanan'] == 'tunggu' AND $pembayaran >= 1 AND $data['id_teknisi'] != 0 AND $data['teknisi_check'] == 'sudah' AND (mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], 'panjar'))['konfirmasi_admin'] == 'belum')) : ?>
                                                    <a
                                                        class="btn btn-primary btn-sm"
                                                        href="?content=pemesanan_persetujuan&action=konfirmasi_pembayaran_panjar&id=<?php echo $data['id_pemesanan']; ?>"
                                                    >
                                                        <i class="fas fa-check-circle"></i>
                                                        Konfirmasi Pembayaran Panjar
                                                    </a>
                                                <?php elseif ($data['status_pemesanan'] == 'proses' AND $pembayaran >= 1 AND $data['id_teknisi'] != 0 AND $data['teknisi_check'] == 'selesai' AND (mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], 'lunas'))['konfirmasi_admin'] == 'belum')) : ?>
                                                    <a
                                                        class="btn btn-primary btn-sm"
                                                        href="?content=pemesanan_persetujuan&action=konfirmasi_pembayaran_lunas&id=<?php echo $data['id_pemesanan']; ?>"
                                                    >
                                                        <i class="fas fa-check-circle"></i>
                                                        Konfirmasi Pembayaran Lunas
                                                    </a>
                                                <?php endif ?>
                                                
                                                <a
                                                    class="btn btn-dark btn-sm"
                                                    href="?content=diagnosis&action=lihat&id=<?php echo $data[0]; ?>"
                                                >
                                                    <i class="fas fa-list"></i>
                                                    Rincian
                                                </a>
                                                <!-- <button
                                                    class="btn btn-dark btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modal_detail_pemesanan"
                                                    data-id="<?php //echo $data['id_pemesanan']; ?>"
                                                    data-content="<?php //echo $content; ?>"
                                                    id="detail_pemesanan"
                                                >
                                                    Rincian
                                                </button>  -->
                                                <!-- href="?content=pemesanan_detail&id=<?php //echo $data['id_pemesanan']; ?>"  -->
                                                <!-- <a
                                                    class="btn btn-info btn-sm"
                                                    href="?content=pemesanan_form&action=ubah&id=<?php //echo $data['id_pemesanan']; ?>"
                                                >
                                                    Ubah
                                                </a>
                                                <a
                                                    class="btn btn-danger btn-sm"
                                                    href="?content=pemesanan_proses&proses=remove&id=<?php //echo $data['id_pemesanan']; ?>"
                                                    onclick="return confirm('Anda yakin ingin menghapus data ini..?');"
                                                >
                                                    Hapus
                                                </a> -->
                                            </td>
                                        </tr>
                                    <?php endwhile ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                    <p>
                        <?php $pagination->render();?>
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