<?php
    $kategoriAll = getKategoriAll('ASC');
    $teknisiAll = getTeknisiAll('ASC');
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Laporan Transaksi</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Laporan</a></li>
            <li class="breadcrumb-item active">Laporan Transaksi</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->
<!-- Container fluid  -->
<div class="container-fluid">
    <div class="card">
        <div class="card-title">
            <h3>Laporan Transaksi</h3>
        </div>
        <div class="card-body">
            <?php getNotifikasi(); ?>
            <form class="form-horizontal" action="laporan_transaksi.php" method="POST" target="_blank">
                <div class="row">
                    
                    <!-- Left Side -->
                    <div class="offset-md-2 col-md-4">
                        <div class="form-group row">
                            <label class="control-label col-md-4 text-right">Tanggal Awal</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control input-rounded input-focus" name="tanggal_awal" id="tanggal_awal" placeholder="...Tanggal Awal..." />
                            </div>
                        </div>
                        <!-- Select2 CSS -->
                        <link rel="stylesheet" type="text/css" href="../assets/lib/select2/css/select2.min.css">
                        <link rel="stylesheet" type="text/css" href="../assets/lib/select2/css/select2-bootstrap.min.css">
                        <div class="form-group row">
                            <label class="control-label col-md-4 text-right">Pelanggan</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-lg input-rounded input-focus" name="id_pelanggan" id="select_id_pelanggan">
                                    <option value="">...Semua Pelanggan...</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 text-right">Kategori</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-lg input-rounded input-focus" name="id_kategori" id="id_kategori">
                                    <option value="">...Semua Kategori...</option>
                                    <?php if (mysqli_num_rows($kategoriAll) > 0) : ?>
                                        <?php foreach ($kategoriAll AS $data) : ?>
                                            <option value="<?php echo $data['id_layanan_kategori']; ?>"><?php echo $data['nama_kategori_layanan']; ?></option>
                                        <?php endforeach ?>
                                    <?php else : ?>
                                        <option value="">Belum Ada Data Nilai..!</option>
                                    <?php endif ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="col-md-4 mr-auto">
                        <div class="form-group row">
                            <label class="control-label col-md-4 text-right">Tanggal Akhir</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control input-rounded input-focus" name="tanggal_akhir" id="tanggal_akhir" placeholder="...Tanggal Akhir..." />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 text-right">Teknisi</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-lg input-rounded input-focus disabled" name="id_teknisi" id="id_teknisi" readonly>
                                    <!-- <option value="">...Semua Teknisi...</option> -->
                                    <?php foreach ($teknisiAll as $data): ?>
                                        <?php if ($_SESSION['id'] == $data['id_teknisi']): ?>
                                            <option value="<?= $data['id_teknisi'] ?>" selected><?= $data['nama_lengkap'] ?></option>
                                        <?php endif ?>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4 text-right">Rating</label>
                            <div class="col-md-8">
                                <select class="form-control form-control-lg input-rounded input-focus" name="rating" id="rating">
                                    <option value="">...Semua Rating...</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-2 col-md-8 mr-auto">
                        <div class="form-group row">
                            <div class="offset-md-3 col-md-9 text-right">
                                <button type="submit" class="btn btn-primary mb-2">
                                    <i class="fas fa-print"></i>
                                    Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>