<?php
// error_reporting(0);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['record-count'])) {
    $_SESSION['record-count'] = 10;
}

if (!isset($_SESSION['jenis_akun'])) {
    echo "<script> location.replace('../login.php'); </script>";
}

include '../functions/class_static_value.php';
$csv = new class_static_value();

include '../functions/koneksi.php';
include '../functions/function_umum.php';

include '../functions/function_pengguna.php';
include '../functions/function_pengguna_pelanggan.php';
include '../functions/function_pengguna_teknisi.php';
include '../functions/function_pengguna_pimpinan.php';

include '../functions/function_layanan.php';
include '../functions/function_sparepart.php';
include '../functions/function_pemesanan.php';
include '../functions/function_foto_kerusakan.php';
include '../functions/function_biaya_tambahan.php';
include '../functions/function_bukti_pembayaran.php';

include '../functions/Zebra_Pagination.php';

cekLogin('teknisi');

// if ($_SESSION['jenis_akun'] != 'teknisi') {
//     // session_destroy();
//     echo "<script> location.replace('/service-panggil/login.php'); </script>";
// }

?>
<!DOCTYPE html>
<html>

<head>
    <!-- Google Tag Manager -->
    <!-- <script>(
                function(w,d,s,l,i) {
                    w[l] = w[l] || [];
                    w[l].push({
                        'gtm.start': new Date().getTime(),
                        event:'gtm.js'
                    });
                    var
                        f = d.getElementsByTagName(s)[0],
                        j = d.createElement(s),
                        dl = l != 'dataLayer' ? '&l=' + l : '';
                    j.async = true;
                    j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                    f.parentNode.insertBefore(j,f);
                })(window,document,'script','dataLayer','GTM-K6DPDPS');
            </script> -->
    <!-- End Google Tag Manager -->
    <meta charset="utf-8" />
    <meta name="description" content="Jasa service dan maintenance komputer Makassar...">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="PT. Fortinusa">

    <!-- Favicon icon -->
    <link rel="icon" href="../assets/img/fortinusa.ico" />
    <title>Administrator - Layanan Service Panggil PT. Fortinusa</title>

    <!-- Fontawesome -->
    <link rel="stylesheet" type="text/css" href="../assets/lib/icons/fontawesome/css/all.min.css" />

    <link rel="stylesheet" type="text/css" href="../assets/lib/calendar2/semantic.ui.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/lib/calendar2/pignose.calendar.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/lib/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" type="text/css" href="../assets/lib/owl-carousel/owl.theme.default.min.css" />

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/lib/bootstrap/css/bootstrap.min.css" />

    <!-- Zebra Pagination CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/lib/zebra-pagination/zebra_pagination.css" />

    <!-- Zebra Datepicker CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/lib/zebra-datepicker/zebra_datepicker.min.css" />

    <!-- Sweetalert2 CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/lib/sweetalert2/css/sweetalert2.min.css" />

    <!-- Toastr CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/lib/toastr/toastr.min.css" />

    <!-- Photoswipe CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/photoswipe.css" />
    <link rel="stylesheet" type="text/css" href="../assets/css/default-skin/default-skin.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/backend/css/helper.css" />
    <link rel="stylesheet" type="text/css" href="../assets/backend/css/style.css" />

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

    <!-- Google Tag Manager (noscript) -->
    <!-- <noscript>
                <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K6DPDPS" height="0" width="0" style="display:none;visibility:hidden"></iframe>
            </noscript> -->
    <!-- End Google Tag Manager (noscript) -->

    <!-- Main wrapper  -->
    <div id="main-wrapper">

        <?php include "header.php"; ?>

        <!-- Page wrapper  -->
        <div class="page-wrapper">

            <?php include "content.php"; ?>

            <?php include "footer.php"; ?>

        </div>
        <!-- End Page wrapper  -->

    </div>
    <!-- End Main wrapper  -->

    <!-- All Jquery -->
    <script src="../assets/lib/jquery/jquery.min.js"></script>

    <!-- Bootstrap tether Core JavaScript -->
    <!-- <script src="../assets/lib/bootstrap/js/popper.min.js"></script> -->
    <script src="../assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!--Menu sidebar -->
    <script src="../assets/backend/js/sidebarmenu.js"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../assets/backend/js/jquery.slimscroll.js"></script>

    <!--stickey kit -->
    <script src="../assets/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>

    <!-- Amchart -->
    <!-- <script src="../assets/beckend/js/lib/morris-chart/raphael-min.js"></script>
            <script src="../assets/beckend/js/lib/morris-chart/morris.js"></script> -->
    <!-- <script src="../assets/beckend/js/lib/morris-chart/dashboard1-init.js"></script> -->

    <script src="../assets/lib/calendar2/js/moment.latest.min.js"></script>
    <!-- scripit init-->
    <script src="../assets/lib/calendar2/js/semantic.ui.min.js"></script>
    <!-- scripit init-->
    <script src="../assets/lib/calendar2/js/prism.min.js"></script>
    <!-- scripit init-->
    <script src="../assets/lib/calendar2/js/pignose.calendar.min.js"></script>
    <!-- scripit init-->
    <script src="../assets/lib/calendar2/js/pignose.init.js"></script>

    <!--
            <script src="../assets/lib/owl-carousel/owl.carousel.min.js"></script>
            <script src="../assets/lib/owl-carousel/owl.carousel-init.js"></script>
            -->

    <!-- Zebra Pagination JavaScript -->
    <script src="../assets/lib/zebra-pagination/zebra_pagination.js"></script>

    <!-- Zebra Datepicker JavaScript -->
    <script src="../assets/lib/zebra-datepicker/zebra_datepicker.min.js"></script>

    <!-- Select2 Javascript -->
    <script src="../assets/lib/select2/js/select2.full.min.js"></script>

    <!-- Toastr Javascript -->
    <script src="../assets/lib/toastr/toastr.min.js"></script>

    <!-- Sweetalert2 JavaScript -->
    <script src="../assets/lib/sweetalert2/js/sweetalert2.all.min.js"></script>

    <script src="../assets/js/photoswipe.min.js"></script>
    <script src="../assets/js/photoswipe-ui-default.min.js"></script>

    <!-- Custom JavaScript -->
    <script src="../assets/backend/js/scripts.js"></script>

    <!-- scripit init-->
    <script type="text/javascript">
        function confirm(message, url, id) {
            event.preventDefault();
            var msg = "";
            var id = id ? id : null;
            if (id !== null) {
                msg = "Apakah anda yakin ingin ";
                if (message == 'hapus') {
                    msg += "menghapus data dengan ID " + id + "..?";
                } else if (message == 'selesai') {
                    msg += "menyelesaikan data dengan ID : " + id;
                } else if (message == 'batal') {
                    msg += "membatalkan data dengan ID : " + id;
                } else {
                    msg += message + " data dengan ID : " + id;
                }
            } else {
                msg = message;
            }
            Swal.fire({
                title: 'Peringatan!',
                text: msg,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ya',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    window.location.replace(url);
                    // $.ajax({
                    //     method: "GET",
                    //     url: url,
                    //     data: {
                    //         name: "John",
                    //         location: "Boston"
                    //     }
                    // }).done(function( msg ) {
                    //     alert( "Data Saved: " + msg );
                    // });
                }
            });
        }

        $('li.dropdown#notification_center').on('shown.bs.dropdown', function() {
            // alert('The dropdown is now fully shown.');
            let resultDataAll = new Array();
            setInterval(function() {
                var result = "";
                $.ajax({
                    url: '../functions/function_responds.php?content=get_notifikasi',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        type: "",
                        info: "",
                        tujuan: "teknisi_<?= $_SESSION['id'] ?>",
                        status_show: "",
                        status_baca: "belum"
                    },
                }).done(function(data) {
                    resultDataAll = JSON.parse(data);
                    if (resultDataAll.length > 0) {
                        resultDataAll.forEach(data => {
                            data.tipe_notifikasi = (data.tipe_notifikasi == 'error') ? 'danger' : data.tipe_notifikasi;
                            $("div.message-center#message_center").append("<a href='#'><div class='btn btn-" + data.tipe_notifikasi + " btn-circle m-r-10'><i class='fas fa-link'></i></div><div class='mail-contnet'><h5>" + data.info_notifikasi + "</h5><span class='mail-desc'>" + data.isi_notifikasi + "</span><span class='time'>" + data.tanggal + "</span></div></a>");
                            $.ajax({
                                url: '../functions/function_responds.php?content=set_read_notifikasi',
                                type: 'POST',
                                dataType: 'html',
                                data: {
                                    id_notifikasi: data.id_notifikasi,
                                    user_type: "teknisi_<?= $_SESSION['id'] ?>"
                                },
                            }).done(function(data) {
                                // console.log(data);
                            }).fail(function() {
                                console.log("Error to set read in data_notifikasi..!");
                                return;
                            });
                        });
                    }
                }).fail(function() {
                    console.log("Error to get from data_notifikasi..!");
                    return;
                });
            }, 1000); // 1 Seconds In Milisecond
        });

        // $('li.dropdown#notification_center').on('hidden.bs.dropdown', function() {
        //     alert('The dropdown is now fully hidden.');
        // });

        $(function() {
            let resultDataAll = new Array();
            setInterval(function() {
                var result = "";
                $.ajax({
                    url: '../functions/function_responds.php?content=get_notifikasi',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        type: "",
                        info: "",
                        tujuan: "teknisi_<?= $_SESSION['id'] ?>",
                        status_show: "",
                        status_baca: "belum"
                    },
                }).done(function(data) {
                    resultDataAll = JSON.parse(data);
                    if (resultDataAll.length > 0) {
                        $('div.notify#notify').html("<span class='heartbit'></span><span class='point'></span>");
                    } else {
                        // $("div.message-center#message_center").html("<a href='#'><div class='btn btn-info btn-circle m-r-10'><i class='fas fa-info'></i></div><div class='mail-content'><span class='mail-desc'>Tidak ada notifikasi..!</span></div></a>");
                        $('div.notify#notify').html("");
                    }
                }).fail(function() {
                    console.log("Error to get from data_notifikasi..!");
                    return;
                });
            }, 1000); // 1 Seconds In Milisecond

            resultDataAll = new Array();
            setInterval(function() {
                var result = "";
                $.ajax({
                    url: '../functions/function_responds.php?content=get_notifikasi',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                        type: "",
                        info: "",
                        tujuan: "teknisi_<?= $_SESSION['id'] ?>",
                        status_show: "belum",
                        status_baca: "belum"
                    },
                }).done(function(data) {
                    resultDataAll = JSON.parse(data);
                    if (resultDataAll.length > 0) {
                        resultDataAll.forEach(data => {
                            toastrNotification(data.tipe_notifikasi, data.info_notifikasi, data.isi_notifikasi);
                            $.ajax({
                                url: '../functions/function_responds.php?content=set_show_notifikasi',
                                type: 'POST',
                                dataType: 'html',
                                data: {
                                    id_notifikasi: data.id_notifikasi,
                                    user_type: "teknisi_<?= $_SESSION['id'] ?>"
                                },
                            }).done(function(data) {
                                // $('input#jumlah').html(parseInt(data));
                            }).fail(function() {
                                console.log("Error to set read in data_notifikasi..!");
                                return;
                            });
                        });
                    }
                }).fail(function() {
                    console.log("Error to get from data_notifikasi..!");
                    return;
                });
            }, 1000); // 1 Seconds In Milisecond
        });
    </script>

    <?php if ($content == 'diagnosis' and ($action == 'ubah' or $action == 'lihat')) : ?>
        <script>
            jQuery(document).ready(function() {
                <?php foreach ($softwareAll as $data1) : ?>
                    // ------- Software -------
                    $("body").on("change load", "input#software-<?php echo $data1['id']; ?>", function() {
                        if ($(this).is(":checked")) {
                            // $('input#isiDisposisiBidang${bidang.id}').show(250);
                            $('input#total-biaya').val($('input#total-biaya').val() + <?php echo $data1['harga']; ?>);
                        } else {
                            // $('input#isiDisposisiBidang${bidang.id}').hide(250);
                            $('input#total-biaya').val($('input#total-biaya').val() - <?php echo $data1['harga']; ?>);
                        }
                        console.log('Success...');
                    });
                    if ($("input#software-<?php echo $data1['id']; ?>").is(":checked")) {
                        // $('input#isiDisposisiBidang${bidang.id}').show(250);
                        $('input#total-biaya').val($('input#total-biaya').val() + <?php echo $data1['harga']; ?>);
                    }
                <?php endforeach ?>
            });
        </script>
    <?php endif ?>

    <!-- <script src="assets/js/custom.min.js"></script> -->

</body>

</html>