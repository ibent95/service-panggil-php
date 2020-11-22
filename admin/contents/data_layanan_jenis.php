<?php
    $jenisLayananAll = getJenisLayananAll();
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Layanan</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item">Data Layanan</li>
            <li class="breadcrumb-item active">Data Jenis Layanan</li>
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
                    <h4>Daftar Layanan</h4>
                </div>
                
                <div class="card-body">

                    <p class="pull-left">
                        <a class="btn btn-primary" href="?content=data_layanan_jenis_form&action=tambah">
                            Tambah Data
                        </a>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kategori Layanan</th>
                                    <th>Nama Layanan</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($jenisLayananAll) == 0): ?>
                                    <tr>
                                        <td colspan="4">
                                            <center>
                                                Tidak ada data..!
                                            </center>
                                        </td>
                                    </tr>
                                <?php endif ?>
                                <?php if (mysqli_num_rows($jenisLayananAll) >= 1): ?>
                                    <?php foreach ($jenisLayananAll as $data): ?>
                                        <tr>
                                            <td><?php echo $data['id_kategori']; ?></td>
                                            <td><?php echo $data['nama_jenis_layanan']; ?></td>
                                            <td><?php echo $data['harga']; ?></td>
                                            <td>
                                                <a 
                                                        class="btn btn-primary btn-sm"
                                                        href="?content=data_layanan_jenis_form&action=ubah&id=<?php echo $data['id']; ?>"
                                                    >
                                                        Ubah
                                                    </a>
                                                    <a 
                                                        class="btn btn-danger btn-sm" 
                                                        href="?content=data_layanan_jenis_proses&proses=remove&id=<?php echo $data['id']; ?>"
                                                        onclick="return confirm('Anda yakin ingin menghapus data ini..?');"
                                                    >
                                                        Hapus
                                                    </a>
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