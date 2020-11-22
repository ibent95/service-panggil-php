<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_konfigurasi_syarat_ketentuan')</script>";
    }
    if ($action == 'ubah') {
        $syaratKetentuan = mysqli_fetch_assoc(
            getSyaratKetentuanById($id)
        );
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Syarat & Ketentuan</h3> 
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active">Data Pengguna</li>
            <li class="breadcrumb-item active">Tambah Data Pengguna</li>
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
                    <h4>Form Data Konfigurasi Syarat &amp; Ketentuan</h4>
                </div>
                <div class="card-body">
                    <?php getNotifikasi(); ?>
                    <form
                        class="form-horizontal"
                        <?php if ($action == 'ubah') : ?>
                            action="?content=data_konfigurasi_syarat_ketentuan_proses&proses=edit"
                        <?php else: ?>
                            action="?content=data_konfigurasi_syarat_ketentuan_proses&proses=add"
                        <?php endif ?>
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <?php if ($action == 'ubah') : ?>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <?php endif ?>

                        <div class="form-group">
                            <label for="nama_lengkap" class="col-md-3 control-label">Deskripsi</label>
                            <div class="col-md-12">
                                <input
                                    type="text"
                                    class="form-control input-rounded input-focus"
                                    name="deskripsi_syarat_ketentuan"
                                    placeholder="Masukan Deskripsi..."
                                    id="deskripsi_syarat_ketentuan"
                                    <?php if ($action == 'ubah') : ?>
                                        value="<?php echo $syaratKetentuan['deskripsi_syarat_ketentuan']; ?>"
                                    <?php endif ?>
                                >
                            </div>
                        </div>

                        <div class="form-group pull-left">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
                                <input type="reset" class="btn btn-danger" value="Reset" />
                            </div>
                        </div>
                    </form>
                </div>
                <!-- End Card Body -->
            </div>
            <!-- End Card -->
        </div>
        <!-- End Coloumn -->
    </div>
    <!-- End Row -->
</div>