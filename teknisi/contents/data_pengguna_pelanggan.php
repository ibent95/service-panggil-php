<?php
    if (isset($_GET['page'])) {
        $page = antiInjection($_GET['page']);
    } else {
        $page = 1;
    }
    if (isset($_GET['record_count']) && !empty($_GET['record_count'])) {
        class_static_value::$record_count = $_GET['record_count'];
    }
    $pelangganAll = getPelangganLimitAll($page, class_static_value::$record_count);
    $pagination = new Zebra_Pagination();
    $pagination->records(mysqli_num_rows(getPelangganAll()));
    $pagination->records_per_page(class_static_value::$record_count);
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Pengguna</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Data Pengguna</li>
            <li class="breadcrumb-item active">Pelanggan</li>
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
                    <h4>Daftar Pelanggan</h4>
                </div>
                <div class="card-body">
                    <?php getNotifikasi(); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <?php if ($_SESSION['jenis_akun'] == 'admin') : ?>
                                <p class="pull-left">
                                    <a class="btn btn-primary" href="?content=data_pengguna_pelanggan_form&action=tambah">
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th>No. Handphone</th>
                                    <th>Status Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="data_list">
                                <?php if (mysqli_num_rows($pelangganAll) == 0): ?>
                                    <tr>
                                        <td colspan="6">
                                            <center>
                                                Tidak ada data..!
                                            </center>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php if (mysqli_num_rows($pelangganAll) >= 1): ?>
                                    <?php foreach ($pelangganAll as $data): ?>
                                        <tr>
                                            <td>
                                                <?php echo $data['id_pelanggan']; ?>
                                            </td>
                                            <td>
                                                <button
                                                    type="button"
                                                    class="btn btn-link" data-toggle="modal" data-target="#pengguna_detail"
                                                >
                                                    <?php echo $data['nama_lengkap']; ?>
                                                </button>
                                            </td>
                                            <td>
                                                <?php echo $data['alamat']; ?>
                                            </td>
                                            <td>
                                                <?php echo $data['no_hp']; ?>
                                            </td>
                                            <td>
                                                <?php echo setBadges($data['status_akun'], 'success'); ?>
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-dark btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#modal_detail_pengguna"
                                                    data-id="<?php echo $data['id_pelanggan']; ?>"
                                                    data-content="<?php echo $content; ?>"
                                                    id="detail_pengguna"
                                                >
                                                    Rincian
                                                </button>
                                                <!-- <a
                                                    class="btn btn-primary btn-sm"
                                                    href="?content=data_pengguna_pelanggan_form&action=ubah&id=<?php //echo $data['id']; ?>"
                                                >
                                                    Ubah
                                                </a>
                                                <a
                                                    class="btn btn-danger btn-sm"
                                                    href="?content=data_pengguna_pelanggan_proses&proses=remove&id=<?php //echo $data['id']; ?>"
                                                    onclick="return confirm('Anda yakin ingin menghapus data ini..?');"
                                                >
                                                    Hapus
                                                </a> -->
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Card Body -->
            </div>
            <!-- End Card -->
        </div>
        <!-- End Coloumn -->
    </div>
    <!-- End Row -->
</div>