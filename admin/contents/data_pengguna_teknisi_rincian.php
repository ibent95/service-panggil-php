<?php 
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? $_GET['id'] : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>window.location.replace('?content=data_pengguna_teknisi')</script>";
    }

    $pengguna = mysqli_fetch_assoc(
        getTeknisiById($id)
    );

    $totalRating = 0;
    $teknisiRatings5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '5' AND `id_teknisi` = '$id'"))['count'];
    $teknisiRatings4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '4' AND `id_teknisi` = '$id'"))['count'];
    $teknisiRatings3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '3' AND `id_teknisi` = '$id'"))['count'];
    $teknisiRatings2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '2' AND `id_teknisi` = '$id'"))['count'];
    $teknisiRatings1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '1' AND `id_teknisi` = '$id'"))['count'];
    $totalRating = calculateAllRating(
        array(
            array('star' => 5, 'count' => $teknisiRatings5),
            array('star' => 4, 'count' => $teknisiRatings4),
            array('star' => 3, 'count' => $teknisiRatings3),
            array('star' => 2, 'count' => $teknisiRatings2),
            array('star' => 1, 'count' => $teknisiRatings1)
        )
    );

    // $jabatanAll = getJabatanAll("ASC");
?>

<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Data Teknisi</h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">Data Anggota</a>
            </li>
            <li class="breadcrumb-item active">Data Teknisi</li>
            <li class="breadcrumb-item active">Rincian Data Teknisi</li>
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
                    <h4>Rincian Data Teknisi</h4>
                </div>

                <div class="card-body">

                    <?php getNotifikasi(); ?>

                    <p>
                        <a href="?content=data_pengguna_teknisi" class="btn btn-dark">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </p>

                    <form 
                        class="form-horizontal row" 
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <div class="col-md-7 row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="nip" class="col-md-4 control-label text-right">NIP</label>
                                    <div class="col-md-8">
                                        <input 
                                            type="text" 
                                            class="form-control-plaintext" 
                                            name="nip" 
                                            id="nip"
                                            value="<?php echo $pengguna['nip']; ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nama_lengkap" class="col-md-4 control-label text-right">Nama Pegawai</label>
                                    <div class="col-md-8">
                                        <input 
                                            type="text" 
                                            class="form-control-plaintext" 
                                            name="nama_lengkap" 
                                            id="nama_lengkap"
                                            value="<?php echo $pengguna['nama_lengkap']; ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="jenis_kelamin" class="control-label col-md-4 text-right">Jenis Kelamin</label>
                                    <div class="col-md-6">
                                        <input 
                                            class="form-control-plaintext" 
                                            name="jenis_kelamin" 
                                            id="jenis_kelamin"
                                            value="<?php if ($pengguna['jenis_kelamin'] == 'laki-laki') : ?>Laki-laki<?php elseif ($pengguna['jenis_kelamin'] == 'perempuan') : ?>Perempuan<?php endif ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="control-label col-md-4 text-right">No. Handphone</label>
                                    <div class="col-md-8">
                                        <input 
                                            type="text" 
                                            class="form-control-plaintext" 
                                            name="no_hp" 
                                            maxlength="13" 
                                            id="no_hp"
                                            value="<?php echo $pengguna['no_hp']; ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tempat_lahir" class="control-label col-md-4 text-right">Tempat Lahir</label>
                                    <div class="col-md-8">
                                        <input 
                                            type="text" 
                                            class="form-control-plaintext" 
                                            name="tempat_lahir" 
                                            id="tempat_lahir"
                                            value="<?php echo $pengguna['tempat_lahir']; ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="tanggal_lahir" class="control-label col-md-4 text-right">Rating</label>
                                    <div class="col-md-8">
                                        <input type="text" class="form-control-plaintext" name="rating" value="<?php echo $totalRating; ?> dari 5 Bintang : " readonly>
                                        <div class="text-dark">
                                            <?php echo showRating(5, 20) . " [5] : " . $teknisiRatings5 . " kali penilaian"; ?> <br>
                                            <?php echo showRating(4, 20) . " [4] : " . $teknisiRatings4 . " kali penilaian"; ?> <br>
                                            <?php echo showRating(3, 20) . " [3] : " . $teknisiRatings3 . " kali penilaian"; ?> <br>
                                            <?php echo showRating(2, 20) . " [2] : " . $teknisiRatings2 . " kali penilaian"; ?> <br>
                                            <?php echo showRating(1, 20) . " [1] : " . $teknisiRatings1 . " kali penilaian"; ?> <br>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="agama" class="control-label col-md-4 text-right">Agama</label>
                                    <div class="col-md-8">
                                        <input class="form-control-plaintext" name="agama" id="agama" value="<?php if ($pengguna['agama'] == 'islam') : ?>Islam<?php elseif ($pengguna['agama'] == 'kristen') : ?>Kristen<?php elseif ($pengguna['agama'] == 'katolik') : ?>Katolik<?php elseif ($pengguna['agama'] == 'hindu') : ?>Hindu<?php elseif ($pengguna['agama'] == 'budha') : ?>Budha<?php endif ?>" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="alamat" class="control-label col-md-4 text-right">Alamat</label>
                                    <div class="col-md-8">
                                        <input 
                                            type="text" 
                                            class="form-control-plaintext" 
                                            name="alamat" 
                                            id="alamat"
                                            value="<?php echo $pengguna['alamat']; ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="jenis_pegawai" class="control-label col-md-4 text-right">Jenis Pegawai</label>
                                    <div class="col-md-8">
                                        <input 
                                            class="form-control-plaintext" 
                                            name="jenis_pegawai" 
                                            id="jenis_pegawai" 
                                            value="<?php if ($pengguna['jenis_pegawai'] == 'tetap') : ?>Tetap<?php elseif ($pengguna['jenis_pegawai'] == 'honorer') : ?>Honorer<?php endif ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="id_jabatan" class="control-label col-md-4 text-right">Jabatan</label>
                                    <div class="col-md-8">
                                        <input 
                                            class="form-control-plaintext" 
                                            name="id_jabatan" 
                                            id="id_jabatan"
                                            value="<?php foreach ($jabatanAll as $data) : ?><?php if ($pengguna['id_jabatan'] == $data['id']) : ?><?php echo $data['nama_jabatan']; ?><?php endif ?><?php endforeach ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="status" class="control-label col-md-4 text-right">Status</label>
                                    <div class="col-md-8">
                                        <input 
                                            class="form-control-plaintext" 
                                            name="status" 
                                            id="status" 
                                            value="<?php if ($pengguna['status'] == 'aktif') : ?>Aktif<?php elseif ($pengguna['status'] == 'non_aktif') : ?>Non Aktif<?php elseif ($pengguna['status'] == 'pindah') : ?>Pindah<?php endif ?>"
                                            readonly
                                        >
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-5">
                            <!-- Foto Fix -->
                            <div class="form-group row">
                                <label for="foto" class="control-label col-md-4 text-right">
                                    Foto
                                </label>
                                <div class="col-md-8">
                                    <?php if (!empty($pengguna['url_foto'])) : ?>
                                        <div class="form-group">
                                            <div class="col-md-offset-4 col-md-8">
                                                <img class="img-thumbnail" src='<?php echo searchFile($pengguna['url_foto'], "img", "short"); ?>' id="image_gallery" />
                                            </div>
                                        </div>
                                    <?php endif ?> 
                                </div>
                            </div>
                        </div>

                        <!-- <div class="form-group pull-left">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" name="simpan" value="Simpan" />
                                <input type="reset" class="btn btn-danger" value="Reset" />
                            </div>
                        </div> -->

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