<?php
    if (isset($_GET['page'])) {
        $page = antiInjection($_GET['page']);
    } else {
        $page = 1;
    }

    // if (isset($_POST['record_count']) && !empty($_POST['record_count'])) {
    //     class_static_value::setRecordCount($_POST['record_count']);
    // }

    $jenisSoftwareAll = getJenisSoftwareJoinKategoriLimitAll($page, $_SESSION['record-count']);

    $pagination = new Zebra_Pagination();

    $pagination->records(mysqli_num_rows(getJenisSoftwareJoinKategoriAll()));
    $pagination->records_per_page((int) $_SESSION['record-count']);
    // $pagination->labels('Previous', 'Next');

?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Layanan</h3> 
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item">Data Layanan</li>
            <li class="breadcrumb-item">Data Jenis Layanan</li>
            <li class="breadcrumb-item active">Kategori Hardware</li>
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
                    <h4>Daftar Jenis Layanan Kategori Software</h4>
                </div>
                <div class="card-body">
                    <?php getNotifikasi(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p>
                                <a class="btn btn-primary float-left" href="?content=data_layanan_jenis_software_form&action=tambah">
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
                                        <select class="form-control" id="record_per_page"
                                            onchange="
                                                refreshPageForChangeRecordCount(
                                                    <?php //echo "'" . $_GET['content'] . "'"; ?>
                                                );
                                            "
                                        >
                                            <option
                                                value="2"
                                                <?php //if ($_SESSION['record-count'] == 2): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                2
                                            </option>
                                            <option
                                                value="5"
                                                <?php //if ($_SESSION['record-count'] == 5): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                5
                                            </option>
                                            <option
                                                value="10"
                                                <?php //if ($_SESSION['record-count'] == 10): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                10
                                            </option>
                                            <option
                                                value="20"
                                                <?php //if ($_SESSION['record-count'] == 20): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                20
                                            </option>
                                            <option
                                                value="50"
                                                <?php //if ($_SESSION['record-count'] == 50): ?>
                                                    selected
                                                <?php //endif ?>
                                            >
                                                50
                                            </option>
                                            <option
                                                value="100"
                                                <?php //if ($_SESSION['record-count'] == 100): ?>
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
                                                '<?php echo $_GET['content']; ?>',
                                                $('input#kata_kunci').val()
                                            );"
                                        />
                                    </div>
                                    <button
                                        class="btn btn-secondary mb-2"
                                        onclick="search(
                                            <?php echo $page; ?>,
                                            <?php echo $_SESSION['record-count']; ?>,
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
                                    <th>Kategori Layanan</th>
                                    <th>Nama Layanan</th>
                                    <th class="text-right">Harga (Rp)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data_list">
                                <?php if (mysqli_num_rows($jenisSoftwareAll) == 0): ?>
                                    <tr>
                                        <td colspan="4">
                                            <center>
                                                Tidak ada data..!
                                            </center>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php if (mysqli_num_rows($jenisSoftwareAll) >= 1): ?>
                                    <?php while ($data = mysqli_fetch_array($jenisSoftwareAll, MYSQLI_BOTH)): ?>
                                        <tr>
                                            <td><?php echo $data['nama_kategori_layanan']; ?></td>
                                            <td><?php echo $data['nama_jenis_layanan']; ?></td>
                                            <td class="text-right"><?php echo format($data['harga'], 'currency'); ?></td>
                                            <td>
                                                <a
                                                        class="btn btn-primary btn-sm"
                                                        href="?content=data_layanan_jenis_software_form&action=ubah&id=<?php echo $data['id_layanan_jenis']; ?>"
                                                    >
                                                        <i class="fas fa-edit"></i>
                                                        Ubah
                                                    </a>
                                                    <a
                                                        class="btn btn-danger btn-sm"
                                                        href="?content=data_layanan_jenis_software_proses&proses=remove&id=<?php echo $data['id_layanan_jenis']; ?>"
                                                        onclick="return confirm('Anda yakin ingin menghapus data ini..?');"
                                                    >
                                                        <i class="fas fa-times"></i>
                                                        Hapus
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