<?php
    $pelangganAll = getPelangganAll('ASC');
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Laporan Pelanggan</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Data Laporan</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Laporan Pengguna</a></li>
            <li class="breadcrumb-item active">Pelanggan</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->
<!-- Container fluid  -->
<div class="container-fluid">
    <div class="card">
        <div class="card-title">
            <h3>Laporan Pelanggan</h3>
        </div>
        <div class="card-body">
            <?php getNotifikasi(); ?>
            <form class="form-inline" action="laporan_pelanggan.php" method="POST" target="_blank">
                <!-- Select2 CSS -->
                <link rel="stylesheet" type="text/css" href="../assets/lib/select2/css/select2.min.css">
                <link rel="stylesheet" type="text/css" href="../assets/lib/select2/css/select2-bootstrap.min.css">
                <div class="form-group mb-2 mr-sm-2">
                    <!-- <input type="text" class="form-control input-rounded input-focus" name="id_pelanggan" id="select_id_pelanggan" /> -->
                    <select class="form-control input-rounded input-focus" name="id_pelanggan" id="select_id_pelanggan">
                        <option value="all">...Semua Pelanggan...</option>
                    </select>
                    <!-- <select class="form-control input-rounded input-focus" name="id_pelanggan" id="select_id_pelanggan">
                        <option value="all">...Semua...</option>
                        <?php //foreach ($pelangganAll as $data): ?>
                            <option value="<?php //$data['id_pelanggan']; ?>"><?php //$data['nama_lengkap']; ?></option>
                        <?php //endforeach ?>
                    </select> -->
                </div>

                <!-- <div class="form-group mb-2 mr-sm-2">
                    <select class="form-control input-rounded input-focus" name="id_kelas" id="id_kelas" required>
                        <option value="">...Pilih Kelas...</option>
                        <?php //if (mysqli_num_rows($kelasAll) > 0) : ?>
                            <?php //foreach ($kelasAll AS $data) : ?>
                                <option value="<?php //echo $data['id_kelas']; ?>"><?php //echo $data['nama_kelas'] . " " . $data['nama_jurusan']; ?></option>
                            <?php //endforeach ?>
                        <?php //else : ?>
                            <option value="">Belum ada Data Kelas..!</option>
                        <?php //endif ?>
                    </select>
                </div>

                <div class="form-group mb-2 mr-sm-2">
                    <select class="form-control input-rounded input-focus" name="semester" id="semester">
                        <option value="">...Semua Semester...</option>
                        <?php //if (mysqli_num_rows($semesterAll) > 0) : ?>
                            <?php //foreach ($semesterAll AS $data) : ?>
                                <option value="<?php //echo $data['semester']; ?>"><?php //echo normalizeString($data['semester'], 'ucw'); ?></option>
                            <?php //endforeach ?>
                        <?php //else : ?>
                            <option value="">Belum Ada Data Nilai..!</option>
                        <?php //endif ?>
                    </select>
                </div>

                <div class="form-group mb-2 mr-sm-2">
                    <select class="form-control input-rounded input-focus" name="id_mapel" id="id_mapel">
                        <option value="">...Semua Pelajaran...</option>
                        <?php //if (mysqli_num_rows($mapelAll) > 0) : ?>
                            <?php //foreach ($mapelAll AS $data) : ?>
                                <option value="<?php //echo $data['id_mata_pelajaran']; ?>"><?php //echo $data['nama_pelajaran']; ?></option>
                            <?php //endforeach ?>
                        <?php //else : ?>
                            <option value="">Belum Ada Data Nilai..!</option>
                        <?php //endif ?>
                    </select>
                </div>

                <div class="form-group mb-2 mr-sm-2">
                    <select class="form-control input-rounded input-focus" name="tahun_ajaran" id="tahun_ajaran">
                        <option value="">...Semua Tahun Ajaran...</option>
                        <?php //if (mysqli_num_rows($tahunAjaranAll) > 0) : ?>
                            <?php //foreach ($tahunAjaranAll AS $data) : ?>
                                <option value="<?php //echo $data['tahun_ajaran']; ?>"><?php //echo $data['tahun_ajaran']; ?></option>
                            <?php //endforeach ?>
                        <?php //else : ?>
                            <option value="">Belum ada Data Nilai..!</option>
                        <?php //endif ?>
                    </select>
                </div> -->

                <div class="form-group">
                    <button type="submit" class="btn btn-primary mb-2">
                        <i class="fas fa-print"></i>
                        Cetak
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>