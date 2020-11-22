<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_layanan_jenis_hardware')</script>";
    }
    $kategoriAll = getKategoriAll();
    if ($action == 'ubah') {
        $jenis = mysqli_fetch_assoc(
            getJenisHardwareById($id)
        );
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Layanan</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item">Data Layanan</li>
            <li class="breadcrumb-item">
                <a href="?content=data_layanan_jenis">Data Jenis Layanan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?content=data_layanan_jenis_hardware">Kategori Hardware</a>
            </li>
            <li class="breadcrumb-item active">Tambah Data Jenis Layanan Kategori Hardware</li>
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
                    <h4>Form Data Jenis Layanan Kategori Hardware</h4>
                </div>

                <div class="card-body">
                    <form
                        class="form-horizontal"
                        <?php if ($action == 'tambah'): ?>
                            action="?content=data_layanan_jenis_hardware_proses&proses=add"
                        <?php else: ?>
                            action="?content=data_layanan_jenis_hardware_proses&proses=edit"
                        <?php endif ?>
                        method="POST"
                    >
                        <?php if ($action == 'ubah'): ?>
                            <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                        <?php endif ?>
                        <div class="form-group">
                            <label for="nama_layanan" class="col-md-3 control-label">Kategori Layanan</label>
                            <div class="col-md-12">
                                <select class="form-control input-rounded input-focus" name="id_kategori" id="id_kategori">
                                    <option value="">-- Silahakan Pilih Kategori --</option>
                                    <?php foreach ($kategoriAll as $data): ?>
                                        <option
                                            value="<?php echo $data['id_layanan_kategori']; ?>"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($jenis['id_kategori'] == $data['id_layanan_kategori']): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            <?php echo $data['nama_kategori_layanan']; ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nama_layanan" class="col-md-3 control-label">Nama Jenis Layanan</label>
                            <div class="col-md-12">
                                <input
                                    type="text"
                                    class="form-control input-rounded input-focus"
                                    name="nama_jenis_layanan"
                                    placeholder="Masukan Nama Layanan..."
                                    id="nama_layanan"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $jenis['nama_jenis_layanan']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="harga" class="control-label col-md-3">Harga (Rp)</label>
                            <div class="col-md-5">
                                <input
                                    type="number"
                                    class="form-control input-rounded input-focus"
                                    name="harga"
                                    placeholder="Masukan Harga..."
                                    id="harga"
                                    min="10000"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $jenis['harga']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi_jenis_layanan" class="control-label col-md-3">Deskripsi Jenis Layanan</label>
                            <script src="<?= $csv::$URL_BASE ?>/assets/lib/editor/ckeditor/ckeditor.js"></script>
                            <div class="col-md-12">
                                <textarea class="deskripsi_jenis_layanan" name="deskripsi_jenis_layanan" id="deskripsi_jenis_layanan" placeholder="Masukan Deskripsi dari Jenis Layanan..."><?php if ($action == 'ubah') echo $jenis['deskripsi_jenis_layanan']; ?></textarea>
                            </div>
                            <script>CKEDITOR.replace( 'deskripsi_jenis_layanan' );</script>
                        </div>
                        <div class="form-group pull-left">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" name="simpan"/>
                                <input type="reset" class="btn btn-danger"/>
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