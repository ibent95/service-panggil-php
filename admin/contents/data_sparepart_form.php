<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=data_sparepart')</script>";
    }
    if ($action == 'ubah') {
        $sparepart = mysqli_fetch_assoc(
            getSparepartById($id)
        );
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Sparepart</h3> 
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="?content=data_layanan">Data Sparepart</a>
            </li>
            <li class="breadcrumb-item active">
                <a href="?content=data_layanan_kategori_form">Form Data Sparepart</a>
            </li>
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
                    <h4>Form Data Sparepart</h4>
                </div>
                
                <div class="card-body">
                    <?php getNotifikasi(); ?>
                    <form 
                        class="form-horizontal" 
                        <?php if ($action == 'tambah'): ?>
                            action="?content=data_sparepart_proses&proses=add" 
                        <?php else: ?>
                            action="?content=data_sparepart_proses&proses=edit"
                        <?php endif ?>
                        method="POST"
                    >
                        
                        <?php if ($action == 'ubah'): ?>
                            <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                        <?php endif ?>

                        <div class="form-group">
                            <label for="nama_sparepart" class="col-md-3 control-label">Nama Kategori</label>
                            <div class="col-md-12">
                                <input 
                                    type="text" 
                                    class="form-control input-rounded input-focus"
                                    name="nama_sparepart" 
                                    placeholder="Masukan Nama Sparepart..."
                                    id="nama_sparepart"
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $sparepart['nama_sparepart']; ?>"
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
                                    min="1" 
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $sparepart['harga']; ?>"
                                    <?php endif ?>
                                />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="persediaan" class="control-label col-md-3">Persediaan</label>
                            <div class="col-md-5">
                                <input 
                                    type="number" 
                                    class="form-control input-rounded input-focus" 
                                    name="persediaan" 
                                    placeholder="Masukan Persediaan..." 
                                    id="persediaan" 
                                    min="1" 
                                    <?php if ($action == 'ubah'): ?>
                                        value="<?php echo $sparepart['persediaan']; ?>"
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