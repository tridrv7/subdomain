<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
require '../config/resize-class.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

//SELECT emp_id, emp_nip, emp_nm, emp_desk, emp_ent, emp_lhkpn, emp_img, jab_id, dept_id, parent, _active, _cre, _cre_date, _chg, _chg_date FROM pub_employees WHERE 1


	switch($_REQUEST['_act']){
		case 1:
				//count set_category
				$emp_id		= time();
				$emp_nip	= isset($_REQUEST['emp_nip']) ? strval($_REQUEST['emp_nip']) : '';
				$emp_nm 	= isset($_REQUEST['emp_nm']) ? strval($_REQUEST['emp_nm']) : '';
				$emp_desk 	= isset($_REQUEST['emp_desk']) ? strval($_REQUEST['emp_desk']) : '';
				$emp_ent 	= isset($_REQUEST['emp_ent']) ? strval($_REQUEST['emp_ent']) : '';
				$emp_lhkpn 	= isset($_REQUEST['emp_lhkpn']) ? strval($_REQUEST['emp_lhkpn']) : '';
				$emp_img 	= isset($_REQUEST['emp_img']) ? strval($_REQUEST['emp_img']) : '';
				$jab_id 	= isset($_REQUEST['jab_id']) ? strval($_REQUEST['jab_id']) : '';
				$dept_id 	= isset($_REQUEST['dept_id']) ? strval($_REQUEST['dept_id']) : '';
				$parent 	= isset($_REQUEST['parent']) ? strval($_REQUEST['parent']) : '';
					
			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				//foder upload
				$dirImg = '../'.$_dirEmp;

				//make directory
				if (!file_exists($dirImg) && !is_dir($dirImg)) {
					mkdir($dirImg, 0755, true);
				}
			
				if ($_FILES['emp_img']['name']) {
					$tempFile = explode(".", $_FILES["emp_img"]["name"]);
					$newFile = $emp_id.'.'.end($tempFile);
					
					//checking if file exsists
					if(file_exists($dirImg.$newFile)) {
						unlink($dirImg.$newFile);
					}
					
					chmod($dirImg, 0777);
					move_uploaded_file($_FILES["emp_img"]["tmp_name"], $dirImg.$newFile);
					// *** 1) Initialize / load image 
					$resizeObj = new resize($dirImg.$newFile);
					// *** 2) Resize image (options: exact, height, width, auto, crop) 
					$resizeObj -> resizeImage($resizeWEmp, $resizeHEmp, $resizeOEmp);
					// *** 3) Save image 
					$resizeObj -> saveImage($dirImg.$newFile, 100);
					chmod($dirImg, 0755);

					/*
					$resize = new ResizeImage($_FILES["emp_img"]["tmp_name"]);
					$resize->resizeTo(600, 800, 'maxWidth');
					$resize->saveImage($dirImg.$newFile);
					*/
					//watermark_image($dirImg.$newFile, '../img/watermark.png', $dirImg.$newFile);
					//move_uploaded_file($_FILES["ga_img"]["tmp_name"], $dirImg.$newFile);
					
					$emp_img = $newFile;
				} else {
					$emp_img = '';
				}
			
				//foder upload files
				$dirFiles = '../'.$_dirLHKPN;
			
				//lhkpn
				if (!file_exists($dirFiles) && !is_dir($dirFiles)) {
					mkdir($dirFiles, 0755, true);
				}
				if ($_FILES['emp_lhkpn']['name']) {
					$tempFile = explode(".", $_FILES["emp_lhkpn"]["name"]);
					$newFile = $emp_id.'.'.end($tempFile);
					
					if(file_exists($dirFiles.$newFile)) {
						unlink($dirFiles.$newFile);
					}
					
					chmod($dirImg, 0777);
					move_uploaded_file($_FILES["emp_lhkpn"]["tmp_name"], $dirFiles.$newFile);
					chmod($dirImg, 0755);
					$emp_lhkpn = $newFile;
				} else {
					$emp_lhkpn = '';
				}
			
				if($jab_id==='001'){
					updateField('_active=0', 'pub_employees', 'jab_id=001');
				}
			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO pub_employees(emp_id, emp_nip, emp_nm, emp_desk, emp_ent, emp_lhkpn, emp_img, jab_id, dept_id, parent, _active, _cre, _cre_date, _chg, _chg_date) 
				VALUES('$emp_id','$emp_nip','$emp_nm','$emp_desk','$emp_ent','$emp_lhkpn','$emp_img','$jab_id','$dept_id','$parent','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
										  or die('Ada kesalahan pada query insert : '.$mysqli->error);
				/*
				// cek query
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
			
				if (isset($_REQUEST['emp_id'])) {
					$emp_id = $_REQUEST['emp_id'];
					
					// ambil data hasil post dari ajax
					$emp_nip	= isset($_REQUEST['emp_nip']) ? strval($_REQUEST['emp_nip']) : '';
					$emp_nm 	= isset($_REQUEST['emp_nm']) ? strval($_REQUEST['emp_nm']) : '';
					$emp_desk 	= isset($_REQUEST['emp_desk']) ? strval($_REQUEST['emp_desk']) : '';
					$emp_ent 	= isset($_REQUEST['emp_ent']) ? strval($_REQUEST['emp_ent']) : '';
					$jab_id 	= isset($_REQUEST['jab_id']) ? strval($_REQUEST['jab_id']) : '';
					$dept_id 	= isset($_REQUEST['dept_id']) ? strval($_REQUEST['dept_id']) : '';
					$parent 	= isset($_REQUEST['parent']) ? strval($_REQUEST['parent']) : 'NULL';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					//foder upload
					$dirImg = '../'.$_dirEmp;

					//make directory
					if (!file_exists($dirImg) && !is_dir($dirImg)) {
						mkdir($dirImg, 0755, true);
					}

					if ($_FILES['emp_img']['name']) {
						$tempFile = explode(".", $_FILES["emp_img"]["name"]);
						$newFile = $emp_id.'.'.end($tempFile);

						//checking if file exsists
						if(file_exists($dirImg.$newFile)) {
							unlink($dirImg.$newFile);
						}
							
						chmod($dirImg, 0777);
						move_uploaded_file($_FILES["emp_img"]["tmp_name"], $dirImg.$newFile);
						// *** 1) Initialize / load image 
						$resizeObj = new resize($dirImg.$newFile);
						// *** 2) Resize image (options: exact, height, width, auto, crop) 
						$resizeObj -> resizeImage($resizeWEmp, $resizeHEmp, $resizeOEmp);
						// *** 3) Save image 
						$resizeObj -> saveImage($dirImg.$newFile, 100);

						/*
						$resize = new ResizeImage($_FILES["emp_img"]["tmp_name"]);
						$resize->resizeTo(600, 800, 'maxWidth');
						$resize->saveImage($dirImg.$newFile);
						*/
						//watermark_image($dirImg.$newFile, '../img/watermark.png', $dirImg.$newFile);

						chmod($dirImg, 0755);
						$emp_img = "emp_img='".$newFile."',";
					} else {
						$emp_img = '';
					}

					//foder upload files
					$dirFiles = '../'.$_dirLHKPN;

					//lhkpn
					if (!file_exists($dirFiles) && !is_dir($dirFiles)) {
						mkdir($dirFiles, 0755, true);
					}
					if ($_FILES['emp_lhkpn']['name']) {
						$tempFile = explode(".", $_FILES["emp_lhkpn"]["name"]);
						$newFile = $emp_id.'.'.end($tempFile);

						if(file_exists($dirFiles.$newFile)) {
							unlink($dirFiles.$newFile);
						}
						
						chmod($dirImg, 0777);
						move_uploaded_file($_FILES["emp_lhkpn"]["tmp_name"], $dirFiles.$newFile);
						chmod($dirImg, 0755);
						
                        $emp_lhkpn = "emp_lhkpn='".$newFile."',";
					} else {
						$emp_lhkpn = '';
					}
					
					if($jab_id==='001'){
						updateField('_active=0', 'pub_employees', 'jab_id=001');
					}
					
					// perintah query untuk mengubah data pada tabel transaksi 
					$update = $mysqli->query("UPDATE pub_employees SET emp_nip='$emp_nip', 
																		emp_nm='$emp_nm', 
																		emp_desk='$emp_desk', 
																		emp_ent='$emp_ent', 
																		jab_id='$jab_id', 
																		dept_id='$dept_id', 
																		parent='$parent',
																		$emp_img $emp_lhkpn
																		_chg='$_chg', 
																		_active=1,
																		_chg_date=SYSDATE()
													WHERE emp_id='$emp_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					/*
					// cek query
					if (update) {
						// jika berhasil tampilkan pesan berhasil simpan data
						echo "sukses";
					} else {
						// jika gagal tampilkan pesan gagal simpan data
						echo "gagal";
					}
					*/
					echo $mysqli->error;
				}
				// tutup koneksi
				$mysqli->close();   			
			
			
			break;
		case 3:
			
				if (isset($_REQUEST['emp_id'])) {
					// ambil data hasil post dari ajax
					$emp_id = $_REQUEST['emp_id'];

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_employees SET _active='0',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE emp_id='$emp_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					/*
					// cek query
					if (update) {
						// jika berhasil tampilkan pesan berhasil simpan data
						echo "sukses";
					} else {
						// jika gagal tampilkan pesan gagal simpan data
						echo "gagal";
					}
					*/
					echo $mysqli->error;
				}
				// tutup koneksi
				$mysqli->close();   			
			
			break;
		case 4:
			
				if (isset($_REQUEST['emp_id'])) {
					// ambil data get dari ajax
					$emp_id = htmlentities($_REQUEST['emp_id']);
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT emp_id, emp_nip, emp_nm, emp_desk, emp_ent, emp_lhkpn, emp_img, jab_id, dept_id, parent
													FROM pub_employees
												WHERE _active=1 AND emp_id='$emp_id'")
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
			
				//SELECT emp_id, emp_nip, emp_nm, emp_desk, emp_ent, emp_lhkpn, emp_img, jab_id, dept_id, parent, _active, _cre, _cre_date, _chg, _chg_date FROM pub_employees WHERE 1
			
				// nama table
				$table = 'pub_employees';
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
				$primaryKey = 'emp_id';

				$columns = array(
					array( 'db' => 'emp_id', 'dt' => 0 ),
					array( 'db' => 'emp_nm', 'dt' => 1 ),
					array( 
                        'db' => 'emp_ent', 
                        'dt' => 2,
						/*
						'formatter' => function( $d, $row ) {
							return loadRecText('jab_nm','set_jabdept','jab_id="'.$d.'"');
						}
						*/
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