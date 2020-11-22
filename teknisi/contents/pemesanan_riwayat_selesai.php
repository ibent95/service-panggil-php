<?php
    if (isset($_GET['page'])) {
        $page = antiInjection($_GET['page']);
    } else {
        $page = 1;
    }

    if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
        class_static_value::$record_count = $_GET['record_count'];
    }

    $pemesananAll = getPemesananSubJoinLimitByIdTeknisi($page, class_static_value::$record_count, 'selesai', $_SESSION['id']);

    $pagination = new Zebra_Pagination();
    $pagination->records(mysqli_num_rows(getPemesananSubJoinByIdTeknisi('selesai', $_SESSION['id'])));
    $pagination->records_per_page(class_static_value::$record_count);
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Transaksi</h3> 
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item">Riwayat Transaksi</li>
            <li class="breadcrumb-item active">Selesai</li>
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
                    <h4>Daftar Transaksi yang Telah Selesai</h4>
                </div>
                
                <div class="card-body">
                    
                    <?php getNotifikasi(); ?>
                    
                    <!-- <div class="row">
                        <div class="col-md-6">
                            <p>
                                <a class="btn btn-primary float-left" href="?content=pemesanan_form&action=tambah">
                                    Tambah Data
                                </a>    
                            </p>
                        </div>
                    </div> -->
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
                                                <?php echo class_static_value::$record_count; ?>,
                                                '<?php echo $_GET['content']; ?>', 
                                                $('input#kata_kunci').val()
                                            );"
                                        />
                                    </div>
                                    <button 
                                        class="btn btn-secondary mb-2" 
                                        onclick="search(
                                            <?php echo $page; ?>, 
                                            <?php echo class_static_value::$record_count; ?>,
                                            '<?php echo $_GET['content']; ?>', 
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
                                    <th>Nama Teknisi</th>
                                    <th>Status Transaksi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data_list">
                                <?php if (mysqli_num_rows($pemesananAll) <= 0): ?>
                                    <tr>
                                        <td colspan="6">
                                            <center>
                                                Tidak ada data..!
                                            </center>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php while ($data = mysqli_fetch_array($pemesananAll, MYSQLI_BOTH)): ?>
                                        <tr>
                                            <td><?php echo $data['tanggal_pesan']; ?></td>
                                            <td><?php echo $data[17]; ?></td>
                                            <td><?php echo $data['tanggal_kerja']; ?></td>
                                            <td><?php echo $data[26]; ?></td>
                                            <td><?php echo setBadges($data['status_pemesanan']); ?></td>
                                            <td>
                                                <!-- <a 
                                                    class="btn btn-primary btn-sm"
                                                    href="?content=pemesanan_persetujuan&action=persetujuan&id=<?php //echo $data[0]; ?>"
                                                >
                                                    Approval
                                                </a> -->
                                                <a 
                                                    class="btn btn-dark btn-sm"
                                                    href="?content=diagnosis&action=lihat&id=<?php echo $data[0]; ?>"
                                                >
                                                    Rincian
                                                </a>
                                                <!-- <button 
                                                    class="btn btn-dark btn-sm"
                                                    data-toggle="modal" 
                                                    data-target="#modal_detail_pemesanan"
                                                    data-id="<?php //echo $data[0]; ?>"
                                                    data-content="<?php //echo $content; ?>"
                                                    id="detail_pemesanan"
                                                >
                                                    Rincian
                                                </button> -->
                                                <!-- <a 
                                                    class="btn btn-info btn-sm"
                                                    href="?content=pemesanan_form&action=ubah&id=<?php //echo $data[0]; ?>"
                                                >
                                                    Ubah
                                                </a>
                                                <a 
                                                    class="btn btn-danger btn-sm" 
                                                    href="?content=pemesanan_proses&proses=remove&id=<?php //echo $data[0]; ?>"
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

<div 
    class="modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="pengguna_detail_label" 
    aria-hidden="true"
    id="pemesanan_detail" 
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pengguna_detail_label">Modal title</h5>
                <button 
                    class="btn-lg close" 
                    data-dismiss="modal" 
                    aria-label="Close"
                    style="margin-top: 0; margin-bottom: 0; padding-top: 6px; padding-bottom: 2px;" 
                >
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table ">
                    <thead>
                        <tr>
                            <th>Column 1</th>
                            <th>Column 2</th>
                            <th>Column 3</th>
                            <th>Column 4</th>
                            <th>Column 5</th>
                        </tr>
                    </thead>
                    <tbody id="data_list">
                        
                    </tbody>
                </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>