
<?php

	use \Punic\Unit;
	use \Punic\Number;
	use \Punic\Calendar;
	use \Punic\Currency;

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	
	if (($_SERVER['SERVER_NAME'] == "localhost") OR ($_SERVER['SERVER_NAME'] == "127.0.0.1")) {
		require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/' . explode("/", $_SERVER['REQUEST_URI'])[1] . '/' . 'plugins/punic/punic.php';
		require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/' . explode("/", $_SERVER['REQUEST_URI'])[1] . '/' . 'plugins/phpmailer/src/Exception.php';
		require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/' . explode("/", $_SERVER['REQUEST_URI'])[1] . '/' . 'plugins/phpmailer/src/PHPMailer.php';
		require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/' . explode("/", $_SERVER['REQUEST_URI'])[1] . '/' . 'plugins/phpmailer/src/POP3.php';
		require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/' . explode("/", $_SERVER['REQUEST_URI'])[1] . '/' . 'plugins/phpmailer/src/SMTP.php';
		// require $_SERVER['CONTEXT_DOCUMENT_ROOT'] . '/' . explode("/", $_SERVER['REQUEST_URI'])[1] . '/' . 'vendor/autoload.php';
	} else if ((($_SERVER['SERVER_NAME'] != "localhost") OR ($_SERVER['SERVER_NAME'] != "127.0.0.1")) AND count(explode('/', $_SERVER['REQUEST_URI'])) > 2 ) {
		require '../plugins/punic/punic.php' ;
		require '../plugins/phpmailer/src/Exception.php';
		require '../plugins/phpmailer/src/PHPMailer.php';
		require '../plugins/phpmailer/src/POP3.php';
		require '../plugins/phpmailer/src/SMTP.php';
		// require 'vendor/autoload.php';
	} else {
	    require 'plugins/punic/punic.php' ;
	    require 'plugins/phpmailer/src/Exception.php';
	    require 'plugins/phpmailer/src/PHPMailer.php';
	    require 'plugins/phpmailer/src/POP3.php';
	    require 'plugins/phpmailer/src/SMTP.php';
	}
	
    function cekLogin($type = 'pelanggan') {
        if (loginUser($type) === FALSE) {
            // header_remove();
            echo "<script> window.location.replace('" . class_static_value::$URL_BASE . "/login.php'); </script>";
        }
    }

    function loginUser($type) {
		$data = ((isset($_SESSION['logged-in'])) AND ($_SESSION['logged-in'] === TRUE) AND ($_SESSION['jenis_akun'] === $type)) ? TRUE : FALSE;
		return $data;
    }

	function setMenuAll(&$output = NULL, $parent = 0, $level = 0) {
        global $koneksi;
        $loginConditionTrue = "AND `nama` != 'Login' AND `nama` != 'Register' ";
        $loginConditionFalse = "AND `nama` != 'Profil' AND `nama` != 'Logout' ";
        // Select the categories that have on the parent column the value from $parent
        $r = ((isset($_SESSION['logged-in'])) AND ($_SESSION['logged-in'] == TRUE)) ? mysqli_query($koneksi, "SELECT `id_konfigurasi_menu_pelanggan`, `nama`, `url`, `konfigurasi_css` FROM `data_konfigurasi_menu_pelanggan` WHERE `parent` = '$parent' " . $loginConditionTrue) : mysqli_query($koneksi, "SELECT `id_konfigurasi_menu_pelanggan`, `nama`, `url`, `konfigurasi_css` FROM `data_konfigurasi_menu_pelanggan` WHERE `parent` = '$parent' " . $loginConditionFalse) ;
        // Show the categories one by one
        if (mysqli_num_rows($r) > 0) {
            $output .= "<ul class='";
            $had_child = ((isset($_SESSION['logged-in'])) AND ($_SESSION['logged-in'] == TRUE)) ? mysqli_num_rows(mysqli_query($koneksi, "SELECT `id_konfigurasi_menu_pelanggan` FROM `data_konfigurasi_menu_pelanggan` WHERE `parent` = '$parent' AND `parent` NOT LIKE 0 " . $loginConditionTrue)) : mysqli_num_rows(mysqli_query($koneksi, "SELECT `id_konfigurasi_menu_pelanggan` FROM `data_konfigurasi_menu_pelanggan` WHERE `parent` = '$parent' AND `parent` NOT LIKE 0 " . $loginConditionFalse)) ;
            if ($had_child > 0) {
				$output .= ($level !== 0) ? "dropdown" : "" ;
				// $level++;
            } else {
            	// $output .= "
            	// 	nav navbar-nav justify-content-end
            	// ";
            }
            $output .= "'>";
            foreach ($r as $c) {
            	$had_child = ((isset($_SESSION['logged-in'])) AND ($_SESSION['logged-in'] == TRUE)) ? mysqli_num_rows(mysqli_query($koneksi, "SELECT `id_konfigurasi_menu_pelanggan` FROM `data_konfigurasi_menu_pelanggan` WHERE `parent` = '$c[id_konfigurasi_menu_pelanggan]' " . $loginConditionTrue)) : mysqli_num_rows(mysqli_query($koneksi, "SELECT `id_konfigurasi_menu_pelanggan` FROM `data_konfigurasi_menu_pelanggan` WHERE `parent` = '$c[id_konfigurasi_menu_pelanggan]' " . $loginConditionFalse)) ;
                $output .= "<li class='";
            	if ($had_child > 0) {
            		// $output .= "
					// 		dropdown
					// ";
            	}
                $output .= "' id='" . $c['id_konfigurasi_menu_pelanggan'] . "'><a class='$c[konfigurasi_css]";
                if (($had_child > 0) AND ($level < 1)) {
					// $output .= " dropdown-toggle' data-toggle='dropdown' ";
				} else {
					$output .= "' ";
				}

				/* 	Untuk lihat level tambahkan
						" . $level . " '
					sebelum penutup kutip kedua
				*/
				if ($c['nama'] == '&lt;i class=&quot;fa fa-cog&quot;&gt;&lt;/i&gt;') {
                	$output .= ((isset($_SESSION['logged-in'])) AND ($_SESSION['logged-in'] == TRUE)) ? " href='" . $c['url'] . "'>" . $c['nama'] . " " . explode(' ', $_SESSION['nama_lengkap'])[0] . "</a>" : " href='" . $c['url'] . "'>" . $c['nama'] . "</a>" ;
				} else {
                	$output .= " href='" . $c['url'] . "'>" . $c['nama'] . "</a>";
				}

                if ($c['id_konfigurasi_menu_pelanggan'] != $parent) {
                    // In case the current category's id is different that $parent
                    // We call our function again with new parameters
                    setMenuAll($output, $c['id_konfigurasi_menu_pelanggan'], $level++);
                }
                $output .= "</li>";
            }
            $output .= "</ul>";
        }
        // Return the list of categories
        return $output;
    }

    function getMenuAll() {
        echo htmlspecialchars_decode(setMenuAll());
    }

	function antiInjection($data) {
	    global $koneksi;
	    $filter = mysqli_real_escape_string($koneksi, stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES))));
	    return $filter;
	}

	function saveNotifikasi(array $messages) {
		if (is_array($messages)) {
			$_SESSION['message-type'] = array();
			$_SESSION['message-content'] = array();
			for ($i=0; $i < count($messages); $i++) {
				array_push($_SESSION['message-type'], $messages[$i][0]);
				array_push($_SESSION['message-content'], $messages[$i][1]);
			}
		} else {
			echo "The variable of message is not in array. Please check again your message..!";
		}
	}

	function getNotifikasi() {
		$pesan = "";
		if (
			(isset($_SESSION['message-type']) | !empty($_SESSION['message-type']))
			&
			(isset($_SESSION['message-content']) | !empty($_SESSION['message-content']))
		) {
			if (is_array($_SESSION['message-type']) & is_array($_SESSION['message-content'])) {
				for ($i=0; $i < count($_SESSION['message-type']); $i++) {
					$typePesan 	= $_SESSION['message-type'][$i];
					$isiPesan 	= $_SESSION['message-content'][$i];
					// echo $typePesan . "<br>";
					// echo $isiPesan . "<br>";
					$pesan .= "<div class='alert alert-" . $typePesan . " alert-dismissable'><button class='close' type='button' data-dismiss='alert'>&times</button>" . $isiPesan . "</div>";
				}
			} else {
				$typePesan 	= $_SESSION['message-type'];
				$isiPesan 	= $_SESSION['message-content'];
				$pesan 		= "<div class='alert alert-" . $typePesan . " alert-dismissable'><button class='close' type='button' data-dismiss='alert'>&times</button>" . $isiPesan . "</div>";
			}
			unset($_SESSION['message-type']);
			unset($_SESSION['message-content']);
		}
		echo $pesan;
	}

	function uploadFile($file, $folder = "url_foto", $type = "img", $length = "short") {
		$server = (($_SERVER['SERVER_NAME'] == "localhost") OR ($_SERVER['SERVER_NAME'] == "127.0.0.1")) ? $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/" . explode("/", $_SERVER['REQUEST_URI'])[1] : $_SERVER['SERVER_NAME'] ;
		$rootFolder = (($_SERVER['SERVER_NAME'] == "localhost") OR ($_SERVER['SERVER_NAME'] == "127.0.0.1")) ? dirname($_SERVER['CONTEXT_DOCUMENT_ROOT'] . "/" . explode("/", $_SERVER['REQUEST_URI'])[1] . "/assets/" . $type) : dirname($_SERVER['CONTEXT_DOCUMENT_ROOT'] . "/assets/" . $type) ;

		$errors = array(); // Store all foreseen and unforseen errors here
		$fileExtensions = ['jpeg', 'jpg', 'png', 'gif']; // Get all the file extensions
		$data = NULL;
		$_FILES['upfile'] = $file;

		if (is_array($_FILES['upfile']['name'])) {
			// echo "$rootFolder";
			$dataArray = array();
			for ($i = 0; $i < count($_FILES['upfile']['name']); $i++) {
				$fileName 		= $_FILES['upfile']['name'][$i];
				$fileSize 		= $_FILES['upfile']['size'][$i];
				$fileTmpName 	= $_FILES['upfile']['tmp_name'][$i];
				$fileType 		= $_FILES['upfile']['type'][$i];
				$typeRef 		= explode('.', $fileName);
				$fileExtension 	= strtolower(end($typeRef));

				// echo $rootFolder . "/" . $folder . "<br>";
				if (!is_dir($rootFolder . "/" . $type . "/" . $folder)) {
					if (!mkdir($rootFolder . "/" . $type . "/" . $folder, null, true)) {
						array_push(
							$errors,
							array("danger", "Failed to create folders.")
						);
					}
				}

				// echo $_FILES['upfile']['tmp_name'] . "." . $fileExtension;
				// echo $data;

				if ($fileName != null) {

					$data = sha1_file($fileTmpName) . "." . $fileExtension;
					$uploadPath = $rootFolder . "/" . $type . "/" . $folder . "/" . basename($data);

					if (!in_array($fileExtension, $fileExtensions)) {
						$data = null;
						array_push(
							$errors,
							array("danger", "This $fileName extension is not allowed. Please upload a JPEG, GIF or PNG file")
						);
						// echo "This file extension is not allowed. Please upload a JPEG, GIF or PNG file";
					}
					if ($fileSize > 5000000) {
						$data = null;
						array_push(
							$errors,
							array("danger", "This $fileName is more than 5MB. Sorry, it has to be less than or equal to 5MB")
						);
					}
					if (empty($errors)) {
						$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
						if ($didUpload) {
							//echo "The file " . basename($fileName) . " has been uploaded";
							if ($length == 'full') {
								array_push(
									$dataArray,
									"$server/assets/$type/$folder/" . basename($data)
								);
							} elseif ($length == 'short') {
								array_push(
									$dataArray,
									"assets/$type/$folder/" . basename($data)
								);
							} elseif ($length == 'file') {
								array_push(
									$dataArray,
									"" . basename($data)
								);
							}
						} else {
							// echo "1";
							$data = null;
							array_push(
								$errors,
								array("danger", "$fileName tidak berhasil dipindahkan..!")
							);
							// saveNotifikasi($errors);
							$data = $errors;
						}
					} else {
						saveNotifikasi($errors);
						// $data = array();
						$data = null;
						// return $errors;
					}
				} else {
					$data = null;
				}
			}
			$data = array();
			$data = $dataArray;
		} else {
			// echo "$rootFolder";
			// $_FILES['upfile'] = $file;

			$fileName 		= $_FILES['upfile']['name'];
			$fileSize 		= $_FILES['upfile']['size'];
			$fileTmpName  	= $_FILES['upfile']['tmp_name'];
			$fileType 		= $_FILES['upfile']['type'];
			$typeRef		= explode('.', $fileName);
			$fileExtension 	= strtolower(end($typeRef));
			// echo $rootFolder . "/" . $type . "/" . $folder . "<br>";
			if (!is_dir($rootFolder . "/" . $type . "/" . $folder)) {
				if (!mkdir($rootFolder . "/" . $type . "/" . $folder, NULL, TRUE)) {
					array_push(
						$errors,
						array("danger", "Failed to create folders.")
					);
				}
			}

			// echo $_FILES['upfile']['tmp_name'] . "." . $fileExtension;
			// echo $data;

			if ($fileName != NULL) {

				$data = sha1_file($_FILES['upfile']['tmp_name']) . "." . $fileExtension;
				$uploadPath = $rootFolder . "/" . $type . "/" . $folder . "/" . basename($data);

				if (!in_array($fileExtension, $fileExtensions)) {
					$data = NULL;
					array_push(
						$errors,
						array("danger", "This file extension is not allowed. Please upload a JPEG, GIF or PNG file")
					);
					// echo "This file extension is not allowed. Please upload a JPEG, GIF or PNG file";
				}
				if ($fileSize > 5000000) {
					$data = NULL;
					array_push(
						$errors,
						array("danger", "This file is more than 5MB. Sorry, it has to be less than or equal to 5MB")
					);
				}
				if (empty($errors)) {
					$didUpload = move_uploaded_file($fileTmpName, $uploadPath);
					if ($didUpload) {
						echo "The file " . basename($fileName) . " has been uploaded in " . $uploadPath;
						// $data = $server . "/assets/" . $type . "/" . $folder . "/" . basename($data);
						if ($length == 'full') {
							$data = $server . "/assets/" . $type . "/" . $folder . "/" . basename($data);
						} elseif ($length == 'short') {
							$data = "assets/" . $type . "/" . $folder . "/" . basename($data);
						} elseif ($length == 'file') {
							$data = "" . basename($data);
						}
					} else {
						// echo "1";
						$data = NULL;
						array_push(
							$errors,
							array("danger", "File tidak berhasil dipindahkan..!")
						);
						// saveNotifikasi($errors);
						$data = $errors;
					}
				} else {
					saveNotifikasi($errors);
					// $data = array();
					$data = NULL;
					// return $errors;
				}
			} else {
				$data = NULL;
			}
		}
		if (!empty($errors)) {
			echo "
				<script>
					window.history.go(-1);
				</script>
			";
		}
		return $data;
	}

	function searchFile($locationFile = NULL, $type = 'img', $length = "file") {
		$server = (($_SERVER['SERVER_NAME'] == "localhost") OR ($_SERVER['SERVER_NAME'] == "127.0.0.1")) ? $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . "/" . explode("/", $_SERVER['REQUEST_URI'])[1] : $_SERVER['SERVER_NAME'] ;
		$result = $server . "/";
		// echo $result . "<br>";
        // $_SERVER['REQUEST_SCHEME']
		// $_SERVER['SERVER_NAME']
        // $_SERVER['SERVER_ADDR']
        // $_SERVER['REQUEST_URI']
        // $_SERVER['HTTP_HOST']
		// $_SERVER['DOCUMENT_ROOT']

		if ($length === "full") {
			$result = "";
		} elseif ($length === "short") {
			$result .= "";
		} elseif ($length == "file") {
			if ($type == "img") {
				$result .= "assets/img/";
			} elseif ($type == "pdf") {
				$result .= "assets/pdf/";
			}
		}
		// echo $result . $locationFile . "<br>";
		if 
			(
				(
					strpos(get_headers($result . $locationFile, 1)[0], "404") != TRUE
				) AND 
				(
					!empty($result) OR !empty($locationFile)
				)
			) {
			if (($length === "full")) {
				$result = (@getimagesize($result . $locationFile) !== 0) ? $locationFile : $server . "/assets/img/no_image.png";
			} elseif ($length === "short") {
				$result = (@getimagesize($result . $locationFile) !== 0) ? $result . $locationFile : $result . "assets/img/no_image.png";
			} elseif ($length === "file") {
				$result = (@getimagesize($result . $locationFile) !== 0) ? $result . $locationFile :  $server . "/assets/img/no_image.png";
			}
		} else {
			$result = $server . "/assets/img/no_image.png";
		}
		return $result;
	}

	function setBadges($string, $type = NULL, $shape = 'pill') {
		$data = "";
		if ($type == '' | $type == NULL | empty($type)) {
			if ($string == 'tunggu' OR $string == 'pending' OR $string == 'belum') {
				$type = 'warning';
			} elseif ($string == 'batal' OR $string == 'tolak' OR $string == 'non_aktif' OR $string == 'blokir' OR $string == 'tidak') {
				$type = 'danger';
			} elseif ($string == 'selesai' OR $string == 'aktif' OR $string == 'ya' OR $string == 'sudah') {
				$type = 'success';
			} else {
				$type = 'primary';
			}
		}
		$data = "<span class='badge badge-$shape badge-$type'>$string</span>";
        return $data;
	}

    function normalizeString($string, $case = NULL) {
        // Replace a Character with Another One (find, replace, string, count)
        $string = str_replace(array('_', '-'), ' ', $string);
        // Another Logic for Text Formatting
        switch ($case) {
            // Uppercase Each Words
            case 'ucw':
                $data = ucwords($string);
                break;
            // Uppercase First Character
            case 'ucf':
                $data = ucfirst($string);
                break;
            // Lowercase First Character
            case 'lcf':
                $data = lcfirst($string);
                break;
            // Converts a String to Uppercase
            case 'stu':
                $data = strtoupper($string);
                break;
            // Converts a String to Lowercase
            case 'stl':
                $data = strtolower($string);
                break;
            /**
             * Perform case folding on a string ( string $str , int $mode [, string $encoding = mb_internal_encoding() ] )
             * MODE : 
             * MB_CASE_UPPER, 
             * MB_CASE_LOWER, 
             * MB_CASE_TITLE, 
             * MB_CASE_FOLD, 
             * MB_CASE_LOWER_SIMPLE, 
             * MB_CASE_UPPER_SIMPLE, 
             * MB_CASE_TITLE_SIMPLE, 
             * MB_CASE_FOLD_SIMPLE
             */
            case 'mbcc':
                $mode       = MB_CASE_TITLE;
                $encoding   = 'UTF-8';
                $data       = mb_convert_case($string, $mode, $encoding = mb_internal_encoding());
                break;
            default:
                $data = $string;
                break;
        }
        return $data;
    }

	function format($value, $type, $dateFormat = "Y-m-d", $dateTimeFormat = "Y-m-d H:i", $currency = "IDR") {
		$data = "";
		switch ($type) {
			case 'number':
				$data .= Number::format($value, 0, 'it');
				break;
			case 'date':
				$value = Calendar::toDateTime($value);
				$data .= Calendar::format($value, 'd MMMM y', 'id');
				break;
			case 'datetime':
				$value = Calendar::toDateTime($value);
				$data .= Calendar::format($value, 'd MMMM y H:mm:ss', 'id');
				break;
			case 'currency':
				$data .= Currency::getSymbol($currency, 'narrow') . ". ". Number::format($value, 0, 'it');
				break;
			default:
				# code...
				break;
		}
		return $data;
	}

	//////////////////////////////////////////////////////////////////////
	//PARA: Date Should In YYYY-MM-DD Format
	//RESULT FORMAT:
	// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'      =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
	// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
	// '%m Month %d Day'                                            =>  3 Month 14 Day
	// '%d Day %h Hours'                                            =>  14 Day 11 Hours
	// '%d Day'                                                     =>  14 Days
	// '%h Hours %i Minute %s Seconds'                              =>  11 Hours 49 Minute 36 Seconds
	// '%i Minute %s Seconds'                                       =>  49 Minute 36 Seconds
	// '%h Hours                                                    =>  11 Hours
	// '%a Days                                                     =>  468 Days
	//////////////////////////////////////////////////////////////////////

	function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' ) {
	    $datetime1	= date_create($date_1);
	    $datetime2	= date_create($date_2);
	    $interval	= date_diff($datetime1, $datetime2);
	    return $interval->format($differenceFormat);
	}

    function getKonfigurasiUmumAll() {
        global $koneksi;
        $data = null;
        $sql = "
			SELECT *
			FROM `data_konfigurasi_umum`
		";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

    function getKonfigurasiUmumLimitAll($page, $recordCount = 12, $order = 'DESC') {
        global $koneksi;
        $limit = ($page * $recordCount) - $recordCount;
        $offset = $recordCount;
        $data = null;
        $sql = "
			SELECT *
			FROM `data_konfigurasi_umum`
			ORDER BY `id_konfigurasi_umum` $order
			LIMIT $limit, $offset
		";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

    function getKonfigurasiUmum($namaKonfigurasi = null, $type = "single") {
        global $koneksi;
        $data = null;
        $sql = "";
        if ($namaKonfigurasi == null) {
            $data = "Nama Konfigurasi belum ditentukan..!";
        } else {
            $sql = "
				SELECT *
				FROM `data_konfigurasi_umum`
				WHERE `nama_konfigurasi` = '$namaKonfigurasi'
			";
            if ($type == 'single') {
                $data = mysqli_fetch_array(
                    mysqli_query($koneksi, $sql),
                    MYSQLI_BOTH
                );
            } elseif ($type == 'multiple') {
                $data = mysqli_query($koneksi, $sql) or die($koneksi);
            } else {
                $data = "Type tidak diketahui..!";
            }
        }
        return $data;
    }

    function getKonfigurasiUmumById($id) {
        global $koneksi;
        $data = null;
        $sql = "
			SELECT *
			FROM `data_konfigurasi_umum`
			WHERE `id_konfigurasi_umum` = '$id'
		";
        $data = mysqli_query($koneksi, $sql) or die($koneksi);
        return $data;
    }

	function getCode($prefix = null) {
		$data = "";
		$dateNow = date("YmdHis");
		$data = ($prefix != null) ? $prefix . $dateNow : $dateNow;
		return $data;
	}

	function checkToken($token, $user = NULL, $purpose = 'check') {
		global $koneksi;
		$sql = "SELECT `user_token` FROM ";
		$result = NULL;
		if ($purpose == 'check') {
			$sql .= ($user != NULL) ? "`" . $user . "` " : "`data_pengguna` ";
		} elseif ($purpose == 'generate') {
			$sql .= ($user != NULL) ? "`" . $user . "` " : "`data_pengguna` ";
		}
		$sql .= "WHERE `user_token` = '$token'";
		if ($purpose == 'check') {
			$result = (mysqli_num_rows(mysqli_query($koneksi, $sql)) > 0) ? TRUE : FALSE;
		} elseif ($purpose == 'generate') {
			$result = (mysqli_num_rows(mysqli_query($koneksi, $sql)) > 0) ? FALSE : TRUE;
		}
		return $result;
	}

	function generateToken($prefix = null) {
		$tokenLength = 25;
		$stringToken = "1234567890abcdefghijklmnopqrstuvwxyz_";
		$randomToken = ($prefix != NULL) ? $prefix . "-" . substr(str_shuffle($stringToken), 0, $tokenLength) : substr(str_shuffle($stringToken), 0, $tokenLength);
		$checkToken = checkToken($randomToken, 'data_pelanggan', 'check');
		while ($checkToken == TRUE) {
			$randomToken = substr(str_shuffle($stringToken), 0, $tokenLength);
			$checkToken = checkToken($randomToken, 'data_pelanggan', 'check');
		}
		return $randomToken;
	}

	function sendEmail($from = NULL, $to = NULL, $subject = '', $messages = '', $attachment = NULL, $cc = '', $bcc = '', $type = 'smtp') {
		$from = ($from != NULL) ? $from : 'ibnu.tuharea@stimednp.ac.id' ;
		switch ($subject) {
			case 'transaction_out':
				$subject = "Permohonan transaksi perbaikan " . $messages['no_pemesanan'] . " telah diteruskan.";
				$message = "
					Anda melakukan pengajuan transaksi perbaikan untuk perangkat " . $messages['nama_kategori_layanan'] . " dengan nomor transaksi " . $messages['no_pemesanan'] . " pada tanggal " . $messages['tanggal'] . ". Transaksi telah diteruskan ke Administrator. Mohon tunggu informasi lebih lanjut.
				";
				break;
			case 'transaction_in':
				$subject = "Permohonan transaksi perbaikan baru telah masuk.";
				$message = "
					Transaksi perbaikan baru telah diterima. Rincian Transaksi : <br>
						No. Transaksi : " . $messages['no_pemesanan'] . "<br>
						Tanggal : " . $messages['tanggal'] . "<br>
						Kategori Layanan : " . $messages['nama_kategori_layanan'] . "<br>
						Nama Pelanggan : " . $messages['nama_pelanggan'] . "<br>
						No. Telepon : " . $messages['no_telp'] . " <br>
					Segera tentukan teknisi yang bertugas menangani transaksi tersebut.
				";
				break;
			case 'assign_technician':
				$subject = "Teknisi untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah ditentukan.";
				$message = "
					Transaksi perbaikan anda dengan No. Transaksi " . $messages['no_pemesanan'] . " Transaksi  telah diproses oleh Administrator dan teknisi telah ditugaskan untuk menangani transaksi tersebut. Rincian Teknisi : <br>
						Nama Teknisi : " . $messages['nama_teknisi'] . "<br>
						Alamat : " . $messages['alamat'] . "<br>
						No. Telepon : " . $messages['no_telp'] . "<br>
					Mohon tunggu konfirmasi dari teknisi yang bertugas.
				";
				break;
			case 'technician_transaction_in':
				$subject = "Transaksi perbaikan " . $messages['no_pemesanan'] . " telah masuk.";
				$message = "
					Transaksi perbaikan baru telah masuk. Rincian Transaksi : <br>
						No. Transaksi : " . $messages['no_pemesanan'] . "<br>
						Tanggal : " . $messages['tanggal'] . "<br>
						Kategori Layanan : " . $messages['nama_kategori_layanan'] . "<br>
						Nama Pelanggan : " . $messages['nama_pelanggan'] . "<br>
						No. Telepon : " . $messages['no_telp'] . " <br>
					Segera lakukan proses atau batalkan transaksi tersebut.
				";
				break;
			case 'technician_processed':
				$subject = "Transaksi perbaikan " . $messages['no_pemesanan'] . " telah diproses.";
				$message = "
					Transaksi perbaikan " . $messages['no_pemesanan'] . " telah diproses oleh Teknisi. Mohon tunggu info selanjutnya dari Teknisi.
				";
				break;
			case 'technician_workmanship':
				$message = "
					blablabla
				";
				break;
			case 'technician_process_workmanship':
				$message = "
						blablabla
					";
				break;
			case 'customer_workmanship_agreed':
				$subject = "Pengerjaan ke " . $messages['pengerjaan_ke'] . " untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah disetujui.";
				$message = "
					Pengerjaan untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah <b>disetujui</b> oleh pelanggan. Silahkan lanjutkan perbaikan. <a href='" . $messages['link'] . "'>Klik disini.</a>
				";
				break;
			case 'customer_workmanship_disagreed':
				$subject = "Pengerjaan ke " . $messages['pengerjaan_ke'] . " untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah ditolak.";
				$message = "
					Pengerjaan untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah <b>ditolak</b> oleh pelanggan. Silahkan lanjutkan perbaikan. <a href='" . $messages['link'] . "'>Klik disini.</a>
				";
				break;
			case 'technician_finish_workmanship':
				$subject = "Pengerjaan untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah selesai.";
				$message = "
					Pengerjaan untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah diselesaikan oleh Teknisi [" . $messages['id_teknisi'] . "] " . $messages['nama_teknisi'] . ". Silahkan lakukan konfirmasi apabila perangkat telah diterima. <a href='" . $messages['link'] . "'>Klik disini.</a>
				";
				break;
			case 'customer_cancel_transaction':
				$subject = "Transaksi Perbaikan " . $messages['no_pemesanan'] . " dibatalkan.";
				$message = "
					Transaksi perbaikan " . $messages['no_pemesanan'] . " telah dibatalkan oleh [" . $messages['id_pelanggan'] . "] " . $messages['nama_pelanggan'] . ". <a href='" . $messages['link'] . "'>Klik disini</a>.
				";
				break;
			case 'customer_finish_transaction':
				$subject = "Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah selesai.";
				$message = "
					Perangkat yang sudah diperbaiki telah diterima oleh pelanggan [" . $messages['id_pelanggan'] . "] " . $messages['nama_pelanggan'] . " dan Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah selesai oleh.
				";
			case 'send_confirm_result_to_customer':
				$subject = "Pembayaran untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " dinyatakan ";
				if ($messages['hasil_konfirmasi'] == 'ya') {
					$subject .= "sah";
				} elseif ($messages['hasil_konfirmasi'] == 'tidak') {
					$subject .= "tidak sah";
				}
				$subject .= ".";

				$message = "Pelanggan yang terhormat, pembayaran anda untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah dikonfirmasi oleh administrator dan dinyatakan "; 
				if ($messages['hasil_konfirmasi'] == 'ya') {
					$message .= "sah";
				} elseif ($messages['hasil_konfirmasi'] == 'tidak') {
					$message .= "tidak sah";
				}
				$message .= ". "; 
				if ($messages['hasil_konfirmasi'] == 'ya') {
					$message .= "Mohon tunggu proses pengembalian perangkat oleh Teknisi dan menyelesaikan transaksi perbaikan anda.";
				} elseif ($messages['hasil_konfirmasi'] == 'tidak') {
					$message .= "Mohon unggah kembali bukti pembayaran yang sah untuk mengambil perangkat anda dan menyelesaikan transaksi perbaikan anda.";
				}
				break;
			case 'send_confirm_result_to_technician':
				$subject = "Pembayaran untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " dinyatakan ";
				if ($messages['hasil_konfirmasi'] == 'ya') {
					$subject .= "sah";
				} elseif ($messages['hasil_konfirmasi'] == 'tidak') {
					$subject .= "tidak sah";
				}
				$subject .= ".";

				$message = "Pembayaran untuk Transaksi Perbaikan " . $messages['no_pemesanan'] . " telah dikonfirmasi oleh administrator dan dinyatakan "; 
				if ($messages['hasil_konfirmasi'] == 'ya') {
					$message .= "sah";
				} elseif ($messages['hasil_konfirmasi'] == 'tidak') {
					$message .= "tidak sah";
				}
				$message .= ". "; 
				if ($messages['hasil_konfirmasi'] == 'ya') {
					$message .= "Mohon segera lakukan proses pengembalian perangkat oleh Pelanggan " . $messages['nama_lengkap'] . " dan menyelesaikan transaksi perbaikan.";
				} elseif ($messages['hasil_konfirmasi'] == 'tidak') {
					$message .= "Mohon tunggu sampai Pelanggan mengunggah kembali bukti pembayaran yang sah untuk mengambil perangkat dan menyelesaikan transaksi perbaikan.";
				}
				break;
			default:
				$message = $messages;
				break;
		}
		$mail = new PHPMailer(true);								// Passing `true` enables exceptions
		try {
			//Server settings
			// $mail->SMTPDebug = 1;									// 2 = Enable verbose debug output
			$mail->isSMTP();										// Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';							// Specify main and backup SMTP servers
			$mail->SMTPAuth = true;									// Enable SMTP authentication
			$mail->Username = $from;								// SMTP username
			$mail->Password = 'ibent1995';							// SMTP password
			$mail->SMTPSecure = 'tls';								// Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;										// TCP port to connect to

			//Recipients
			// $mail->setFrom('from@example.com', 'Mailer');
			$mail->setFrom($from);
			// $mail->addAddress('joe@example.net', 'Joe User');	// Add a recipient
			$mail->addAddress($to);									// Name is optional
			// $mail->addReplyTo('info@example.com', 'Information');
			// $mail->addCC($cc);									// $mail->addCC('cc@example.com');
			// $mail->addBCC($bcc);									// $mail->addBCC('bcc@example.com');

			//Attachments
			if ($attachment != NULL) {
				$mail->addAttachment('/var/tmp/file.tar.gz');		// Add attachments
				$mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name
			}

			//Content
			$mail->isHTML(true);                                  	// Set email format to HTML
			$mail->Subject = $subject;								// 'Here is the subject'
			$mail->Body    = $message;								// 'This is the HTML message body <b>in bold!</b>'
			$mail->AltBody = strip_tags($message);					// 'This is the body in plain text for non-HTML mail clients'

			$mail->send();
			// echo 'Message has been sent';
		} catch (Exception $e) {
			// echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
	}

	function showRating($rating, $fontSize) {
        $stars = "<span id='ratingTemplate' style='text-align: center;'>";
        for ($i = 0; $i < 5; $i++) {
            if ($i < $rating) {
                // document.getElementById((i + 1) + subid).style.color = "orange";
                $stars .= "<i id='" . ($i + 1) . "-star' style='font-size:" . $fontSize . "px; color: orange;' class='fa fa-star star-checked'></i>";
            } else {
                // document.getElementById((i + 1) + subid).style.color = "black";
                $stars .= "<i id='" . ($i + 1) . "-star' style='font-size:" . $fontSize . "px; color: black;' class='fa fa-star'></i>";
            }
        }
        $stars .= "</span>";
        return $stars;
	}

	function calculateAllRating($ratings) {
		$a = 0;
		$b = 0;
		$total = 0;
		// Rumus (5*252 + 4*124 + 3*40 + 2*29 + 1*33) / (252+124+40+29+33) = 4.11 and change
		if (is_array($ratings)) {
			foreach ($ratings as $rating) {
				$a += $rating['star'] * $rating['count'];
				$b += $rating['count'];
			}
			$total = ($a != 0 AND $b != 0) ? (float) $a / $b : 0 ;
		} else {
			$total = "Sorry, the data type that you pass is not in array..!";
		}
		return $total;
	}

	function getNotifikasiUmumAll($type = "info", $info = "", $tujuan = "semua", $statusShow = "belum", $statusBaca = "belum", $order = 'DESC') {
		global $koneksi;
		$data = array();
		$sql = "SELECT * FROM `data_notifikasi` WHERE `tipe_notifikasi` LIKE '$type%' AND `info_notifikasi` LIKE '$info%' AND `tujuan` LIKE '$tujuan%' AND `status_show` LIKE '$statusShow%' AND `status_baca` LIKE '$statusBaca%' ORDER BY `id_notifikasi` $order";
		$notifikasiAll = mysqli_query($koneksi, $sql) or die($koneksi);
		foreach ($notifikasiAll as $notifikasi) {
			$data[] = $notifikasi;
		}
		return $data;
	}

	function getNotifikasiUmumById($id) {
		global $koneksi;
		$data = null;
		$sql = "SELECT * FROM `data_notifikasi` WHERE `id_notifikasi` = '$id'";
		$data = mysqli_query($koneksi, $sql) or die($koneksi);
		return $data;
	}

	function setNotifikasiUmum($type = "info", $info = "", $isi = "", $tujuan = "semua", $statusShow = "belum", $statusBaca = "belum") {
		global $koneksi;
		$result = array();
		$sql = "INSERT INTO `data_notifikasi` (`tipe_notifikasi`, `info_notifikasi`, `isi_notifikasi`, `tujuan`, `status_show`, `status_baca`) VALUES ('$type', '$info', '$isi', '$tujuan', '$statusShow', '$statusBaca')";
		$data = mysqli_query($koneksi, $sql);
		if ($data) {
			$result = array("message-type" => "success", "message-content" => "success");
		} else {
			$result = array("message-type" => "danger", "message-content" => "failed");
		} 
		return $result;
	}

	function setShowNotifikasiUmum($id = NULL) {
		global $koneksi;
		$result = array();
		$sql = "UPDATE `data_notifikasi` SET `status_show` = 'sudah' WHERE `id_notifikasi` = '$id'";
		$data = mysqli_query($koneksi, $sql);
		if ($data) {
			$result = array("message-type" => "success", "message-content" => "success");
		} else {
			$result = array("message-type" => "danger", "message-content" => "failed, to run '$sql'");
		}
		return $result;
	}

	function setReadNotifikasiUmum($id = NULL) {
		global $koneksi;
		$result = array();
		$sql = "UPDATE `data_notifikasi` SET `status_baca` = 'sudah' WHERE `id_notifikasi` = '$id'";
		$data = mysqli_query($koneksi, $sql);
		if ($data) {
			$result = array("message-type" => "success", "message-content" => "success");
		} else {
			$result = array("message-type" => "danger", "message-content" => "failed, to run '$sql'");
		}
		return $result;
	}

	function getNotifikasiAdministratorAll($type = "info", $info = "", $statusShow = "belum", $statusBaca = "belum", $order = 'DESC') {
		global $koneksi;
		$data = array();
		$sql = "SELECT * FROM `data_notifikasi_administrator` WHERE `tipe_notifikasi` LIKE '$type%' AND `info_notifikasi` LIKE '$info%' AND `status_show` LIKE '$statusShow%' AND `status_baca` LIKE '$statusBaca%' ORDER BY `id_notifikasi` $order";
		$notifikasiAll = mysqli_query($koneksi, $sql) or die($koneksi);
		foreach ($notifikasiAll as $notifikasi) {
			$data[] = $notifikasi;
		}
		return $data;
	}

	function setNotifikasiAdministratorAll($type = "info", $info = "", $statusShow = "belum", $statusBaca = "belum", $order = 'DESC') {
		global $koneksi;
		$data = array();
		$sql = "SELECT * FROM `data_notifikasi_administrator` WHERE `tipe_notifikasi` LIKE '$type%' AND `info_notifikasi` LIKE '$info%' AND `status_show` LIKE '$statusShow%' AND `status_baca` LIKE '$statusBaca%' ORDER BY `id_notifikasi` $order";
		$notifikasiAll = mysqli_query($koneksi, $sql) or die($koneksi);
		foreach ($notifikasiAll as $notifikasi) {
			$data[] = $notifikasi;
		}
		return $data;
	}

	function setShowNotifikasiAdministratorById($id = NULL) {
		global $koneksi;
		$result = array();
		$sql = "UPDATE `data_notifikasi_administrator` SET `status_show` = 'sudah' WHERE `id_notifikasi` = '$id'";
		$data = mysqli_query($koneksi, $sql);
		if ($data) {
			$result = array("message-type" => "success", "message-content" => "success");
		} else {
			$result = array("message-type" => "danger", "message-content" => "failed, to run '$sql'");
		}
		return $result;
	}

	function setReadNotifikasiAdministratorAll($id = NULL) {
		global $koneksi;
		$result = array();
		$sql = "UPDATE `data_notifikasi_administrator` SET `status_baca` = 'sudah' WHERE `id_notifikasi` = '$id'";
		$data = mysqli_query($koneksi, $sql);
		if ($data) {
			$result = array("message-type" => "success", "message-content" => "success");
		} else {
			$result = array("message-type" => "danger", "message-content" => "failed, to run '$sql'");
		}
		return $result;
	}

	function getNotifikasiTeknisiByIdAll($type = "info", $info = "", $idTeknisi = NULL, $statusShow = "belum", $statusBaca = "belum", $order = 'DESC') {
		global $koneksi;
		$data = array();
		$sql = "SELECT * FROM `data_notifikasi_teknisi` WHERE `tipe_notifikasi` LIKE '$type%' AND `info_notifikasi` LIKE '$info%' AND `id_teknisi` = '$idTeknisi' AND `status_show` LIKE '$statusShow%' AND `status_baca` LIKE '$statusBaca%' ORDER BY `id_notifikasi` $order";
		$notifikasiAll = mysqli_query($koneksi, $sql) or die($koneksi);
		foreach ($notifikasiAll as $notifikasi) {
			$data[] = $notifikasi;
		}
		return $data;
	}

	function setNotifikasiTeknisiByIdTeknisi($type = "info", $info = "", $idTeknisi = NULL, $statusShow = "belum", $statusBaca = "belum", $order = 'DESC') {
		global $koneksi;
		$data = array();
		$sql = "SELECT * FROM `data_notifikasi_administrator` WHERE `tipe_notifikasi` LIKE '$type%' AND `info_notifikasi` LIKE '$info%' AND `id_teknisi` = '$idTeknisi' AND `status_show` LIKE '$statusShow%' AND `status_baca` LIKE '$statusBaca%' ORDER BY `id_notifikasi` $order";
		$notifikasiAll = mysqli_query($koneksi, $sql) or die($koneksi);
		foreach ($notifikasiAll as $notifikasi) {
			$data[] = $notifikasi;
		}
		return $data;
	}

	function setShowNotifikasiTeknisiById($id = NULL) {
		global $koneksi;
		$result = array();
		$sql = "UPDATE `data_notifikasi_teknisi` SET `status_show` = 'sudah' WHERE `id_notifikasi` = '$id'";
		$data = mysqli_query($koneksi, $sql);
		if ($data) {
			$result = array("message-type" => "success", "message-content" => "success");
		} else {
			$result = array("message-type" => "danger", "message-content" => "failed, to run '$sql'");
		}
		return $result;
	}

	function setReadNotifikasiTeknisiById($id = NULL) {
		global $koneksi;
		$result = array();
		$sql = "UPDATE `data_notifikasi_teknisi` SET `status_baca` = 'sudah' WHERE `id_notifikasi` = '$id'";
		$data = mysqli_query($koneksi, $sql);
		if ($data) {
			$result = array("message-type" => "success", "message-content" => "success");
		} else {
			$result = array("message-type" => "danger", "message-content" => "failed, to run '$sql'");
		}
		return $result;
	}

?>