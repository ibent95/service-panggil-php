<?php
    $pelangganAll = getPelangganAll();
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Pengguna</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Data Pengguna</li>
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
                    <h4>Daftar Pimpinan</h4>
                </div>
                
                <div class="card-body">

                    <p class="pull-left">
                        <a class="btn btn-primary" href="?content=data_pengguna_pelanggan_form&action=tambah">
                            Tambah Data
                        </a>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pengguna</th>
                                    <th>Alamat</th>
                                    <th>No. Handphone</th>
                                    <th>Jenis Akun</th>
                                    <th>Status Akun</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
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
                                                <?php echo $data['id']; ?>
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
                                                <?php echo $data['jenis_akun']; ?>
                                            </td>
                                            <td>
                                                <?php echo $data['status_akun']; ?>
                                            </td>
                                            <td>
                                                <a 
                                                    class="btn btn-primary btn-sm"
                                                    href="?content=data_pengguna_pelanggan_form&action=ubah&id=<?php echo $data['id']; ?>"
                                                >
                                                    Ubah
                                                </a>
                                                <a 
                                                    class="btn btn-danger btn-sm" 
                                                    href="?content=data_pengguna_pelanggan_proses&proses=remove&id=<?php echo $data['id']; ?>"
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

<!-- Modal -->
<div 
    class="modal" 
    tabindex="-1" 
    role="dialog" 
    aria-labelledby="pengguna_detail_label" 
    aria-hidden="true"
    id="pengguna_detail" 
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
                    <tbody>
                        <tr>
                            <td>Isi 1</td>
                            <td>Isi 2</td>
                            <td>Isi 3</td>
                            <td>Isi 4</td>
                            <td>Isi 5</td>
                        </tr>
                        <tr>
                            <td>Isi 1</td>
                            <td>Isi 2</td>
                            <td>Isi 3</td>
                            <td>Isi 4</td>
                            <td>Isi 5</td>
                        </tr>
                        <tr>
                            <td>Isi 1</td>
                            <td>Isi 2</td>
                            <td>Isi 3</td>
                            <td>Isi 4</td>
                            <td>Isi 5</td>
                        </tr>
                        <tr>
                            <td>Isi 1</td>
                            <td>Isi 2</td>
                            <td>Isi 3</td>
                            <td>Isi 4</td>
                            <td>Isi 5</td>
                        </tr>
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