<?php
    $type = (isset($_GET['type']) and !empty($_GET['type'])) ? $_GET['type'] : null;
    require_once 'functions/class_static_value.php';
    $csv = new class_static_value();
    require_once 'functions/koneksi.php';
    require_once 'functions/function_umum.php';
    require_once 'functions/function_layanan.php';
    $kategoriAll = getKategoriAll('ASC');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Favicon icon -->
        <link rel="icon" type="image/png" sizes="16x16" href="assets/img/fortinusa.ico">

        <title>Ela - Bootstrap Admin Dashboard Template</title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="assets/lib/bootstrap/css/bootstrap.min.css">

        <!-- Fontawesome -->
        <link rel="stylesheet" type="text/css" href="assets/lib/icons/fontawesome/css/all.min.css"/>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/backend/css/helper.css">
        <link rel="stylesheet" href="assets/backend/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
        <!--[if lt IE 9]>
        <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body class="fix-header fix-sidebar">
        <!-- Preloader - style you can find in spinners.css -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>

        <!-- Main wrapper  -->
        <div id="main-wrapper">
            <div class="unix-login">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="login-content card">
                                <div class="login-form">
                                    <h4 style="margin-bottom: 1%;">Register</h4>
                                    <?php
                                    getNotifikasi();
                                    ?>
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs nav-justified customtab" role="tablist">
                                        <li class="nav-item">
                                            <a class="
                                                nav-link
                                                <?php //if ($type != null and $type == "teknisi") : ?>
                                                    active
                                                <?php //endif ?>
                                            " data-toggle="tab" href="#teknisi" role="tab">
                                                <span class="hidden-sm-up">
                                                    <i class="ti-user"></i>
                                                </span>
                                                <span class="hidden-xs-down">
                                                    Teknisi
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="
                                            tab-pane
                                            p-20
                                            <?php //if ($type != null and $type == "teknisi") : ?>
                                                active
                                            <?php //endif ?>
                                        " id="teknisi" role="tabpanel">
                                            <form
                                                action="index.php?content=login_proses&proses=register&user=teknisi"
                                                method="POST"
                                                enctype="multipart/form-data"
                                            >
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="form-group">
                                                            <label>Nama Lengkap</label>
                                                            <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap...">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>No. HP</label>
                                                            <input type="text" class="form-control" name="no_hp" placeholder="No. HP...">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="email" class="form-control" name="email" placeholder="Email...">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Alamat</label>
                                                            <input type="text" class="form-control" name="alamat" placeholder="Alamat...">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Berkas Ijazah/Sertifikat (Opsional)</label>
                                                            <input type="file" class="form-control" name="berkas[]" placeholder="Berkas..." multiple >
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label>User Name</label>
                                                            <input type="text" class="form-control" name="username" placeholder="User Name">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Password</label>
                                                            <input type="password" class="form-control" name="password" placeholder="Password">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Foto</label>
                                                            <input type="file" class="form-control" name="url_foto" placeholder="Foto">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Kategori Keahlian</label>
                                                            <?php foreach ($kategoriAll AS $data) : ?>
                                                                <div class="checkbox pl-3">
                                                                    <input
                                                                        type="checkbox"
                                                                        class="trigger"
                                                                        name="kategori[]"
                                                                        id="kategori-<?php echo $data['id_layanan_kategori']; ?>"
                                                                        value="<?php echo $data['id_layanan_kategori']; ?>"
                                                                    />
                                                                    <label class="form-check-label" for="kategori-<?php echo $data['id_layanan_kategori']; ?>">
                                                                        <?php echo $data['nama_kategori_layanan']; ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button type="submit" name="register" class="btn btn-primary btn-flat m-b-10 m-t-10">Register</button>
                                                        <div class="register-link m-t-15 text-center">
                                                            <p>
                                                                Sudah punya akun ?
                                                                <a href="login.php"> Sign in</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <center>
                                <a class="btn btn-primary" href="<?php echo $csv::$URL_BASE; ?>/login.php">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </center>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Wrapper -->

        <!-- All Jquery -->
        <script src="assets/lib/jquery/jquery.min.js"></script>
        <!-- Bootstrap tether Core JavaScript -->
        <script src="assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- slimscrollbar scrollbar JavaScript -->
        <script src="assets/backend/js/jquery.slimscroll.js"></script>
        <!--Menu sidebar -->
        <script src="assets/backend/js/sidebarmenu.js"></script>
        <!--stickey kit -->
        <script src="assets/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
        <!--Custom JavaScript -->
        <script src="assets/backend/js/custom.min.js"></script>

    </body>

</html>