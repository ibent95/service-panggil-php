<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";
        echo "<script>window.location.replace('?content=pemesanan')</script>";
    }
    $kategoriAll = getKategoriAll();
    $pelangganAll = getPelangganAll();
    $teknisiAll = getTeknisiAll('ASC', 'ya');
    //if ($action == 'persetujuan' OR $action == 'pilih_teknisi') {
        $pemesanan = mysqli_fetch_array(
            getPemesananJoinById($id), 
            MYSQLI_BOTH
        );
        // $pemesananDetailAll = getDetailPemesananByIdPemesanan($pemesanan['id']);
        if (!empty($pemesanan['longlat'])) {
            $longlat = explode(",", $pemesanan['longlat']);
        } else {
            $longlat[0] = 0;
            $longlat[1] = 0;
        }
    //}
    if ($action == 'konfirmasi_pembayaran_panjar') {
        $pembayaran = mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($pemesanan['id_pemesanan'], 'panjar'));
    } elseif ($action == 'konfirmasi_pembayaran_lunas') {
        $pembayaran = mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($pemesanan['id_pemesanan'], 'lunas'));
    } else {
        $pembayaran = mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($pemesanan['id_pemesanan']));
    }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Transaksi</h3> </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item">
                <a href="?content=pemesanan">Transaksi</a>
            </li>
            <li class="breadcrumb-item active">Persetujuan</li>
        </ol>
    </div>
</div>
<!-- End Bread crumb -->

<!-- Container fluid  -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card text-dark">
                <div class="card-title">
                    <h4>Form Persetujuan Transaksi - <?php echo $pemesanan[0]; ?></h4>
                </div>
                <div class="card-body">
                    <p class="text-dark">
                        Tindak lanjut atau persetujuan untuk pemesanan :
                    </p>
                    <div class="text-dark">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Tanggal Transaksi</label>
                                    <div class="col-md-7">
                                        <input
                                            class="form-control-plaintext"
                                            type="text"
                                            <?php //if ($action == 'persetujuan' OR $action == 'pilih_teknisi') : ?>
                                                value=": <?php echo $pemesanan['tanggal_pesan']; ?>"
                                            <?php //endif ?>
                                            disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Pelanggan</label>
                                    <div class="col-md-7">
                                        <input
                                            class="form-control-plaintext"
                                            type="text"
                                            <?php //if ($action == 'persetujuan' OR $action == 'pilih_teknisi') : ?>
                                                value=": <?php echo $pemesanan['nama_pelanggan']; ?>"
                                            <?php //endif ?>
                                            disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Kategori Layanan</label>
                                    <div class="col-md-7">
                                        <input 
                                            class="form-control-plaintext" 
                                            type="text" 
                                            <?php //if ($action == 'persetujuan' OR $action == 'pilih_teknisi') : ?>
                                                value=": <?php echo $pemesanan['nama_kategori_layanan']; ?>"
                                            <?php //endif ?>
                                            disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Tanggal Pengerjaan</label>
                                    <div class="col-md-7">
                                        <input 
                                            class="form-control-plaintext" 
                                            type="text" 
                                            <?php if ($action == 'persetujuan' OR $action == 'pilih_teknisi') : ?>
                                                value=": <?php echo $pemesanan['tanggal_kerja']; ?>"
                                            <?php endif ?>
                                            disabled
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Keluhan</label>
                                    <div class="col-md-7">
                                        <input 
                                            class="form-control-plaintext" 
                                            type="text" 
                                            <?php //if ($action == 'persetujuan' OR $action == 'pilih_teknisi') : ?>
                                                value=": <?php echo $pemesanan['keluhan']; ?>"
                                            <?php //endif ?>
                                            disabled
                                        />
                                    </div>
                                </div>

                                <?php if ($action == 'konfirmasi_pembayaran_panjar'): ?>
                                    <div class="form-group">
                                        <label class="col-form-label">Pembayaran Panjar</label>
                                        <p>
                                            <img src="<?php echo searchFile($pembayaran['bukti_pembayaran'], "img", "short"); ?>" class="img-fluid img-thumbnail mb-2" alt="..." style="height: 150px;" id="image_gallery">
                                        </p>
                                    </div>
                                <?php elseif ($action == 'konfirmasi_pembayaran_lunas'): ?>
                                    <div class="form-group">
                                        <label class="col-form-label">Pembayaran Lunas</label>
                                        <p>
                                            <img src="<?php echo searchFile($pembayaran['bukti_pembayaran'], "img", "short"); ?>" class="img-fluid img-thumbnail mb-2" alt="..." style="height: 150px;" id="image_gallery">
                                        </p>
                                    </div>
                                <?php elseif ($action != 'pilih_teknisi') : ?>
                                    <div class="form-group">
                                        <label class="col-form-label">Pembayaran</label>
                                        <p>
                                            <?php foreach ($pembayaran as $data): ?>
                                                <img src="<?php echo searchFile($pembayaran['bukti_pembayaran'], "img", "short"); ?>" class="img-fluid img-thumbnail mb-2" alt="..." style="height: 150px;" id="image_gallery">
                                            <?php endforeach ?>
                                        </p>
                                    </div>
                                <?php endif ?>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group" id="form-lokasi" > <!-- style="display: none;" -->
                                    <label class="col-md-3 control-label">Lokasi</label>
                                    <div class="col-md-12">
                                        <input 
                                            type="hidden" 
                                            class="form-control input-rounded input-focus" 
                                            name="longlat" 
                                            <?php //if ($action == 'persetujuan' OR $action == 'pilih_teknisi') : ?>
                                                value="<?php echo $pemesanan['longlat']; ?>"
                                            <?php //endif ?>
                                            id="longlat"
                                        >
                                        <!-- <br> --> 
                                        <div id="map" style="width:100%; height:300px"></div>
                                        <script>
                                            function initMap() {
                                                var lngs = <?php echo $longlat[0]; ?>;
                                                var lats = <?php echo $longlat[1]; ?>;
                                                var input = document.getElementById('longlat');
                                                var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                                var labelIndex = 0;
                                                if (lngs == 0 && lats == 0) {
                                                    var myLatlng = {lat: -5.147665, lng: 119.432732};
                                                } else {
                                                    // console.log(lngs);
                                                    // console.log(lats);
                                                    var myLatlng = {lat: lats, lng: lngs};
                                                }
                                                
                                                var map = new google.maps.Map(document.getElementById('map'), {
                                                    zoom: 15,
                                                    center: myLatlng
                                                });

                                                var marker = new google.maps.Marker({
                                                    position: myLatlng,
                                                    map: map,
                                                    label: 'B',
                                                    title: 'Click to zoom'
                                                });

                                                var infoWindow = new google.maps.InfoWindow({map: map});

                                                // google.maps.event.addDomListener(map, 'click', function(event) {
                                                //     var myLatLng = event.latLng;
                                                //     var lat = myLatLng.lat();
                                                //     var lng = myLatLng.lng();
                                                //     alert( 'lat '+ lat + ' lng ' + lng ); 
                                                // }

                                                // Try HTML5 geolocation.
                                                var watchID = null;
                                                if (navigator.geolocation) {
                                                    var optn = {
                                                        enableHighAccuracy: true,
                                                        timeout: Infinity,
                                                        maximumAge: 0   
                                                    };
                                                    navigator.geolocation.getCurrentPosition(function(position) {
                                                            var pos = {
                                                                lat: position.coords.latitude,
                                                                lng: position.coords.longitude,
                                                                mapTypeId:google.maps.MapTypeId.ROAD
                                                            };
                                                            var markerA = new google.maps.Marker({
                                                                position: pos,
                                                                map: map,
                                                                label: 'A',
                                                                title: 'Click to zoom'
                                                            });
                                                            // infoWindow.setPosition(pos);
                                                            // infoWindow.setContent('Location found.');
                                                            // map.setCenter(pos);
                                                        }, function(failure) {
                                                            handleLocationError(true, infoWindow, map.getCenter());
                                                            if (failure.message.indexOf("Only secure origins are allowed") == 0) {
                                                                handleLocationError(true, infoWindow, map.getCenter());
                                                            }
                                                        }, optn
                                                    );
                                                    // $("button").click(function(){
                                                    //     if (watchID)
                                                    //         navigator.geolocation.clearWatch(watchID);

                                                    //     watchID = null;
                                                    //     return false;
                                                    // });
                                                } else {
                                                    // Browser doesn't support Geolocation
                                                    handleLocationError(false, infoWindow, map.getCenter());
                                                }
                                                // map.addListener('center_changed', function() {
                                                //     // 3 seconds after the center of the map has changed, pan back to the
                                                //     // marker.
                                                //     var lnglat = map.getCenter();
                                                //     var lat = lnglat.lat();
                                                //     var lng = lnglat.lng();
                                                //     // input.value = lng + ',' + lat;
                                                //     marker.setPosition(map.getCenter());
                                                //     input.value = lng + ',' + lat;
                                                // });
                                                // marker.addListener('click', function() {
                                                //     map.setZoom(15);
                                                //     map.setCenter(marker.getPosition());
                                                // });
                                            }

                                            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                                                infoWindow.setPosition(pos);
                                                infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
                                            }
                                        </script>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <form class="form-horizontal"
                        <?php if ($action == 'tambah') : ?>
                            action="?content=pemesanan_persetujuan_proses&proses=add"
                        <?php elseif ($action == 'konfirmasi_pembayaran_panjar'): ?>
                            action="?content=pemesanan_persetujuan_proses&proses=konfirmasi_pembayaran_panjar"
                        <?php elseif ($action == 'konfirmasi_pembayaran_lunas'): ?>
                            action="?content=pemesanan_persetujuan_proses&proses=konfirmasi_pembayaran_lunas"
                        <?php else: ?>
                            action="?content=pemesanan_persetujuan_proses&proses=edit"
                        <?php endif ?>
                        method="POST" enctype="multipart/form-data">

                        <?php if ($action == 'persetujuan' OR $action == 'pilih_teknisi' OR $action == 'konfirmasi_pembayaran_panjar' OR $action == 'konfirmasi_pembayaran_lunas') : ?>
                            <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                        <?php endif ?>
                        <?php if ($action == 'persetujuan' OR $action == 'pilih_teknisi') : ?>
                            <div class="form-group">
                                <label for="id_teknisi" class="col-md-3 control-label">Teknisi</label>
                                <div class="col-md-5">
                                    <select class="form-control form-control-lg input-rounded input-focus" name="id_teknisi" id="id_teknisi">
                                        <option value="">-- Silahakan Pilih Teknisi --</option>
                                        <?php foreach ($teknisiAll as $data): ?>
                                            <?php
                                                $totalRating = 0;
                                                $teknisiRatings5 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '5' AND `id_teknisi` = '$data[id_teknisi]'"))['count'];
                                                $teknisiRatings4 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '4' AND `id_teknisi` = '$data[id_teknisi]'"))['count'];
                                                $teknisiRatings3 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '3' AND `id_teknisi` = '$data[id_teknisi]'"))['count'];
                                                $teknisiRatings2 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '2' AND `id_teknisi` = '$data[id_teknisi]'"))['count'];
                                                $teknisiRatings1 = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(`id_teknisi`) AS `count` FROM `data_pemesanan` WHERE `rating` = '1' AND `id_teknisi` = '$data[id_teknisi]'"))['count'];
                                                $totalRating = calculateAllRating(
                                                    array(
                                                        array('star' => 5, 'count' => $teknisiRatings5),
                                                        array('star' => 4, 'count' => $teknisiRatings4),
                                                        array('star' => 3, 'count' => $teknisiRatings3),
                                                        array('star' => 2, 'count' => $teknisiRatings2),
                                                        array('star' => 1, 'count' => $teknisiRatings1)
                                                    )
                                                );
                                            ?>
                                            <option
                                                value="<?php echo $data['id_teknisi']; ?>"
                                                <?php if ($action == 'persetujuan') : ?>
                                                    <?php if ($pemesanan['id_teknisi'] == $data['id_teknisi']) : ?>
                                                        selected
                                                    <?php endif ?>
                                                <?php endif ?>
                                            >
                                                <?php echo $data['nama_lengkap'] . " [Ratings: " . $totalRating . " out of 5 Stars]"; ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if ($action == 'persetujuan') : ?>
                            <div class="form-group">
                                <label for="status_pemesanan" class="col-md-3 control-label">Status Transaksi</label>
                                <div class="col-md-5">
                                    <select class="form-control input-rounded input-focus" name="status_pemesanan" id="status_pemesanan">
                                        <option value="">-- Silahakan Pilih Status --</option>
                                        <option 
                                            value="tunggu"
                                            <?php if ($action == 'persetujuan') : ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'tunggu') : ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Tunggu
                                        </option>
                                        <option 
                                            value="proses"
                                            <?php //if ($action == 'persetujuan'): ?>
                                                <?php //if ($pemesanan['status_pemesanan'] == 'proses'): ?>
                                                    selected
                                                <?php //endif ?>
                                            <?php //endif ?>
                                        >
                                            Proses
                                        </option>
                                        <option 
                                            value="batal"
                                            <?php if ($action == 'persetujuan') : ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'batal'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Batal
                                        </option>
                                        <option 
                                            value="selesai"
                                            <?php if ($action == 'persetujuan') : ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'selesai'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Selesai
                                        </option>
                                    </select>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if ($action == 'konfirmasi_pembayaran_panjar' OR $action == 'konfirmasi_pembayaran_lunas') : ?>
                            <div class="form-group">
                                <label for="id_teknisi" class="col-md-3 control-label">Konfirmasi Pembayaran</label>
                                <div class="col-md-5">
                                    <select class="form-control form-control-lg input-rounded input-focus" name="konfirmasi_admin" id="konfirmasi_admin">
                                        <option value="">-- Silahakan Pilih Hasil Konfirmasi --</option>
                                        <option 
                                            value="belum"
                                            <?php if ($action == 'konfirmasi_pembayaran_panjar' OR $action == 'konfirmasi_pembayaran_lunas') : ?>
                                                <?php if ($pembayaran['konfirmasi_admin'] == 'belum') : ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Belum
                                        </option>
                                        <option 
                                            value="ya"
                                            <?php if ($action == 'konfirmasi_pembayaran_panjar' OR $action == 'konfirmasi_pembayaran_lunas'): ?>
                                                <?php if ($pembayaran['konfirmasi_admin'] == 'ya'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Ya
                                        </option>
                                        <option 
                                            value="tidak"
                                            <?php if ($action == 'konfirmasi_pembayaran_panjar' OR $action == 'konfirmasi_pembayaran_lunas') : ?>
                                                <?php if ($pembayaran['konfirmasi_admin'] == 'tidak'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Tidak
                                        </option>
                                    </select>
                                </div>
                            </div>
                        <?php endif ?>

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

<script async defer src='https://maps.googleapis.com/maps/api/js?key=AIzaSyB6bHo5JkixK-_Ct1TWEy4ZDdiuRqbwkpw&callback=initMap'>
</script>