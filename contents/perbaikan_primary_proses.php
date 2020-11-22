<?php
    $proses = (isset($_GET['proses'])) ? $_GET['proses'] : NULL ;
    if ($proses == NULL) {
        $_SESSION['message-type']       = "danger";
        $_SESSION['message-content']    = "Proses belum ditentukan..!";
        echo "<script>window.history.go(-1)</script>";
    }
    if ($proses == 'remove') {
		$id 			= antiInjection($_GET['id']);
	} else {
		if ($proses == 'edit') {
			$id 				= (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL;
		}
        $noPemesanan       		= getCode("PM-");
        $now 					= new DateTime();
        $now->format('Y-m-d H:i:s');
        $idKategori    			= (isset($_POST['id_kategori'])) ? $_POST['id_kategori'] : NULL;
        $tglPemesanan   		= date("Y-m-d H:i:s");
        $idPelanggan    		= (isset($_POST['id_pelanggan'])) ? $_POST['id_pelanggan'] : NULL;
        $namaPelanggan  		= (isset($_POST['nama_pelanggan'])) ? $_POST['nama_pelanggan'] : NULL;
        $noTelp         		= (isset($_POST['no_telp'])) ? $_POST['no_telp'] : NULL;
        $keLokasi     			= (isset($_POST['datang_ke_lokasi'])) ? $_POST['datang_ke_lokasi'] : "tidak";
        $tglKerja 				= (isset($_POST['tanggal_kerja']) OR !empty($_POST['tanggal_kerja'])) ? $_POST['tanggal_kerja'] : "";
        $alamat         		= (isset($_POST['alamat']) OR !empty($_POST['alamat'])) ? $_POST['alamat'] : "";
		$longlat        		= (isset($_POST['longlat']) OR !empty($_POST['longlat'])) ? $_POST['longlat'] : "";
		$keluhan				= "";
		$idTeknisi				= "";
		$namaTeknisi			= "";
        $statusPemesanan    	= "tunggu";
		$teknisiCheck			= "belum";
		$persetujuanPelanggan	= "belum";
		$pengerjaanKe			= "1";
    }
    $messages   = array();
    $sql		= "";
    $redirect	= "?content=perbaikan";

    switch ($proses) {
        case 'add':
            if (isset($_POST['simpan'])) {
                try {
                    /**
                     * Simpan data primary proses di $_SESSION
                     */
                    $_SESSION['data_pemesanan'] = [
                        'no_pemesanan'      => $noPemesanan,
                        'id_kategori'       => $idKategori,
                        'tanggal_pesan'     => $tglPemesanan,
                        'id_pelanggan'      => $idPelanggan,
                        'nama_pelanggan'    => $namaPelanggan,
                        'no_telp'           => $noTelp,
                        'datang_ke_lokasi'  => $keLokasi,
                        'tanggal_kerja'     => $tglKerja,
                        'alamat'            => $alamat,
                        'longlat'           => $longlat,
                        'status_pemesanan'  => $statusPemesanan
                    ];
                    
                    array_push(
                        $messages,
                        array("success", "Silahkan isi form keluhan..!")
                    );
                    // $_SESSION['message-content'] = "Pemesanan berhasil dilakukan, silahkan tunggu konfirmasi dari admin..!";
                    $redirect                       = "?content=perbaikan_secondary_form&action=tambah";
                    // $redirect                    = "?content=daftar_barang";
                    // $redirect                    = "?content=pembayaran";
                } catch (Exception $e) {
                    array_push(
                        $messages,
                        array("danger", "Pemesanan tidak berhasil dilakukan, silahkan coba lagi..!")
                    );
                    $redirect                       = "?content=perbaikan";
                }
            }
            break;

        default:
            # code...
            break;
    }

	if (!empty($messages)) {
		saveNotifikasi($messages);
	}

    echo "
        <script>
            window.location.replace('$redirect');
        </script>
    ";
?>