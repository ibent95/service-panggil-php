<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_layanan_jenis')</script>";
    }
    $kategoriAll = getKategoriAll();
    if ($action == 'ubah') {
        $jenis = mysqli_fetch_assoc(
            getJenisLayananById($id)
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
            <li class="breadcrumb-item active">Tambah Data Layanan</li>
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
                    <h4>Form Data Layanan</h4>
                </div>

                <div class="card-body">
                    <form 
                        class="form-horizontal" 
                        <?php if ($action == 'tambah'): ?>
                            action="?content=data_layanan_jenis_proses&proses=add" 
                        <?php else: ?>
                            action="?content=data_layanan_jenis_proses&proses=edit"
                        <?php endif ?> 
                        method="POST"
                    >
                        
                        <div class="form-group">
                            <label for="nama_layanan" class="col-md-3 control-label">Kategori Layanan</label>
                            <div class="col-md-12">
                                <select class="form-control input-rounded input-focus" name="id_kategori" id="id_kategori">
                                    <option value="">-- Silahakan Pilih Kategori --</option>
                                    <?php foreach ($kategoriAll as $data): ?>
                                        <option 
                                            value="<?php echo $data['id']; ?>"
                                            <?php if ($action == 'ubah'): ?>
                                                <?php if ($jenis['id_kategori'] == $data['id']): ?>
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
