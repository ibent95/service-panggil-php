<?php
	require '../load_files.php';

	$content = (isset($_GET['content'])) ? antiInjection($_GET['content']) : NULL ;
	$i = 1;

	// $csv = new class_static_value();

	$response = "";

	switch ($content) {
		case 'search_data_pengguna_teknisi':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchTeknisiByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='6'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[id]</td>
							<td>
								<button 
                                    type='button' 
                                    class='btn btn-link' data-toggle='modal' data-target='#pengguna_detail'
                                >
                                    $data[nama_lengkap]
                                </button>
							</td>
							<td>$data[alamat]</td>
							<td>$data[no_hp]</td>
							<td>";
					$response .= setBadges($data['status_akun'], 'success') . "
							</td>
							<td>
					";
					$response .= "

                                <button 
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal' 
                                    data-target='#modal_detail_pengguna'
                                    data-id='$data[id]'
                                    data-content='data_pengguna_teknisi'
                                    id='detail_pengguna'
                                >
                                    Rincian
                                </button>
					";
					if ($_SESSION['jenis_akun'] == 'admin') {
						$response .= "
								<a 
									class='btn btn-primary btn-sm'
									href='?content=data_pengguna_teknisi_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a 
									class='btn btn-danger btn-sm' 
									href='?content=data_pengguna_teknisi_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?\");'
								>
									Hapus
								</a>
						";
					}

					$response .= "	
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_data_pengguna_pelanggan':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPelangganByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='6'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[id]</td>
							<td>
								<button 
                                    type='button' 
                                    class='btn btn-link' data-toggle='modal' data-target='#pengguna_detail'
                                >
                                    $data[nama_lengkap]
                                </button>
							</td>
							<td>$data[alamat]</td>
							<td>$data[no_hp]</td>
							<td>";
					$response .= setBadges($data['status_akun'], 'success') . "
							</td>
							<td>
					";
					$response .= "

                                <button 
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal' 
                                    data-target='#modal_detail_pengguna'
                                    data-id='$data[id]'
                                    data-content='data_pengguna_pelanggan'
                                    id='detail_pengguna'
                                >
                                    Rincian
                                </button>
					";
					if ($_SESSION['jenis_akun'] == 'admin') {
						$response .= "
								<a 
									class='btn btn-primary btn-sm'
									href='?content=data_pengguna_pelanggan_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a 
									class='btn btn-danger btn-sm' 
									href='?content=data_pengguna_pelanggan_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?\");'
								>
									Hapus
								</a>
						";
					}

					$response .= "	
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_data_pengguna':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPenggunaByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='7'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[id]</td>
							<td>
								<button 
                                    type='button' 
                                    class='btn btn-link' data-toggle='modal' data-target='#pengguna_detail'
                                >
                                    $data[nama_lengkap]
                                </button>
							</td>
							<td>$data[alamat]</td>
							<td>$data[no_hp]</td>
							<td>$data[jenis_akun]</td>
							<td>";
					$response .= setBadges($data['status_akun'], 'success') . "
							</td>
							<td>
					";	
					$response .= "
                                <button 
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal' 
                                    data-target='#modal_detail_pengguna'
                                    data-id='$data[id]'
                                    data-content='data_pengguna'
                                    id='detail_pengguna'
                                >
                                    Rincian
                                </button>
					";
					if ($_SESSION['jenis_akun'] == 'admin') {
						$response .= "
								<a 
									class='btn btn-primary btn-sm'
									href='?content=data_pengguna_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a 
									class='btn btn-danger btn-sm' 
									href='?content=data_pengguna_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?\");'
								>
									Hapus
								</a>
						";
					}
					$response .= "	
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_data_layanan_kategori':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchKategoriByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='2'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[nama_kategori_layanan]</td>
							<td>
								<a 
									class='btn btn-primary btn-sm'
									href='?content=data_layanan_kategori_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a 
									class='btn btn-danger btn-sm' 
									href='?content=data_layanan_kategori_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?\");'
								>
									Hapus
								</a>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_data_layanan_jenis_hardware':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchJenisHardwareByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='4'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[nama_kategori_layanan]</td>
							<td>$data[nama_jenis_layanan]</td>
							<td>$data[harga]</td>
							<td>
								<a 
									class='btn btn-primary btn-sm'
									href='?content=data_layanan_jenis_hardware_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a 
									class='btn btn-danger btn-sm' 
									href='?content=data_layanan_jenis_hardware_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?\");'
								>
									Hapus
								</a>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_data_layanan_jenis_software':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchJenisSoftwareByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='4'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[nama_kategori_layanan]</td>
							<td>$data[nama_jenis_layanan]</td>
							<td>$data[harga]</td>
							<td>
								<a 
									class='btn btn-primary btn-sm'
									href='?content=data_layanan_jenis_software_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a 
									class='btn btn-danger btn-sm' 
									href='?content=data_layanan_jenis_software_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?\");'
								>
									Hapus
								</a>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_data_sparepart':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchSparepartByKeyWord($key_word);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='4'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[nama_sparepart]</td>
							<td>
					";
					$response .= format($data['harga'], 'currency');
					$response .= "
							</td>
							<td>$data[persediaan]</td>
							<td>
								<a 
									class='btn btn-primary btn-sm'
									href='?content=data_sparepart_form&action=ubah&id=$data[0]'
								>
									Ubah
								</a>
								<a 
									class='btn btn-danger btn-sm' 
									href='?content=data_sparepart_proses&proses=remove&id=$data[0]'
									onclick=\"return confirm('Anda yakin ingin menghapus data ini..?\");'
								>
									Hapus
								</a>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_pemesanan_admin':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPemesananByKeyWord($key_word, 'tunggu');
			if (mysqli_num_rows($result) < 1) {
				$response .= "<tr><td colspan='6'><p align='center'>Hasil pencarian tidak ditemukan..!</p></td></tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$pembayaran = mysqli_num_rows(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], ''));
					$response .= "<tr>
							<td>$data[tanggal_pesan]</td>
							<td>$data[3]</td>
							<td>$data[tanggal_kerja]</td><td>";
					$response .= setBadges($data['status_pemesanan']) . "</td><td>";
					if ($pembayaran < 1) {
                        $response .= setBadges("Belum Membayar", "danger");
                    } else {
                        $response .= setBadges("Sudah Membayar", "success");
                        $response .= "<button
                            class='btn btn-link btn-sm'
                            data-toggle='modal'
                            data-target='#modal_bukti_pembayaran'
                            data-id='$data[id_pemesanan]'
                            data-content='pemesanan'
                            id='bukti_pembayaran'
                        >
                            Lihat Bukti Pembayaran
                        </button>";
                    }
					$response .= "<td>";
						if ($data['status_pemesanan'] == 'tunggu' AND $pembayaran < 1 AND $data['id_teknisi'] == 0 AND $data['teknisi_check'] == 'belum') {
							$response .= "<a class='btn btn-primary btn-sm' href='?content=pemesanan_persetujuan&action=pilih_teknisi&id=$data[0]'>Pilih Teknisi</a>";
                        } elseif ($data['status_pemesanan'] == 'tunggu' AND $pembayaran >= 1 AND $data['id_teknisi'] != 0 AND $data['teknisi_check'] == 'sudah' AND (mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], 'panjar'))['konfirmasi_admin'] == 'belum')) {
                        	$response .= "<a class='btn btn-primary btn-sm' href='?content=pemesanan_persetujuan&action=konfirmasi_pembayaran_panjar&id=$data[id_pemesanan]'>Konfirmasi Pembayaran Panjar</a>";
                                                    
                        } elseif ($data['status_pemesanan'] == 'proses' AND $pembayaran >= 1 AND $data['id_teknisi'] != 0 AND $data['teknisi_check'] == 'selesai' AND (mysqli_fetch_assoc(getBuktiPembayaranByIdPemesanan($data['id_pemesanan'], 'lunas'))['konfirmasi_admin'] == 'belum')) {
                        	$response .= "<a class='btn btn-primary btn-sm' href='?content=pemesanan_persetujuan&action=konfirmasi_pembayaran_lunas&id=$data[id_pemesanan]'>Konfirmasi Pembayaran Lunas</a>";
                        }
                        $response .= "<a class='btn btn-dark btn-sm' href='?content=diagnosis&action=lihat&id=$data[0]'><i class='fas fa-list'></i> Rincian</a>";
					$response .= "</td></tr>";
				}
			}
			break;
		case 'search_pemesanan_teknisi':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = ($_SESSION['jenis_akun'] == 'admin') ? searchPemesananByKeyWord($key_word, 'tunggu') : searchPemesananByIdTeknisiKeyWord($key_word, $_SESSION['id'], 'proses') ;
			if (mysqli_num_rows($result) < 1) {
				// if ($_SESSION['jenis_akun'] == 'admin') {
					$response .= "<tr><td colspan='6'><p align='center'>Hasil pencarian tidak ditemukan..!</p></td></tr>";
				// } else {
				// 	$response .= "<tr><td colspan='6'><p align='center'>Hasil pencarian tidak ditemukan..!</p></td></tr>";
				// }
				
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "<tr>
							<td>$data[tanggal_pesan]</td>
							<td>$data[3]</td>
							<td>$data[tanggal_kerja]</td><td>";
					$response .= setBadges($data['status_pemesanan']) . "</td>";
					if ($_SESSION['jenis_akun'] == 'teknisi') {
						$response .= "<td>";
						$response .= setBadges($data['teknisi_check']);
						$response .= "</td>";
					}
					$response .="<td>
							<a class='btn btn-primary btn-sm' href='?content=pemesanan_persetujuan&action=persetujuan&id=$data[0]'>Approval</a>
                                <button class='btn btn-dark btn-sm' data-toggle='modal' data-target='#modal_detail_pemesanan' data-id='$data[0]' data-content='pemesanan' id='detail_pemesanan'>Rincian</button>";
					if ($_SESSION['jenis_akun'] == 'admin') {
						$response .= "<a class='btn btn-info btn-sm' href='?content=pemesanan_form&action=ubah&id=$data[0]'>Ubah</a><a class='btn btn-danger btn-sm' href='?content=pemesanan_proses&proses=remove&id=$data[0]' onclick='return confirm('Anda yakin ingin menghapus data ini..?');'>Hapus</a>";
					}
					$response .= "</td></tr>";
				}
			}
			break;
		case 'search_pemesanan_riwayat_proses':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPemesananByKeyWord($key_word, 'proses');
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='6'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[tanggal_pesan]</td>
							<td>$data[3]</td>
							<td>$data[tanggal_kerja]</td>
							<td>$data[9]</td>
							<td>";
					$response .= setBadges($data['status_pemesanan']);
					$response .= "
							</td>
							<td>

                                <button 
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal' 
                                    data-target='#modal_detail_pemesanan'
                                    data-id='$data[0]'
                                    data-content='pemesanan_riwayat_proses'
                                    id='detail_pemesanan'
                                >
                                    Rincian
                                </button>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_pemesanan_riwayat_selesai':
			$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word = (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPemesananByKeyWord($key_word, 'selesai');
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='6'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[tanggal_pesan]</td>
							<td>$data[3]</td>
							<td>$data[tanggal_kerja]</td>
							<td>$data[9]</td>
							<td>";
					$response .= setBadges($data['status_pemesanan']);
					$response .= "
							</td>
							<td>
                                <button 
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal' 
                                    data-target='#modal_detail_pemesanan'
                                    data-id='$data[0]'
                                    data-content='pemesanan_riwayat_selesai'
                                    id='detail_pemesanan'
                                >
                                    Rincian
                                </button>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'search_pemesanan_riwayat_batal':
			$page 			= (isset($_POST['page'])) ? antiInjection($_POST['page']) : NULL ;
			$record_count 	= (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : NULL ;
			$key_word 		= (isset($_POST['key_word'])) ? antiInjection($_POST['key_word']) : NULL ;
			$result = searchPemesananByKeyWord($key_word, 'batal');
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					<tr>
						<td colspan='5'>
							<p align='center'>Hasil pencarian tidak ditemukan..!</p>
						</td>
					</tr>";
			} else {
				while ($data = mysqli_fetch_array($result, MYSQLI_BOTH)) {
					$response .= "
						<tr>
							<td>$data[tanggal_pesan]</td>
							<td>$data[3]</td>
							<td>$data[tanggal_kerja]</td>
							<td>";
					$response .= setBadges($data['status_pemesanan'], 'danger');
					$response .= "
							</td>
							<td>
                                <button 
                                    class='btn btn-dark btn-sm'
                                    data-toggle='modal' 
                                    data-target='#modal_detail_pemesanan'
                                    data-id='$data[0]'
                                    data-content='pemesanan_riwayat_batal'
                                    id='detail_pemesanan'
                                >
                                    Rincian
                                </button>
							</td>
						</tr>
					";
				}
			}
			break;
		case 'get_pemesanan':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = ($_SESSION['jenis_akun'] == 'admin') ? getPemesananSubJoinAllById($id, 'tunggu') : getPemesananSubJoinAllById($id, 'proses') ;
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$response .= "
						<tr>
							<td style='text-align:left;'>$data[tanggal_pesan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[12]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[nama_kategori_layanan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[tanggal_kerja]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$response .= ($data['longlat'] != NULL OR $data['longlat'] != "") ? $data['longlat'] : "Tidak ada Lokasi." ;
					$response .= "
							</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[keluhan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$response .= setBadges($data['status_pemesanan']);
					$response .= "
							</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_pemesanan_riwayat_proses':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPemesananSubJoinAllById($id, 'proses');
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$response .= "
						<tr>
							<td style='text-align:left;'>$data[tanggal_pesan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[12]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[nama_kategori_layanan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[tanggal_kerja]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[longlat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[keluhan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[21]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$response .= setBadges($data['status_pemesanan']);
					$response .= "
							</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_pemesanan_riwayat_selesai':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPemesananSubJoinAllById($id, 'selesai');
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$response .= "
						<tr>
							<td style='text-align:left;'>$data[tanggal_pesan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[12]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[nama_kategori_layanan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[tanggal_kerja]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[longlat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[keluhan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[21]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$response .= setBadges($data['status_pemesanan']);
					$response .= "
							</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_pemesanan_riwayat_batal':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPemesananSubJoinAllById($id, 'batal');
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$response .= "
						<tr>
							<td style='text-align:left;'>$data[tanggal_pesan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[12]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[nama_kategori_layanan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[tanggal_kerja]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[longlat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[keluhan]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$response .= setBadges($data['status_pemesanan']);
					$response .= "
							</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_data_pengguna_pelanggan':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPelangganById($id);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$response .= "
						<tr>
							<td style='text-align:left;'>$data[nama_lengkap]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[email]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[no_hp]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[alamat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[username]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$response .= setBadges($data['status_akun']);
					$response .= "
							</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[url_foto]</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_data_pengguna_teknisi':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getTeknisiById($id);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$response .= "
						<tr>
							<td style='text-align:left;'>$data[nama_lengkap]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[email]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[no_hp]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[alamat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[username]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$response .= setBadges($data['status_akun']);
					$response .= "
							</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[url_foto]</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_data_pengguna':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getPenggunaById($id);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$response .= "
						<tr>
							<td style='text-align:left;'>$data[nama_lengkap]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[email]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[no_hp]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[alamat]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[username]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[jenis_akun]</td>
						</tr>
						<tr>
							<td style='text-align:left;'>
					";
					$response .= setBadges($data['status_akun']);
					$response .= "
							</td>
						</tr>
						<tr>
							<td style='text-align:left;'>$data[url_foto]</td>
						</tr>
					";
				// }
			}
			break;
		case 'get_teknisi':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getTeknisiById($id);
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				// foreach ($result as $data) {
					$data = mysqli_fetch_array(
						$result, 
						MYSQLI_BOTH
					);
					$response .= "
						<form class='row'>
							<div class='col-md-9'>
								<div class='form-group row'>
									<label for='inputName' class='col-sm-3 col-form-label'>Name</label>
									<div class='col-sm-9'>
										<input type='email' class='form-control-plaintext' id='inputName' placeholder='Name' value='$data[nama_lengkap]' readonly>
									</div>
								</div>
								<div class='form-group row'>
									<label for='inputNoTelp' class='col-sm-3 col-form-label'>No. Telp</label>
									<div class='col-sm-9'>
										<input type='text' class='form-control-plaintext' id='inputNoTelp' placeholder='Nomor Telepon' value='$data[no_hp]' readonly>
									</div>
								</div>
								<div class='form-group row'>
									<label for='inputEmail' class='col-sm-3 col-form-label'>E-Mail</label>
									<div class='col-sm-9'>
										<input type='email' class='form-control-plaintext' id='inputEmail' placeholder='E-Mail' value='$data[email]' readonly>
									</div>
								</div>
								<div class='form-group row'>
									<label for='inputAlamat' class='col-sm-3 col-form-label'>Alamat</label>
									<div class='col-sm-9'>
										<input type='text' class='form-control-plaintext' id='inputAlamat' placeholder='Alamat' value='$data[alamat]' readonly>
									</div>
								</div>
								<div class='form-group row'>
									<label for='inputStatusAkun' class='col-sm-3 col-form-label'>Alamat</label>
									<div class='col-sm-9'>
					";
					$response .= setBadges($data['status_akun']);
					$response .= "
									</div>
								</div>
							</div>
							<div class='col-md-3'>
								<img class='content-image img-fluid img-thumbnail rounded' src='assets/img/teknisi/$data[url_foto]' id='image_gallery'>
							</div>
						</form>
					";
				// }
			}
			break;
		case 'get_bukti_pembayaran':
			$id = (isset($_POST['id'])) ? antiInjection($_POST['id']) : NULL ;
			$result = getBuktiPembayaranByIdPemesanan($id, '', 'ASC');
			if (mysqli_num_rows($result) < 1) {
				$response .= "
					Tidak ada data..!
				";
			} else {
				foreach ($result as $data) {
					$response .= "
						<div class='text-center'>
							<p class='text-dark text-capitalize'>
								Pembayaran $i - $data[info_pembayaran] <br>
							</p>
							<img class='img-thumbnail' src='";
					$response .= searchFile($data['bukti_pembayaran'], 'img', 'short');
					$response .= "' style='height: 300px;'>
						<div>
					";
				}
			}
			break;
		case 'set_status_pemesanan':
			$id 	= $_POST['id'];
			$status = $_POST['status_pemesanan'];
			$result = mysqli_query($koneksi, "
				UPDATE `data_pemesanan`
				SET `status_pemesanan` = '$status'
				WHERE `id_pemesanan` = '$id'
			");
			$responf = ($result) ? "success" : "error" ;
			break;
		case 'change_record_count':
			// $page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : 1 ;
			// $record_sum = (isset($_POST['record_count'])) ? antiInjection($_POST['record_count']) : 10 ;
			$record_sum = $_POST['record_count'];
			// class_static_value::$record_count = $record_sum;
			unset($_SESSION['record-count']);
			$_SESSION['record-count'] = $record_sum;
			$response = $_SESSION['record-count'];
			break;
		// case 'change_record_count_data_layanan_jenis_hardware':
		// 	$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : 1 ;
		// 	$record_sum = (isset($_GET['record_count'])) ? antiInjection($_GET['record_count']) : 10 ;
		// 	// class_static_value::$record_count = $record_sum;
		// 	$_SESSION['record-count'] = $record_sum;
		// 	$response .= $_SESSION['record-count'];
		// 	break;
		// case 'change_record_count_data_layanan_jenis_software':
		// 	$page = (isset($_POST['page'])) ? antiInjection($_POST['page']) : 1 ;
		// 	$record_sum = (isset($_GET['record_count'])) ? antiInjection($_GET['record_count']) : 10 ;
		// 	// class_static_value::$record_count = $record_sum;
		// 	$_SESSION['record-count'] = $record_sum;
		// 	$response .= $_SESSION['record-count'];
		// 	break;
		case 'select_pelanggan':
			// $pelangganAll = getPelangganAll('ASC');
			$pelangganAll = (isset($_POST['key_word']) AND (!empty($_POST['key_word']) OR $_POST['key_word'] != "")) ? mysqli_query($koneksi, "SELECT * FROM `data_pelanggan` WHERE `nama_lengkap` LIKE '%$_POST[key_word]%'") : getPelangganAll('ASC') ;
			$data = array(
				array(
					"id_pelanggan" => "all", // all
					"nama_lengkap" => "...Semua Pelanggan..."
				)
			);
			foreach ($pelangganAll as $pelanggan) {
				array_push($data, array_map("utf8_encode", $pelanggan));
			}
			$response = json_encode($data);
			// $response = $data;
			break;
		case 'modal_jenis_layanan':
			$filter = $_GET['data'];
			$i = 1;
			if ($filter == 'full') {
				$resultSoftware = getJenisSoftwareByIdKategori($_GET['id']);
				$resultHardware = getJenisHardwareByIdKategori($_GET['id']);
			} else {
				$result = getJKe($_GET['id']);
				$data = mysqli_fetch_array(
					$result,
					MYSQLI_BOTH
				);
			}
			if ($filter == "full") {
				$response .= "
					<tr>
						<td class='text-dark font-weight-bold' colspan='3'>Software</td>
					</tr>
				";
				foreach ($resultSoftware as $data) {
					$response .= "
						<tr>
					";
					$response .= "
						<td>
							$i
						</td>
					";
					$response .= "
						<td>
							$data[nama_jenis_layanan]
						</td>
						<td>
					";
					$response .= format($data['harga'], 'currency');
					$response .= "
						</td>
					";
					$response .= "
						</tr>
					";
					$i++;
				}
				$response .= "
						<tr>
							<td class='text-dark font-weight-bold' colspan='3'>Hardware</td>
						</tr>
					";
				foreach ($resultHardware as $data) {
					$response .= "
						<tr>
					";
					$response .= "
						<td>
							$i
						</td>
					";
					$response .= "
						<td>
							$data[nama_jenis_layanan]
						</td>
						<td>
					";
					$response .= format($data['harga'], 'currency');
					$response .= "
						</td>
					";
					$response .= "
						</tr>
					";
					$i++;
				}
			} elseif ($filter == "nama_barang") {
				$response = "$data[nama_barang]";
			} elseif ($filter == "harga") {
				$response = "$data[harga]";
			} elseif ($filter == "stok") {
				$response = "$data[stok]";
			} elseif ($filter == "url_foto") {
				$response = "$data[url_foto]";
			}
			break;
		case 'modal_pengerjaan_by_id_kategori':
			$id 			= $_POST['id_pemesanan_detail'];
			$id_pemesanan 	= $_POST['id_pemesanan'];
			$id_kategori 	= $_POST['id_kategori'];
			$softwareAll 	= getJenisSoftwareByIdKategori($id_kategori);
			$hardwareAll 	= getJenisHardwareByIdKategori($id_kategori);
			$sparepartAll 	= getSparepartAll();
			$detailPemesanan = mysqli_fetch_array(getDetailPemesananById($id), MYSQLI_BOTH);
			$response = "
				<!-- Software -->
				<div class='card-header border-right border-left border-top'>
					<h5 class='mb-0'>
						<button class='btn btn-link collapsed' type='button' data-toggle='collapse' data-target='#collapse_software' aria-expanded='true' aria-controls='collapse_software'>
							Jasa Pengerjaan Software
						</button>
					</h5>
				</div>
				<div class='card-body border-right border-left'>
					<div class='collapse show' aria-labelledby='collapse_software' data-parent='#accordion' id='collapse_software'>
			";
			foreach ($softwareAll as $data) {
				$response .= "
					<li>
						<label>
							<input type='checkbox' name='id_software' value='" . $data['id_layanan_jenis'] . "' class='hide' id='pengerjaan'
				";
				$response .= ($detailPemesanan['id_jenis_layanan_sparepart'] === $data['id_layanan_jenis'] AND $detailPemesanan['jenis_pengerjaan'] === 'software') ? 'checked' : '' ;
				$response .= "
							>
							<i class='bg-dark'></i>
							<span>
								" . $data['nama_jenis_layanan'] . " [<b>" . format($data['harga'], "currency") . "</b>]" . "
							</span>
						</label>
					</li>
				";
			}
			$response .= "
					</div>
				</div>
			";
			$response .= "
				<!-- hardware -->
				<div class='card-header border-right border-left border-top'>
					<h5 class='mb-0'>
						<button class='btn btn-link collapsed' type='button' data-toggle='collapse' data-target='#collapse_hardware' aria-expanded='false' aria-controls='collapse_hardware'>
							Jasa Pengerjaan Hardware
						</button>
					</h5>
				</div>
				<div class='card-body border-right border-left'>
					<div class='collapse show' aria-labelledby='collapse_hardware' data-parent='#accordion' id='collapse_hardware'>
			";
			foreach ($hardwareAll as $data) {
				$response .= "
					<li>
						<label>
							<input type='checkbox' name='id_hardware' value='" . $data['id_layanan_jenis'] . "' class='hide' id='pengerjaan'
				";
				$response .= ($detailPemesanan['id_jenis_layanan_sparepart'] === $data['id_layanan_jenis'] AND $detailPemesanan['jenis_pengerjaan'] === 'hardware') ? 'checked' : '' ;
				$response .= "
							>
							<i class='bg-dark'></i>
							<span>
								" . $data['nama_jenis_layanan'] . " [<b>" . format($data['harga'], "currency") . "</b>]" . "
							</span>
						</label>
					</li>
				";
			}
			$response .= "
					</div>
				</div>
			";
			$response .= "
				<!-- Sparepart -->
				<div class='card-header border-right border-left border-top'>
					<h5 class='mb-0'>
						<button class='btn btn-link collapsed' type='button' data-toggle='collapse' data-target='#collapse_sparepart' aria-expanded='false' aria-controls='collapse_sparepart'>
							Penggantian Sparepart
						</button>
					</h5>
				</div>
				<div class='card-body border-right border-left border-bottom'>
					<div class='collapse show' aria-labelledby='collapse_sparepart' data-parent='#accordion' id='collapse_sparepart'>
			";
			foreach ($sparepartAll as $data) {
				$response .= "
					<li>
						<label>
							<input type='checkbox' name='id_sparepart' value='" . $data['id_sparepart'] . "' class='hide' id='pengerjaan'
				";
				$response .= ($detailPemesanan['id_jenis_layanan_sparepart'] === $data['id_sparepart'] AND $detailPemesanan['jenis_pengerjaan'] === 'sparepart') ? 'checked' : '' ;
				$response .= "
							>
							<i class='bg-dark'></i>
							<span>
								" . $data['nama_sparepart'] . " [<b>" . format($data['harga'], "currency") . "</b>]" . "
							</span>
						</label>
					</li>
				";
			}
			$response .= "
					</div>
				</div>
			";
			break;
		case 'modal_processing_by_id_kategori':
			$id							= $_POST['id_pemesanan_detail'];
			$id_pemesanan				= $_POST['id_pemesanan'];
			$id_kategori				= $_POST['id_kategori'];
			$idJenisLayananSparepart	= $_POST['id_jenis_layanan_sparepart'];
			$jenisPengerjaan			= $_POST['jenis_pengerjaan'];
			$softwareAll				= getJenisSoftwareByIdKategori($id_kategori);
			$hardwareAll				= getJenisHardwareByIdKategori($id_kategori);
			$sparepartAll				= getSparepartAll();
			// $detailPemesanan 	= mysqli_fetch_array(getDetailPemesananById($id), MYSQLI_BOTH);
			$response = "
					<!-- Software -->
					<div class='card-header border-right border-left border-top'>
						<h5 class='mb-0'>
							<button class='btn btn-link collapsed' type='button' data-toggle='collapse' data-target='#collapse_software' aria-expanded='true' aria-controls='collapse_software'>
								Jasa Pengerjaan Software
							</button>
						</h5>
					</div>
					<div class='card-body border-right border-left'>
						<div class='collapse show' aria-labelledby='collapse_software' data-parent='#accordion' id='collapse_software'>
				";
			foreach ($softwareAll as $data) {
				$response .= "
						<li>
							<label>
								<input type='checkbox' name='id_software' value='" . $data['id_layanan_jenis'] . "' class='hide' id='pengerjaan'
					";
				$response .= ($idJenisLayananSparepart == $data['id_layanan_jenis'] AND $jenisPengerjaan == 'software') ? 'checked' : '';
				$response .= "
								>
								<i class='bg-dark'></i>
								<span>
									" . $data['nama_jenis_layanan'] . " [<b>" . format($data['harga'], "currency") . "</b>]" . "
								</span>
							</label>
						</li>
					";
			}
			$response .= "
						</div>
					</div>
				";
			$response .= "
					<!-- hardware -->
					<div class='card-header border-right border-left border-top'>
						<h5 class='mb-0'>
							<button class='btn btn-link collapsed' type='button' data-toggle='collapse' data-target='#collapse_hardware' aria-expanded='false' aria-controls='collapse_hardware'>
								Jasa Pengerjaan Hardware
							</button>
						</h5>
					</div>
					<div class='card-body border-right border-left'>
						<div class='collapse show' aria-labelledby='collapse_hardware' data-parent='#accordion' id='collapse_hardware'>
				";
			foreach ($hardwareAll as $data) {
				$response .= "
						<li>
							<label>
								<input type='checkbox' name='id_hardware' value='" . $data['id_layanan_jenis'] . "' class='hide' id='pengerjaan'
					";
				$response .= ($idJenisLayananSparepart == $data['id_layanan_jenis'] AND $jenisPengerjaan == 'hardware') ? 'checked' : '';
				$response .= "
								>
								<i class='bg-dark'></i>
								<span>
									" . $data['nama_jenis_layanan'] . " [<b>" . format($data['harga'], "currency") . "</b>]" . "
								</span>
							</label>
						</li>
					";
			}
			$response .= "
						</div>
					</div>
				";
			$response .= "
					<!-- Sparepart -->
					<div class='card-header border-right border-left border-top'>
						<h5 class='mb-0'>
							<button class='btn btn-link collapsed' type='button' data-toggle='collapse' data-target='#collapse_sparepart' aria-expanded='false' aria-controls='collapse_sparepart'>
								Penggantian Sparepart
							</button>
						</h5>
					</div>
					<div class='card-body border-right border-left border-bottom'>
						<div class='collapse show' aria-labelledby='collapse_sparepart' data-parent='#accordion' id='collapse_sparepart'>
				";
			foreach ($sparepartAll as $data) {
				$response .= "
						<li>
							<label>
								<input type='checkbox' name='id_sparepart' value='" . $data['id_sparepart'] . "' class='hide' id='pengerjaan'
					";
				$response .= ($idJenisLayananSparepart == $data['id_sparepart'] AND $jenisPengerjaan == 'sparepart') ? 'checked' : '';
				$response .= "
								>
								<i class='bg-dark'></i>
								<span>
									" . $data['nama_sparepart'] . " [<b>" . format($data['harga'], "currency") . "</b>]" . "
								</span>
							</label>
						</li>
					";
			}
			$response .= "
						</div>
					</div>
				";
			break;
		case 'get_data_biaya_tambahan':
			$data = mysqli_fetch_array(getBiayaTambahanById($_POST['id_biaya_tambahan']), MYSQLI_BOTH);
			$filter = $_POST['filter'];
			if ($filter == "id_biaya_tambahan") {
				$response = "$data[id_biaya_tambahan]";
			} elseif ($filter == "id_pemesanan") {
				$response = "$data[id_pemesanan]";
			} elseif ($filter == "keterangan") {
				$response = "$data[keterangan]";
			} elseif ($filter == "jumlah") {
				$response = "$data[jumlah]";
			}
			break;
		case 'get_data_additional_cost':
			$data = mysqli_fetch_array(getBiayaTambahanById($_POST['id_biaya_tambahan']), MYSQLI_BOTH);
			$filter = $_POST['filter'];
			if ($filter == "id_biaya_tambahan") {
				$response = "$data[id_biaya_tambahan]";
			} elseif ($filter == "id_pemesanan") {
				$response = "$data[id_pemesanan]";
			} elseif ($filter == "keterangan") {
				$response = "$data[keterangan]";
			} elseif ($filter == "jumlah") {
				$response = "$data[jumlah]";
			}
			break;
		case 'get_notifikasi':
			$type = (isset($_POST['type']) AND !empty($_POST['type'])) ? $_POST['type'] : "";
			$info = (isset($_POST['info']) AND !empty($_POST['info'])) ? $_POST['info'] : "";
			$tujuan = (isset($_POST['tujuan']) AND !empty($_POST['tujuan'])) ? $_POST['tujuan'] : "";
			$statusShow = (isset($_POST['status_show']) and !empty($_POST['status_show'])) ? $_POST['status_show'] : "";
			$statusBaca = (isset($_POST['status_baca']) and !empty($_POST['status_baca'])) ? $_POST['status_baca'] : "";
			$data = ($tujuan == 'administrator') ? getNotifikasiAdministratorAll($type, $info, $statusShow, $statusBaca) : getNotifikasiTeknisiByIdAll($type, $info, explode('_', $tujuan)[1], $statusShow, $statusBaca) ;
			$response = json_encode($data);
			break;
		case 'set_notifikasi':
			$idNotifikasi = (isset($_POST['id_notifikasi']) and !empty($_POST['id_notifikasi'])) ? $_POST['id_notifikasi'] : NULL ;
			$type = (isset($_POST['type']) and !empty($_POST['type'])) ? $_POST['type'] : "";
			$info = (isset($_POST['info']) and !empty($_POST['info'])) ? $_POST['info'] : "";
			$tujuan = (isset($_POST['tujuan']) and !empty($_POST['tujuan'])) ? $_POST['tujuan'] : "";
			$statusShow = (isset($_POST['status_show']) and !empty($_POST['status_show'])) ? $_POST['status_show'] : "";
			$statusBaca = (isset($_POST['status_baca']) and !empty($_POST['status_baca'])) ? $_POST['status_baca'] : "";
			$data = ($tujuan == 'administrator') ? setNotifikasiAdministratorAll($type, $info, $statusShow, $statusBaca) : setNotifikasiTeknisiByIdTeknisi($type, $info, explode('_', $tujuan)[1], $statusShow, $statusBaca) ;
			$response = json_encode($data);
			break;
		case 'set_show_notifikasi':
			$idNotifikasi = (isset($_POST['id_notifikasi']) and !empty($_POST['id_notifikasi'])) ? $_POST['id_notifikasi'] : NULL;
			$userType = (isset($_POST['user_type']) and !empty($_POST['user_type'])) ? $_POST['user_type'] : "";
			$data = ($userType == 'administrator') ? setShowNotifikasiAdministratorById($idNotifikasi) : setShowNotifikasiTeknisiById($idNotifikasi) ;
			$response = json_encode($data);
			break;
		case 'set_read_notifikasi':
			$idNotifikasi = (isset($_POST['id_notifikasi']) and !empty($_POST['id_notifikasi'])) ? $_POST['id_notifikasi'] : NULL ;
			$userType = (isset($_POST['user_type']) and !empty($_POST['user_type'])) ? $_POST['user_type'] : "";
			$data = ($userType == 'administrator') ? setReadNotifikasiAdministratorAll($idNotifikasi) : setReadNotifikasiTeknisiById($idNotifikasi) ;
			$response = json_encode($data);
			break;
		case NULL:
			$response = 'NULL';
			break;
		default:
			$response = "Respon untuk konten $content belum tersedia..!";
			break;
	}
?>

<?php echo $response; ?>