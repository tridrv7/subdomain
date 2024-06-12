<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

//SELECT ca_id, ca_nm, ca_desk, ca_icon, fm_id, _active, _cre, _cre_date, _chg, _chg_date FROM set_category WHERE 1

	switch($_REQUEST['_act']){
		case 1:
				//count set_category
				$result = $mysqli->query("SELECT ca_id FROM set_category")
									or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
				$rows = $result->num_rows;
			
				$ca_id		= str_pad($rows+1, 3, "0", STR_PAD_LEFT);
				$ca_nm		= isset($_REQUEST['ca_nm']) ? ucwords(strval($_REQUEST['ca_nm'])) : '';
				$ca_desk	= isset($_REQUEST['ca_desk']) ? strval($_REQUEST['ca_desk']) : '';
				$ca_icon	= isset($_REQUEST['ca_icon']) ? strval($_REQUEST['ca_icon']) : '';
				$fm_id		= isset($_REQUEST['fm_id']) ? strval($_REQUEST['fm_id']) : '';
			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				//foder upload
				$dirImg = '../'.$_dirKategori;

				//make directory
				if (!file_exists($dirImg) && !is_dir($dirImg)) {
					mkdir($dirImg, 0777, true);
				}
				if (isset($_FILES['ca_icon']['name'])) {
					$tempFile = explode(".", $_FILES["ca_icon"]["name"]);
					$newFile = $ca_id.'.'.end($tempFile);
					
					//checking if file exsists
					if(file_exists($dirImg.$newFile)) {
						unlink($dirImg.$newFile);
					} else {
						move_uploaded_file($_FILES["ca_icon"]["tmp_name"], $dirImg.$newFile);
					}

					$ca_icon = $newFile;
				} else {
					$ca_icon = '';
				}
			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO set_category(ca_id, ca_nm, ca_desk, ca_icon, fm_id, _active, _cre, _cre_date, _chg, _chg_date) 
											VALUES('$ca_id','$ca_nm','$ca_desk','$ca_icon','$fm_id','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
										  or die('Ada kesalahan pada query insert : '.$mysqli->error);
			
				// perintah query untuk menyimpan data ke tabel set_page
				$page_id	= str_pad(loadRecText('count(page_id)', 'set_page', '1')+1, 3, '0', STR_PAD_LEFT);
				$page_name	= 'Publikasi Data '.$ca_nm;
				$page_addr	= 'Publikasi_Data_'.str_replace(" ","-","$ca_nm");
			
				$insPage = $mysqli->query("INSERT INTO set_page(page_id, page_name, page_addr, _active, _cre, _cre_date, _chg, _chg_date) 
									VALUES('$page_id','$page_name','$page_addr','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
										  or die('Ada kesalahan pada query insert : '.$mysqli->error); 
			
				// cek query
				/*
				if ($insert) {
					// jika berhasil tampilkan pesan berhasil simpan data
					echo "sukses";
				} else {
					// jika gagal tampilkan pesan gagal simpan data
					echo "gagal";
				}
				*/
				echo $mysqli->error;
			
				// tutup koneksi
				$mysqli->close();   
			
			break;
		case 2:
			
				if (isset($_REQUEST['ca_id'])) {
					$ca_id = $_REQUEST['ca_id'];
					
					// ambil data hasil post dari ajax
					$ca_nm	= isset($_REQUEST['ca_nm']) ? ucwords(strval($_REQUEST['ca_nm'])) : '';
					$ca_desk	= isset($_REQUEST['ca_desk']) ? strval($_REQUEST['ca_desk']) : '';
					$ca_icon	= isset($_REQUEST['ca_icon']) ? strval($_REQUEST['ca_icon']) : '';
					$fm_id	= isset($_REQUEST['fm_id']) ? strval($_REQUEST['fm_id']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					//foder upload
					$dirImg = '../'.$_dirKategori;

					//make directory
					if (!file_exists($dirImg) && !is_dir($dirImg)) {
						mkdir($dirImg, 0777, true);
					}
					if (!empty($_FILES['ca_icon']['name'])) {
						$tempFile = explode(".", $_FILES["ca_icon"]["name"]);
						$newFile = $ca_id.'.'.end($tempFile);

						//checking if file exsists
						if(file_exists($dirImg.$newFile)) {
							unlink($dirImg.$newFile);
						}
						
						move_uploaded_file($_FILES["ca_icon"]["tmp_name"], $dirImg.$newFile);
												
                        //chmod($dirImg, 0755);
                        $ca_icon = "ca_icon='".$newFile."',";
					} else {
						$ca_icon = '';
					}
					
					// perintah query untuk menyimpan data ke tabel set_page
					$upPageWhere = 'Publikasi Data '.loadRecText('ca_nm', 'set_category', 'ca_id='.$ca_id);
					$page_name	= 'Publikasi Data '.$ca_nm;
					$page_addr	= 'Publikasi_Data_'.str_replace(" ","-","$ca_nm");
					$upPage = $mysqli->query("UPDATE set_page SET page_name='$page_name', page_addr='$page_addr', _chg='$_chg', _chg_date=SYSDATE()
										WHERE page_name='$upPageWhere'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					
					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_category SET ca_nm='$ca_nm', 
																		ca_desk='$ca_desk', 
																		$ca_icon
																		fm_id='$fm_id', 
																		_chg='$_chg', 
																		_chg_date=SYSDATE()
													WHERE ca_id='$ca_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					// cek query
					/*
					if ($update) {
						// jika berhasil tampilkan pesan berhasil ubah data
						echo "sukses";
					} else {
						// jika gagal tampilkan pesan gagal ubah data
						echo "gagal";
					}
					*/
					echo $mysqli->error;
				}
			
				// tutup koneksi
				$mysqli->close();   			
			
			
			break;
		case 3:
			
				if (isset($_REQUEST['ca_id'])) {
					// ambil data hasil post dari ajax
					$ca_id = $_REQUEST['ca_id'];

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_category SET _active='0',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE ca_id='$ca_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					
					// perintah query untuk menyimpan data ke tabel set_page
					$upPageWhere = 'Publikasi Data '.loadRecText('ca_nm', 'set_category', 'ca_id='.$ca_id);
					$upPage = $mysqli->query("UPDATE set_page SET _active='0', _chg='$_chg', _chg_date=SYSDATE()
										WHERE page_name='$upPageWhere'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					
					// cek query
					/*
					if ($update) {
						// jika berhasil tampilkan pesan berhasil ubah data
						echo "sukses";
					} else {
						// jika gagal tampilkan pesan gagal ubah data
						echo "gagal";
					}
					*/
					echo $mysqli->error;
				}
			
				// tutup koneksi
				$mysqli->close();   			
			
			break;
		case 4:
			
				if (isset($_REQUEST['ca_id'])) {
					// ambil data get dari ajax
					$ca_id = htmlentities($_REQUEST['ca_id']);
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT ca_id, ca_nm, ca_desk, ca_icon, fm_id
													FROM set_category
												WHERE _active=1 AND ca_id='$ca_id'")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
					if($result->num_rows!=0){
						$data = $result->fetch_assoc();
						
						echo json_encode($data);
					} else {
						echo json_encode(array('stats'=>404,'msgErrors'=>'Data tidak ditemukan'));
					}
				}
				// tutup koneksi
				$mysqli->close();
			
			break;
		case 5:
			
				//SELECT ca_id, ca_nm, ca_icon, fm_id, _active, _cre, _cre_date, _chg, _chg_date FROM set_category;
				// nama table
				$table = 'set_category';
				/*
				$table = <<<EOT
							(
								SELECT 
									a.ca_id, a.ca_nm, a.ca_icon, a.fm_id, a._active, b.fm_name
								FROM set_category a
									LEFT JOIN mast_form b ON a.fm_id = b.fm_id
							)
						EOT;
				*/
				// Table's primary key
				$primaryKey = 'ca_id';

				$columns = array(
					array( 'db' => 'ca_id', 'dt' => 0 ),
					array( 'db' => 'ca_nm', 'dt' => 1 ),
					array( 
                        'db' => 'fm_id', 
                        'dt' => 2,
						'formatter' => function( $d, $row ) {
							return loadRecText('fm_name','set_form','fm_id="'.$d.'"');
						}
                        //loadRecText('ro_name','set_role',$row)
                    ),
					array( 'db' => '_active', 'dt' => 3 ),
				);
				
				$where ='_active=1';

				// ssp class
				require '../config/ssp.class.php';

				echo json_encode(
					//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
					SSP::complex( $_GET, $con, $table, $primaryKey, $columns, null, $where )
				);
			
			break;
	}

} else {
    echo '<script>window.location="'.$servLogs.'"</script>';
}
?>