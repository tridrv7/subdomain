<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

$jns_id = $_REQUEST['jns_id'];
	
			
	//SELECT atr_id, atr_no, atr_thn, atr_desk, atr_opd, atr_status, atr_x, jns_id, atr_file, atr_na, atr_penetapan, atr_pengundangan, atr_see, atr_down, _active, _cre, _cre_date, _chg, _chg_date FROM p_aturan WHERE _active=1	
	
	switch($_REQUEST['_actionFmPeraturan']){
		case 1:

			$jns_pendek = $_REQUEST['jns_pendek'];

			$atr_no_1 = isset($_REQUEST['atr_no']) ? strval($_REQUEST['atr_no']) : '';
				$atr_no = str_pad($atr_no_1, 3, "0", STR_PAD_LEFT);
			$atr_thn = isset($_REQUEST['atr_thn']) ? strval($_REQUEST['atr_thn']) : '';
			
			$atr_desk = isset($_REQUEST['atr_desk']) ? strval($_REQUEST['atr_desk']) : '';
			$atr_opd = isset($_REQUEST['atr_opd']) ? strval($_REQUEST['atr_opd']) : '';
				$_nameOPD = loadRecText("opd_pendek", "m_perangkat", "opd_id=$atr_opd");
			$atr_status = isset($_REQUEST['atr_status']) ? strval($_REQUEST['atr_status']) : ''; //kode pengganti peraturan
			$atr_x = isset($_REQUEST['atr_x']) ? strval($_REQUEST['atr_x']) : ''; //link ke aturan pengganti
			//$jns_id = isset($_REQUEST['jns_id']) ? strval($_REQUEST['jns_id']) : '';
			$atr_penetapan = isset($_REQUEST['atr_penetapan']) ? strval($_REQUEST['atr_penetapan']) : '';
			$atr_pengundangan = isset($_REQUEST['atr_pengundangan']) ? strval($_REQUEST['atr_pengundangan']) : '';
			$atr_see = isset($_REQUEST['atr_see']) ? strval($_REQUEST['atr_see']) : '0';
			$atr_down = isset($_REQUEST['atr_down']) ? strval($_REQUEST['atr_down']) : '0';

			$atr_desk = ucwords($atr_desk);

			$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '3';
			$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
			$_chg = $_cre;

			// fungsi untuk membuat id transaksi
			$result = $mysqli->query("SELECT count(*) AS countRow
									FROM p_aturan 
									WHERE atr_thn='$atr_thn' AND jns_id='$jns_id'")
								or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
			//$rows = $result->num_rows;
			$resultMPeraturan = $result->fetch_assoc();

			
			/*
			$queryMPeraturan = $mysqli->query("SELECT jns_id, jns_pendek FROM m_aturan WHERE jns_id='$jns_id'")
								or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
			$resultMPeraturan = $queryMPeraturan->num_rows;
			*/

			//$rows = $result->fetch_assoc;
			$atr_id = $atr_thn.$jns_id.str_pad($resultMPeraturan['countRow']+1, 5, "0", STR_PAD_LEFT);
			
			//foder upload
			$dirFileAbstrak = "../../fileAbstrak/".$jns_pendek."/".$atr_thn."/";
			$dirFilePeraturan = "../../filePeraturan/".$jns_pendek."/".$atr_thn."/";
			$dirFileNA = "../../fileNA/".$jns_pendek."/".$atr_thn."/";
			
			//make directory
			if (!file_exists($dirFileAbstrak) && !is_dir($dirFileAbstrak)) {
				mkdir($dirFileAbstrak, 0777, true);
			}
			if (!file_exists($dirFilePeraturan) && !is_dir($dirFilePeraturan)) {
				mkdir($dirFilePeraturan, 0777, true);
			}
			if (!file_exists($dirFileNA) && !is_dir($dirFileNA)) {
				mkdir($dirFileNA, 0777, true);
			}
			
			//variable upload
			//$atr_file = isset($_REQUEST['atr_file']) ? strval($_REQUEST['atr_file']) : '';
			//$atr_na = isset($_REQUEST['atr_na']) ? strval($_REQUEST['atr_na']) : '';
			if (!empty($_FILES['atr_abs']['name'])) {
				$tempFile = explode(".", $_FILES["atr_abs"]["name"]);
				$newFile = $jns_pendek.'_'.$_nameOPD.'_'.$atr_no.'_'.$atr_thn.'.'. end($tempFile);
				move_uploaded_file($_FILES["atr_abs"]["tmp_name"], $dirFileAbstrak.$newFile);	
				
				$atr_abs = substr($dirFileAbstrak,6).$newFile;
			}

			if (!empty($_FILES['atr_file']['name'])) {
				$tempFile = explode(".", $_FILES["atr_file"]["name"]);
				$newFile = $jns_pendek.'_'.$_nameOPD.'_'.$atr_no.'_'.$atr_thn.'.'. end($tempFile);
				move_uploaded_file($_FILES["atr_file"]["tmp_name"], $dirFilePeraturan.$newFile);	
				
				$atr_file = substr($dirFilePeraturan,6).$newFile;
			}

			if (!empty($_FILES['atr_na']['name'])) {
				$tempNA = explode(".", $_FILES["atr_na"]["name"]);
				$newNA = 'NA_'.$jns_pendek.'_'.$_nameOPD.'_'.$atr_no.'_'.$atr_thn.'.'. end($tempNA);
				move_uploaded_file($_FILES["atr_na"]["tmp_name"], $dirFileNA.$newNA);

				$atr_na = substr($dirFileNA,6).$newNA;
			} 
			
            //mengubah aturan terkait
            if($atr_status!==''){
                switch($atr_status){
                    case 1:
                        $atr_statusx = '2';
                        break;
                    case 2:
                        $atr_statusx = '1';
                        break;
                    case 3:
                        $atr_statusx = '4';
                        break;
                    case 4:
                        $atr_statusx = '3';
                        break;
                }
                $jns_idx = substr($atr_x,4,3);
                
                $updatex = $mysqli->query("UPDATE p_aturan SET atr_status='$atr_statusx', 
                                                                atr_x='$atr_id',
                                                                _chg='$_chg', 
                                                                _chg_date=SYSDATE() 
														WHERE atr_id='$atr_x' AND jns_id='$jns_idx'")
                                          or die('Ada kesalahan pada query insert : '.$mysqli->error); 
            }
            
            
            // perintah query untuk menyimpan data ke tabel transaksi
			$insert = $mysqli->query("INSERT INTO p_aturan(atr_id, jns_id, atr_no, atr_thn, atr_desk, atr_opd, atr_status, atr_x, atr_file, atr_na, atr_penetapan, atr_pengundangan, atr_see, atr_down, _active, _cre, _cre_date, _chg, _chg_date, atr_abs) 
							VALUES('$atr_id', '$jns_id', '$atr_no', '$atr_thn', '$atr_desk', '$atr_opd', '$atr_status', '$atr_x', '$atr_file', '$atr_na', '$atr_penetapan', '$atr_pengundangan', '$atr_see', '$atr_down', '$_active', '$_cre', SYSDATE(), '$_chg', SYSDATE(), '$atr_abs')")
									  or die('Ada kesalahan pada query insert : '.$mysqli->error); 
			// cek query
			if ($insert) {
				// jika berhasil tampilkan pesan berhasil simpan data
				echo "sukses";
			} else {
				// jika gagal tampilkan pesan gagal simpan data
				echo "gagal";
			}
			// tutup koneksi
			$mysqli->close();   

			break;
		case 2:
			
				if (isset($_REQUEST['atr_id'])) {
					// ambil data hasil post dari ajax
					$atr_id = isset($_REQUEST['atr_id']) ? strval($_REQUEST['atr_id']) : '';
					$jns_pendek = $_REQUEST['jns_pendek'];

					$atr_no_1 = isset($_REQUEST['atr_no']) ? strval($_REQUEST['atr_no']) : '';
						$atr_no = str_pad($atr_no_1, 3, "0", STR_PAD_LEFT);
					$atr_thn = isset($_REQUEST['atr_thn']) ? strval($_REQUEST['atr_thn']) : '';

					$atr_desk = isset($_REQUEST['atr_desk']) ? strval($_REQUEST['atr_desk']) : '';
						$atr_desk = ucwords($atr_desk);
					$atr_opd = isset($_REQUEST['atr_opd']) ? strval($_REQUEST['atr_opd']) : '';
						$_nameOPD = loadRecText("opd_pendek", "m_perangkat", "opd_id=$atr_opd");
					$atr_status = isset($_REQUEST['atr_status']) ? strval($_REQUEST['atr_status']) : ''; //kode pengganti peraturan
					$atr_x = isset($_REQUEST['atr_x']) ? strval($_REQUEST['atr_x']) : ''; //link ke aturan pengganti
					//$jns_id = isset($_REQUEST['jns_id']) ? strval($_REQUEST['jns_id']) : '';
					$atr_penetapan = isset($_REQUEST['atr_penetapan']) ? strval($_REQUEST['atr_penetapan']) : '';
					$atr_pengundangan = isset($_REQUEST['atr_pengundangan']) ? strval($_REQUEST['atr_pengundangan']) : '';
					$atr_see = isset($_REQUEST['atr_see']) ? strval($_REQUEST['atr_see']) : '';
					$atr_down = isset($_REQUEST['atr_down']) ? strval($_REQUEST['atr_down']) : '';


					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '3';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;


					//foder upload
					$dirFileAbstrak = "../../fileAbstrak/".$jns_pendek."/".$atr_thn."/";
					$dirFilePeraturan = "../../filePeraturan/".$jns_pendek."/".$atr_thn."/";
					$dirFileNA = "../../fileNA/".$jns_pendek."/".$atr_thn."/";

					//make directory
					if (!file_exists($dirFileAbstrak) && !is_dir($dirFileAbstrak)) {
						mkdir($dirFileAbstrak, 0777, true);
					}
					if (!file_exists($dirFilePeraturan) && !is_dir($dirFilePeraturan)) {
						mkdir($dirFilePeraturan, 0777, true);
					}
					if (!file_exists($dirFileNA) && !is_dir($dirFileNA)) {
						mkdir($dirFileNA, 0777, true);
					}

					//variable upload
					//$atr_file = isset($_REQUEST['atr_file']) ? strval($_REQUEST['atr_file']) : '';
					//$atr_na = isset($_REQUEST['atr_na']) ? strval($_REQUEST['atr_na']) : '';
					if (!empty($_FILES['atr_abs']['name'])) {
						$tempFile = explode(".", $_FILES["atr_abs"]["name"]);
						$newFile = $jns_pendek.'_'.$_nameOPD.'_'.$atr_no.'_'.$atr_thn.'.'. end($tempFile);
						move_uploaded_file($_FILES["atr_abs"]["tmp_name"], $dirFileAbstrak.$newFile);	

						$atr_abs = substr($dirFileAbstrak,6).$newFile;
					}
					
					if (!empty($_FILES['atr_file']['name'])) {
						$tempFile = explode(".", $_FILES["atr_file"]["name"]);
						$newFile = $jns_pendek.'_'.$_nameOPD.'_'.$atr_no.'_'.$atr_thn.'.'. end($tempFile);
						move_uploaded_file($_FILES["atr_file"]["tmp_name"], $dirFilePeraturan.$newFile);	
					}

					if (!empty($_FILES['atr_na']['name'])) {
						$tempNA = explode(".", $_FILES["atr_na"]["name"]);
						$newNA = 'NA_'.$jns_pendek.'_'.$_nameOPD.'_'.$atr_no.'_'.$atr_thn.'.'. end($tempNA);
						move_uploaded_file($_FILES["atr_na"]["tmp_name"], $dirFileNA.$newNA);
					}
			
                    //mengubah aturan terkait
                    if($atr_status!==''){
                        switch($atr_status){
                            case 1:
                                $atr_statusx = '2';
                                break;
                            case 2:
                                $atr_statusx = '1';
                                break;
                            case 3:
                                $atr_statusx = '4';
                                break;
                            case 4:
                                $atr_statusx = '3';
                                break;
                        }
                        $jns_idx = substr($atr_x,4,3);

                        $updatex = $mysqli->query("UPDATE p_aturan SET atr_status='$atr_statusx', 
                                                                        atr_x='$atr_id',
                                                                        _chg='$_chg', 
                                                                        _chg_date=SYSDATE() 
                                                                WHERE atr_id='$atr_x' AND jns_id='$jns_idx'")
                                                  or die('Ada kesalahan pada query insert : '.$mysqli->error); 
                    }

                    // perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE p_aturan SET atr_no='$atr_no', 
																  atr_thn='$atr_thn', 
																  atr_desk='$atr_desk', 
																  atr_opd='$atr_opd', 
																  atr_status='$atr_status', 
																  atr_x='$atr_x', 
																  atr_penetapan='$atr_penetapan', 
																  atr_pengundangan='$atr_pengundangan', 
                                                                  _active='$_active', 
																  _chg='$_chg', 
																  _chg_date=SYSDATE() 
														WHERE atr_id='$atr_id' AND jns_id='$jns_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					// cek query
					if ($update) {
						// jika berhasil tampilkan pesan berhasil ubah data
						echo "sukses";
					} else {
						// jika gagal tampilkan pesan gagal ubah data
						echo "gagal";
					}
				}
				// tutup koneksi
				$mysqli->close();   			
			
			
			break;
		case 3:
			
				if (isset($_REQUEST['atr_id'])) {
					// ambil data hasil post dari ajax
					$atr_id     = isset($_REQUEST['atr_id']) ? strval($_REQUEST['atr_id']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : '555';
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE p_aturan SET _active='$_active', _chg='$_chg', _chg_date=SYSDATE()
										WHERE atr_id='$atr_id' AND jns_id='$jns_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					// cek query
					if ($update) {
						// jika berhasil tampilkan pesan berhasil ubah data
						echo "sukses";
					} else {
						// jika gagal tampilkan pesan gagal ubah data
						echo "gagal";
					}
				}
				// tutup koneksi
				$mysqli->close();   			
			
			break;
		case 4:
			
				if (isset($_REQUEST['atr_id'])) {
					// ambil data get dari ajax
					$atr_id = $_REQUEST['atr_id'];
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT a.atr_id, a.atr_no, a.atr_thn, a.atr_desk, a.atr_opd, a.atr_status, a.atr_x, a.jns_id, a.atr_file, a.atr_na, a.atr_penetapan, a.atr_pengundangan, a._active,
													b.opd_id, b.opd_pendek, b.opd_panjang, 
													c.jns_pendek, c.jns_panjang 
														FROM p_aturan a 
															LEFT JOIN m_perangkat b ON a.atr_opd=b.opd_id 
															LEFT JOIN m_aturan c ON a.jns_id=c.jns_id 
														WHERE a.atr_id=$atr_id")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
					$data = $result->fetch_assoc();
				}
				// tutup koneksi
				$mysqli->close(); 

				echo json_encode($data); 			
			
			break;
		case 6:
			
				if (isset($_REQUEST['atr_id'])) {
					// ambil data get dari ajax
					$atr_id = $_REQUEST['atr_id'];
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT a.atr_id, a.atr_no, a.atr_thn, a.atr_desk, a.atr_opd, a.atr_status, a.atr_x, a.jns_id, a.atr_abs, a.atr_file, a.atr_na, a.atr_penetapan, a.atr_pengundangan, a._active, CONCAT(c.jns_panjang,' Nomor ', a.atr_no, ' Tahun ', a.atr_thn) AS aturan, 
													b.opd_id, b.opd_pendek, b.opd_panjang, 
													c.jns_pendek, c.jns_panjang 
														FROM p_aturan a 
															LEFT JOIN m_perangkat b ON a.atr_opd=b.opd_id 
															LEFT JOIN m_aturan c ON a.jns_id=c.jns_id 
														WHERE a.atr_id=$atr_id")
											  or die('Ada kesalahan pada query 1 tampil data transaksi: '.$mysqli->error);
					$data = $result->fetch_assoc();
                    
                    if($data['atr_x']!=""){
                        /*start deskripsi aturan pengganti*/
                        $result2 = $mysqli->query("SELECT CONCAT(c.jns_panjang,' Nomor ', a.atr_no, ' Tahun ', a.atr_thn) AS desk
                                                            FROM p_aturan a 
                                                                LEFT JOIN m_aturan c ON a.jns_id=c.jns_id 
                                                            WHERE a.atr_id=$data[atr_x]")
                                                  or die('Ada kesalahan pada query 2 tampil data transaksi: '.$mysqli->error);
                        $row = $result2->fetch_assoc();
                        $data['desk_aturanx'] = $row['desk'];
                        /*end deskripsi aturan pengganti*/
                    } else {
                        $data['desk_aturanx'] = "";
                    }
				}
				// tutup koneksi
				$mysqli->close(); 

				echo json_encode($data);
			
			break;
		case 5:
			
				//SELECT atr_id, atr_no, atr_thn, atr_desk, atr_opd, atr_status, atr_x, jns_id, atr_file, atr_na, atr_penetapan, atr_pengundangan, atr_see, atr_down, _active, _cre, _cre_date, _chg, _chg_date FROM p_aturan WHERE _active=1
				// nama table
				$table = 'p_aturan';
				// Table's primary key
				$primaryKey = 'atr_id';

				$columns = array(
					array( 'db' => 'atr_id', 'dt' => 1 ),
					array( 'db' => 'atr_no', 'dt' => 2 ),
					array( 'db' => 'atr_thn', 'dt' => 3 ),
					array( 'db' => 'atr_desk', 'dt' => 4 ),
					array( 
						'db' => '_active', 
						'dt' => 5,
					),
                    
					/*
					array(
						'db' => 'tanggal',
						'dt' => 2,
						'formatter' => function( $d, $row ) {
							return date('d-m-Y', strtotime($d));
						}
					),
					array( 'db' => 'nama_barang', 'dt' => 3 ),
					array(
						'db'        => 'harga_barang',
						'dt'        => 4,
						'formatter' => function( $d, $row ) {
							return 'Rp. '.number_format($d);
						}
					),
					array(
						'db'        => 'jumlah_beli',
						'dt'        => 5,
						'formatter' => function( $d, $row ) {
							return number_format($d);
						}
					),
					array(
						'db'        => 'total_bayar',
						'dt'        => 6,
						'formatter' => function( $d, $row ) {
							return 'Rp. '.number_format($d);
						}
					),
					*/
					array( 'db' => 'atr_id', 'dt' => 6 ),
				);
				
				$where ="_active!=0 AND jns_id='$jns_id'";

				// ssp class
				require '../config/ssp.class.php';

				echo json_encode(
					//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
					SSP::complex( $_GET, $con, $table, $primaryKey, $columns, null, $where )
				);
			
			break;
	}
} else {
    echo '<script>window.location="../index.php"</script>';
}
?>