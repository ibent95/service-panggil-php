<?php
    $action = (isset($_GET['action'])) ? $_GET['action'] : NULL ;
    $id = (isset($_GET['id'])) ? antiInjection($_GET['id']) : NULL ;
    if ($action == NULL) {
        $_SESSION['message-type'] = "danger";
        $_SESSION['message-content'] = "Jenis aksi belum ditentukan..!";

        echo "<script>location.replace('?content=pemesanan')</script>";
    }

    // if ($action != 'lihat') {

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

    $fotoKerusakanAll = getFotoKerusakanByIdPemesanan($id);

    $softwareAll = getJenisSoftwareByIdKategori($pemesanan['id_kategori']);
    $hardwareAll = getJenisHardwareByIdKategori($pemesanan['id_kategori']);
    $sparepartAll = getSparepartAll();

    // if ($action != 'lihat') {
        $diagnosisSoftware  = getDetailPemesananByIdPemesanan($id, 'software', $pemesanan['pengerjaan_ke']);
        $diagnosisHardware  = getDetailPemesananByIdPemesanan($id, 'hardware', $pemesanan['pengerjaan_ke']);
        $diagnosisSparepart = getDetailPemesananByIdPemesanan($id, 'sparepart', $pemesanan['pengerjaan_ke']);
        $biayaTambahan      = getBiayaTambahanByIdPemesanan($id);
        $riwayatPembayaran = getBuktiPembayaranByIdPemesanan($id, '', 'ASC');
        $sisaPembayaran = 0;
        foreach ($diagnosisSoftware as $data) {
            $sisaPembayaran += $data['harga'];
        }
        foreach ($diagnosisHardware as $data) {
            $sisaPembayaran += $data['harga'];
        }
        foreach ($diagnosisSparepart as $data) {
            $sisaPembayaran += $data['harga'];
        }
        foreach ($biayaTambahan as $data) {
            $sisaPembayaran += $data['jumlah'];
        }
        foreach ($biayaTambahan as $data) {
            $sisaPembayaran -= $data['jumlah'];
        }
        $pemesanan['status_pembayaran'] = ($sisaPembayaran == 0) ? "Lunas" : "Belum Lunas";

    // }
    $totalHarga = 0;
    $no = 1;
    // }
?>
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">
            Diagnosis
        </h3>
    </div>
    <div class="col-md-7 align-self-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="javascript:void(0)">
                    Home
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="?content=pemesanan">
                    Pemesanan
                </a>
            </li>
            <li class="breadcrumb-item active">
                Diagnosis
            </li>
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
                    <h4>Form Diagnosis - <?php echo $pemesanan['id_pemesanan']; ?></h4>
                </div>

                <div class="card-body">

                    <p class="text-dark">
                        Diagnosis kerusakan pada perangkat dan perbaikan yang dilakukan :
                    </p>

                    <div class="text-dark">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Tanggal Pemesanan</label>
                                    <div class="col-md-7">
                                        <input
                                            class="form-control-plaintext"
                                            type="text"
                                            value=": <?php echo $pemesanan['tanggal_pesan']; ?>"
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
                                            value=": <?php echo $pemesanan['nama_pelanggan']; ?>"
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
                                            value=": <?php echo $pemesanan['nama_kategori_layanan']; ?>"
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
                                            value=": <?php echo $pemesanan['tanggal_kerja']; ?>"
                                            disabled
                                        />
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-5 col-form-label">Keluhan</label>
                                    <div class="col-md-7">
                                        <textarea
                                            class="form-control-plaintext"
                                            disabled
                                        ><?php echo $pemesanan['keluhan']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="form-group" id="form-lokasi" > <!-- style="display: none;" -->
                                    <label class="col-md-3 control-label">Lokasi</label>
                                    <div class="col-md-12">
                                        <input
                                            type="hidden"
                                            class="form-control input-rounded input-focus"
                                            name="longlat"
                                            value="<?php echo $pemesanan['longlat']; ?>"
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

                    <?php if (mysqli_num_rows($fotoKerusakanAll) > 0) : ?>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-dark">
                                    Foto Kerusakan
                                </p>

                                <?php foreach ($fotoKerusakanAll as $data): ?>
                                    <!-- ​<picture>
                                        <source srcset="..." type="image/svg+xml"> -->
                                        <img src="<?php echo searchFile($data["url_file"], "img", "short"); ?>" class="img-fluid img-thumbnail" alt="..." style="height: 150px;" id="image_gallery">
                                    <!-- </picture> -->
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endif ?>

                    <form
                        class="form-horizontal"
                        <?php if ($action == 'tambah') : ?>
                            action="?content=diagnosis_proses&proses=add"
                        <?php else : ?>
                            action="?content=diagnosis_proses&proses=edit"
                        <?php endif ?> 
                        method="POST"
                        enctype="multipart/form-data"
                    >
                        <?php if ($action != 'lihat') : ?>
                            <input type="hidden" name="id" value="<?php echo antiInjection($_GET['id']); ?>">
                        <?php endif ?>

                        <?php if ($action != 'lihat') : ?>
                            <div class="form-group">
                                <label for="status_pemesanan" class="col-md-3 control-label">Status Pemesanan</label>
                                <div class="col-md-5">
                                    <select class="form-control input-rounded input-focus" name="status_pemesanan" id="status_pemesanan">
                                        <option value="">-- Silahakan Pilih Status --</option>
                                        <option
                                            value="tunggu"
                                            <?php if ($action == 'persetujuan' OR $action == 'ubah') : ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'tunggu') : ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Tunggu
                                        </option>
                                        <option
                                            value="proses"
                                            <?php if ($action == 'persetujuan' OR $action == 'ubah'): ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'proses'): ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Proses
                                        </option>
                                        <option
                                            value="batal"
                                            <?php if ($action == 'persetujuan' OR $action == 'ubah') : ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'batal') : ?>
                                                    selected
                                                <?php endif ?>
                                            <?php endif ?>
                                        >
                                            Batal
                                        </option>
                                        <option
                                            value="selesai"
                                            <?php if ($action == 'persetujuan' OR $action == 'ubah') : ?>
                                                <?php if ($pemesanan['status_pemesanan'] == 'selesai') : ?>
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

                        <h5 class="mt-3">Daftar Pengerjaan Jasa dan Sparepart</h5>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <?php if ($action != 'lihat'): ?>
                                <div class="todo-list">
                                    <div class="tdl-holder">
                                        <div class="tdl-content">
                                            <ul>
                                                <div class="accordion" id="accordion">

                                                    <!-- Software -->
                                                    <div class="card-header border-right border-left border-top">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_software" aria-expanded="true" aria-controls="collapse_software">
                                                                Jasa Pengerjaan Software
                                                                <?php if (mysqli_num_rows($diagnosisSoftware) != 0): ?>
                                                                    <span class="badge badge-danger">
                                                                        <?php echo mysqli_num_rows($diagnosisSoftware); ?>
                                                                    </span>
                                                                <?php endif ?>
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div class="card-body border-right border-left">
                                                        <div class="collapse
                                                            <?php if (mysqli_num_rows($diagnosisSoftware) != 0): ?>
                                                                show
                                                            <?php endif ?>
                                                        " aria-labelledby="collapse_software" data-parent="#accordion" id="collapse_software">
                                                            <?php foreach ($softwareAll as $data1): ?>
                                                                <li>
                                                                    <label>
                                                                        <input
                                                                            type="checkbox"
                                                                            name="software[]"
                                                                            value="<?php echo $data1['id']; ?>"
                                                                            <?php if (mysqli_num_rows($diagnosisSoftware) != 0): ?>
                                                                                <?php foreach ($diagnosisSoftware as $data2): ?>
                                                                                    <?php if ($data1['id'] == $data2['id_jenis_layanan_sparepart']): ?>
                                                                                        checked
                                                                                    <?php endif ?>
                                                                                <?php endforeach ?>
                                                                            <?php endif ?>
                                                                            id="software-<?php echo $data1['id']; ?>"
                                                                        >
                                                                        <i class="bg-dark"></i>
                                                                        <span>
                                                                            <?php echo $data1['nama_jenis_layanan'] . " [<b>" . format($data1['harga'], "currency") . "</b>]"; ?>
                                                                        </span>
                                                                    </label>
                                                                </li>
                                                            <?php endforeach ?>
                                                        </div>
                                                    </div>

                                                    <!-- hardware -->
                                                    <div class="card-header border-right border-left border-top">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_hardware" aria-expanded="false" aria-controls="collapse_hardware">
                                                                Jasa Pengerjaan Hardware
                                                                <?php if (mysqli_num_rows($diagnosisHardware) != 0): ?>
                                                                    <span class="badge badge-danger">
                                                                        <?php echo mysqli_num_rows($diagnosisHardware); ?>
                                                                    </span>
                                                                <?php endif ?>
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div class="card-body border-right border-left">
                                                        <div class="collapse
                                                            <?php if (mysqli_num_rows($diagnosisHardware) != 0): ?>
                                                                show
                                                            <?php endif ?>
                                                        " aria-labelledby="collapse_hardware" data-parent="#accordion" id="collapse_hardware">
                                                            <?php foreach ($hardwareAll as $data1): ?>
                                                                <li>
                                                                    <label>
                                                                        <input type="checkbox" name="hardware[]" value="<?php echo $data1['id']; ?>"
                                                                            <?php if (mysqli_num_rows($diagnosisHardware) != 0): ?>
                                                                                <?php foreach ($diagnosisHardware as $data2): ?>
                                                                                    <?php if ($data1['id'] == $data2['id_jenis_layanan_sparepart']): ?>
                                                                                        checked
                                                                                    <?php endif ?>
                                                                                <?php endforeach ?>
                                                                            <?php endif ?>
                                                                        >
                                                                        <i class="bg-dark"></i>
                                                                        <span>
                                                                            <?php echo $data1['nama_jenis_layanan'] . " [<b>" . format($data1['harga'], "currency") . "</b>]"; ?>
                                                                        </span>
                                                                    </label>
                                                                </li>
                                                            <?php endforeach ?>
                                                        </div>
                                                    </div>

                                                    <!-- Sparepart -->
                                                    <div class="card-header border-right border-left border-top">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_sparepart" aria-expanded="false" aria-controls="collapse_sparepart">
                                                                Penggantian Sparepart
                                                                <?php if (mysqli_num_rows($diagnosisSparepart) != 0): ?>
                                                                    <span class="badge badge-danger">
                                                                        <?php echo mysqli_num_rows($diagnosisSparepart); ?>
                                                                    </span>
                                                                <?php endif ?>
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div class="card-body border-right border-left">
                                                        <div class="collapse
                                                            <?php if (mysqli_num_rows($diagnosisSparepart) != 0): ?>
                                                                show
                                                            <?php endif ?>
                                                        " aria-labelledby="collapse_sparepart" data-parent="#accordion"  id="collapse_sparepart">
                                                            <?php foreach ($sparepartAll as $data1): ?>
                                                                <li>
                                                                    <label>
                                                                        <input type="checkbox" name="sparepart[]" value="<?php echo $data1['id']; ?>"
                                                                            <?php if (mysqli_num_rows($diagnosisSparepart) != 0): ?>
                                                                                <?php foreach ($diagnosisSparepart as $data2): ?>
                                                                                    <?php if ($data1['id'] == $data2['id_jenis_layanan_sparepart']): ?>
                                                                                        checked
                                                                                    <?php endif ?>
                                                                                <?php endforeach ?>
                                                                            <?php endif ?>
                                                                        >
                                                                        <i class="bg-dark"></i>
                                                                        <span>
                                                                            <?php echo $data1['nama_sparepart'] . " [<b>" . format($data1['harga'], "currency") . "</b>]"; ?>
                                                                        </span>
                                                                    </label>
                                                                </li>
                                                            <?php endforeach ?>
                                                        </div>
                                                    </div>

                                                    <!-- Biaya Tambahan -->
                                                    <div class="card-header border-right border-left border-top">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse_biaya_tambahan" aria-expanded="true" aria-controls="collapse_biaya_tambahan">
                                                                Biaya Tambahan
                                                                <?php if (mysqli_num_rows($biayaTambahan) != 0): ?>
                                                                    <span class="badge badge-danger">
                                                                        <?php echo mysqli_num_rows($biayaTambahan); ?>
                                                                    </span>
                                                                <?php endif ?>
                                                            </button>
                                                        </h5>
                                                    </div>
                                                    <div class="card-body border-right border-left border-bottom">
                                                        <div 
                                                            class="collapse 
                                                                <?php if (mysqli_num_rows($biayaTambahan) != 0): ?>
                                                                    show
                                                                <?php endif ?>
                                                            " 
                                                            aria-labelledby="collapse_biaya_tambahan" 
                                                            data-parent="#accordion" 
                                                            id="collapse_biaya_tambahan"
                                                        >

                                                            <div class="container">

                                                                <p class="mt-3 mb-3">
                                                                    <input type="button" class="btn btn-primary btn-sm" id="input_biaya_tambahan" value="Biaya Tambahan Baru">
                                                                </p>

                                                                <?php if (mysqli_num_rows($biayaTambahan) != 0): ?>
                                                                    <!-- <li>
                                                                        <label>
                                                                            <input type="checkbox" name="software[]" value="<?php //echo $data1['id']; ?>"
                                                                                <?php //if (mysqli_num_rows($diagnosisSoftware) != 0): ?>
                                                                                    <?php //foreach ($diagnosisSoftware as $data2): ?>
                                                                                        <?php //if ($data1['id'] == $data2['id_jenis_layanan_sparepart']): ?>
                                                                                            checked
                                                                                        <?php //endif ?>
                                                                                    <?php //endforeach ?>
                                                                                <?php //endif ?>
                                                                            >
                                                                            <i class="bg-dark"></i>
                                                                            <span>
                                                                                <?php //echo $data1['nama_jenis_layanan'] . " [<b>" . format($data1['harga'], "currency") . "</b>]"; ?>
                                                                            </span>
                                                                        </label>
                                                                    </li> -->

                                                                    <div class="table-responsive mb-3">
                                                                        <table class="table table-hover table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Keterangan</th>
                                                                                    <th>Harga</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>

                                                                                <?php foreach ($biayaTambahan as $data1): ?>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <?php echo $data1['keterangan']; ?>
                                                                                        </td>
                                                                                        <td>
                                                                                            <?php echo format($data1['jumlah'], 'currency'); ?>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php endforeach ?>

                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                <?php endif ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Total Biaya -->
                                                    <div class="card-header border-right border-left border-top">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="mb-0 text-primary" style="text-">
                                                                    Total Biaya
                                                                </label>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="text-right" id='currency-total-biaya'>Rp 0</label>
                                                                <input type="hidden" value="0" name="total-biaya" id="total-biaya" onchange="getCurrency();">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <!-- Untuk konten lihat hasil diagnosis atau data pengerjaan -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Nama Jasa / Sparepart</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (mysqli_num_rows($diagnosisSoftware) > 0): ?>
                                                <tr>
                                                    <td class="text-left font-weight-bold" colspan="2">
                                                        &nbsp;&nbsp; Software
                                                    </td>
                                                </tr>
                                                <?php foreach ($diagnosisSoftware as $data): ?>
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                echo $no . ". " . $data['nama_jenis_layanan']; 
                                                                $no++;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                echo format($data['harga'], 'currency'); 
                                                                $totalHarga = $totalHarga + $data['harga'];
                                                            ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php if (mysqli_num_rows($diagnosisHardware) > 0): ?>
                                                <tr>
                                                    <td class="text-left font-weight-bold" colspan="2">
                                                        &nbsp;&nbsp;  Hardware
                                                    </td>
                                                </tr>
                                                <?php foreach ($diagnosisHardware as $data): ?>
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                echo $no . ". " . $data['nama_jenis_layanan'];  
                                                                $no++;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                echo format($data['harga'], 'currency'); 
                                                                $totalHarga = $totalHarga + $data['harga'];
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php if (mysqli_num_rows($diagnosisSparepart) > 0): ?>
                                                <tr>
                                                    <td class="text-left font-weight-bold" colspan="2">
                                                        &nbsp;&nbsp;  Sparepart
                                                    </td>
                                                </tr>
                                                <?php foreach ($diagnosisSparepart as $data): ?>
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                echo $no . ". " . $data['nama_sparepart']; 
                                                                $no++;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                                echo format($data['harga'], 'currency'); 
                                                                $totalHarga = $totalHarga + $data['harga'];
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <?php if (mysqli_num_rows($biayaTambahan) > 0): ?>
                                                <tr>
                                                    <td class="text-left font-weight-bold" colspan="2">
                                                        &nbsp;&nbsp;  Biaya Tambahan
                                                    </td>
                                                </tr>
                                                <?php foreach ($biayaTambahan as $data): ?>
                                                    <tr>
                                                        <td>
                                                            <?php 
                                                                echo $no . ". " . $data['keterangan']; 
                                                                $no++;
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                                echo format($data['jumlah'], 'currency');
                                                                $totalHarga = $totalHarga + $data['jumlah'];
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <!-- Riwayat Pembayaran -->
                                            <?php if (mysqli_num_rows($riwayatPembayaran) > 0) : ?>
                                                <tr style="font-weight: bold;">
                                                    <td colspan="3" style="text-align: left;">&emsp;Riwayat Pembayaran</td>
                                                </tr>
                                                <?php foreach ($riwayatPembayaran as $pembayaran) : ?>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            echo $no . ". "
                                                            ?>
                                                            Pembayaran <?php echo $pembayaran['info_pembayaran']; ?> tanggal <?php echo format($pembayaran['tgl_pembayaran'], "date"); ?>

                                                        </td>
                                                        <td class="text-right">
                                                            <?php
                                                            echo format($pembayaran['jumlah'], "currency");
                                                            $totalHarga = $totalHarga - $pembayaran['jumlah'];
                                                            ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <tr>
                                                <td class="text-right font-weight-bold">
                                                    Total Estimasi
                                                </td>
                                                <td class="font-weight-bold">
                                                    <?php echo format($totalHarga, 'currency'); ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>

                        <?php if ($action == 'lihat'): ?>
                            <h5 class="" id="ratingUlasan">Data Rating & Ulasan</h5>
                            <div class="form-group row">
                                <label class="control-label col-md-1" style="width: 120px; display: inline-block;">Rating :</label>
                                <div class="col-md-3">
                                    <p class="text-dark">
                                        <?php echo (isset($pemesanan['rating']) AND (!empty($pemesanan['rating']) OR $pemesanan['rating'] != NULL)) ? showRating($pemesanan['rating'], 20) : showRating(0, 20) ; echo " [" . $pemesanan['rating'] . "]";?>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-1" style="width: 120px; display: inline-block;">Ulasan :</label>
                                <div class="col-md-3">
                                    <p class="text-dark">
                                        <textarea class="form-control-plaintext" readonly><?php echo $pemesanan['ulasan']; ?></textarea>
                                    </p>
                                </div>
                            </div>
                        <?php endif ?>

                        <?php if ($action != 'lihat'): ?>
                            <div class="form-group pull-left">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" name="simpan"/>
                                    <input type="reset" class="btn btn-danger"/>
                                </div>
                            </div>
                        <?php endif ?>

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

<script type="text/javascript">
    function getCurrency() {
        var totalBiayaAwal = document.getElementById('currency-total-biaya').split(" ");
        $('label#currency-total-biaya').html(totalBiayaAwal[1] + $('input#total-biaya').val());
        console.log("getCurrency : Success...");
    }
</script>