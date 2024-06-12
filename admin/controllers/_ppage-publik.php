<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
require '../config/resize-class.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {
	
//SELECT post_id, post_judul, post_desk, post_publish, post_datex, post_img, post_see, ca_id, _active, _cre, _cre_date, _chg, _chg_date FROM pub_post
	
	switch($_REQUEST['_act']){
		case 1:
			
				$post_id		= time();
				$post_judul		= isset($_REQUEST['post_judul']) ? strval($_REQUEST['post_judul']) : '';
				$post_desk		= isset($_REQUEST['post_desk']) ? strval($_REQUEST['post_desk']) : '';
				$post_publish	= isset($_REQUEST['post_publish']) ? strval($_REQUEST['post_publish']) : '';
				$post_img		= isset($_REQUEST['post_img']) ? strval($_REQUEST['post_img']) : '';
				$post_see		= isset($_REQUEST['post_see']) ? strval($_REQUEST['post_see']) : '0';
				$ka_id = str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				//foder upload
				$dirImg = '../'.$_dirPost;

				//make directory
				if (!file_exists($dirImg) && !is_dir($dirImg)) {
					mkdir($dirImg, 0755, true);
				}
			
				if ($_FILES['post_img']['name']) {
					$tempFile = explode(".", $_FILES["post_img"]["name"]);
					$newFile = $post_id.'.'.end($tempFile);
					
					//checking if file exsists
					if(file_exists($dirImg.$newFile)) {
						unlink($dirImg.$newFile);
					}
					
					chmod($dirImg, 0777);
					move_uploaded_file($_FILES["post_img"]["tmp_name"], $dirImg.$newFile);
					// *** 1) Initialize / load image 
					$resizeObj = new resize($dirImg.$newFile);
					// *** 2) Resize image (options: exact, height, width, auto, crop) 
					$resizeObj -> resizeImage($resizeWPost, $resizeHPost, $resizeOPost);
					// *** 3) Save image 
					$resizeObj -> saveImage($dirImg.$newFile, 100);
					chmod($dirImg, 0755);

					$post_img = $newFile;
				} else {
					$post_img = '';
				}
						
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO pub_post(post_id, post_judul, post_desk, post_publish, post_img, post_see, ca_id, 
											_active, _cre, _cre_date, _chg, _chg_date) 
											VALUES('$post_id','$post_judul','$post_desk','$post_publish','$post_img','$post_see','$ka_id',
											'$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
										  or die('Ada kesalahan pada query insert : '.$mysqli->error);
			
			
				// cek query
				if ($insert) {
					// jika berhasil tampilkan pesan berhasil simpan data
					echo json_encode(array('stats'=>'sukses','msgErrors'=>$post_id));
				} else {
					// jika gagal tampilkan pesan gagal simpan data
					echo json_encode(array('stats'=>'gagal','msgErrors'=>$mysqli->error));
				}
				// tutup koneksi
				$mysqli->close();   
			
			break;
		case 2:
			
				if (isset($_REQUEST['post_id'])) {
					$post_id = $_REQUEST['post_id'];
					
					// ambil data hasil post dari ajax
					$post_judul		= isset($_REQUEST['post_judul']) ? strval($_REQUEST['post_judul']) : '';
					$post_desk	= isset($_REQUEST['post_desk']) ? strval($_REQUEST['post_desk']) : '';
					$post_publish	= isset($_REQUEST['post_publish']) ? strval($_REQUEST['post_publish']) : '';
					$post_img		= isset($_REQUEST['post_img']) ? strval($_REQUEST['post_img']) : '';
					$ka_id = str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					//foder upload
					$dirImg = '../'.$_dirPost;

					//make directory
					if (!file_exists($dirImg) && !is_dir($dirImg)) {
						mkdir($dirImg, 0755, true);
					}
					//echo $_FILES['post_img']['name'];
					if ($_FILES['post_img']['name']) {
						$tempFile = explode(".", $_FILES["post_img"]["name"]);
						$newFile = $post_id.'.'.end($tempFile);

						//checking if file exsists
						if(file_exists($dirImg.$newFile)) {
							unlink($dirImg.$newFile);
						}
						
						chmod($dirImg, 0777);
						move_uploaded_file($_FILES["post_img"]["tmp_name"], $dirImg.$newFile);
						// *** 1) Initialize / load image 
						$resizeObj = new resize($dirImg.$newFile);
						// *** 2) Resize image (options: exact, height, width, auto, crop) 
						$resizeObj -> resizeImage($resizeWPost, $resizeHPost, $resizeOPost);
						// *** 3) Save image 
						$resizeObj -> saveImage($dirImg.$newFile, 100);
						chmod($dirImg, 0755);

						//$post_imgx = '.'.end($tempFile);
						
                        //chmod($dirImg, 0755);
						$post_img = "post_img='".$newFile."',";
						
						//echo $_FILES['post_img']['name'];
					}else{
                        $post_img = '';
						//echo $_FILES['post_img']['name'];
					}
					
					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_post SET post_judul='$post_judul', 
																		post_desk='$post_desk', 
																		post_publish='$post_publish', 
																		$post_img
																		_chg='$_chg', 
																		_chg_date=SYSDATE()
													WHERE _active=1 AND post_id='$post_id' AND ca_id='$ka_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					// cek query
					if ($update) {
						// jika berhasil tampilkan pesan berhasil simpan data
						echo json_encode(array('stats'=>'sukses','msgErrors'=>$post_id));
					} else {
						// jika gagal tampilkan pesan gagal simpan data
						echo json_encode(array('stats'=>'gagal','msgErrors'=>'Data tidak ditemukan'));
					}
				}
				// tutup koneksi
				$mysqli->close();   			
			
			
			break;
		case 3:
			
				if (isset($_REQUEST['post_id'])) {
					// ambil data hasil post dari ajax
					$post_id = $_REQUEST['post_id'];
					$ka_id = str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_post SET _active='0',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE _active=1 AND post_id='$post_id' AND ca_id='$ka_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					// cek query
					if ($update) {
						// jika berhasil tampilkan pesan berhasil ubah data
						echo json_encode(array('stats'=>'sukses','msgErrors'=>'tb_post'));
					} else {
						// jika gagal tampilkan pesan gagal ubah data
						echo json_encode(array('stats'=>'gagal','msgErrors'=>'Data tidak ditemukan'));
					}
				}
				// tutup koneksi
				$mysqli->close();   			
			
			break;
		case 4:
			
				if (isset($_REQUEST['post_id'])) {
					// ambil data get dari ajax
					$post_id = htmlentities($_REQUEST['post_id']);
					$ka_id = str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT post_id, post_judul, post_desk, post_publish, post_datex, post_img
													FROM pub_post
												WHERE _active=1 AND post_id='$post_id' AND ca_id='$ka_id'")
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
			
				//SELECT post_id, post_judul, post_desk, post_publish, post_img, post_see, ka_id, _active, _cre, _cre_date, _chg, _chg_date FROM tb_post;
				// nama table
				$table = 'pub_post';
				/*
				$table = <<<EOT
							(
								SELECT 
									a.ka_id, a.ka_name, a.ka_icon, a.subka_id, a._active, 
									b.subka_name
								FROM mast_kategori a
									LEFT JOIN mast_subka b ON a.subka_id = b.subka_id
								WHERE a._active=1
							) temp
						EOT;		
				*/
			
				// Table's primary key
				$primaryKey = 'post_id';

				$columns = array(
					array( 'db' => 'post_id', 'dt' => 0 ),
					array( 'db' => 'post_judul', 'dt' => 1 ),
					array( 'db' => 'post_publish', 'dt' => 2 ),
					array( 'db' => '_active', 'dt' => 3 ),
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
				);
				
				$where ="_active=1 AND ca_id=$_REQUEST[ka_id]";

				// ssp class
				require '../config/ssp.class.php';

				echo json_encode(
					//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
					SSP::complex( $_GET, $con, $table, $primaryKey, $columns, null, $where )
				);
			
			break;
		case 6:
				if (isset($_REQUEST['post_id'])) {
					
					$post_id = $_REQUEST['post_id'];
					$files_down = isset($_REQUEST['files_down']) ? strval($_REQUEST['files_down']) : '0';
					
					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;
					
					/*start Dropzone Upload*/
					$dirUpload = '../'.$_dirFiles;
					if (!file_exists($dirUpload) && !is_dir($dirUpload)) {
						mkdir($dirUpload, 0777, true);
					}
					
					if(isset($_FILES["file"]))
					{
						$ret = array();

					//	This is for custom errors;	
					/*	$custom_error= array();
						$custom_error['jquery-upload-file-error']="File already exists";
						echo json_encode($custom_error);
						die();
					*/
						$error =$_FILES["file"]["error"];
						//You need to handle  both cases
						//If Any browser does not support serializing of multiple files using FormData() 
						if(!is_array($_FILES["file"]["name"])) //single file
						{
							$countRec = loadRecText('count(files_id)', 'pub_files', 'post_id='.$post_id);

							$files_id = str_pad($countRec+1, 3, "0", STR_PAD_LEFT);
							$fileName = $post_id.'.'.$_FILES["file"]["name"];
							chmod($dirUpload, 0777);
								move_uploaded_file($_FILES["file"]["tmp_name"],$dirUpload.$fileName);
							chmod($dirUpload, 0755);
							$ret[]= $fileName;
							
							//SELECT files_id, post_id, files_nm, files_down, _active, _cre, _cre_date, _chg, _chg_date FROM pub_files
							$insert2 = $mysqli->query("INSERT INTO pub_files(files_id, post_id, files_nm, files_down, _active, _cre, _cre_date, _chg, _chg_date) 
														VALUES('$files_id','$post_id','$fileName','$files_down','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
													  or die('Ada kesalahan pada query insert : '.$mysqli->error);
						}
						else  //Multiple files, file[]
						{
						  $fileCount = count($_FILES["file"]["name"]);
						  for($i=0; $i < $fileCount; $i++)
						  {
							$countRec = loadRecText('count(files_id)', 'pub_files', 'post_id='.$post_id);

							$files_id = str_pad($countRec+1, 3, "0", STR_PAD_LEFT);
							$fileName = $post_id.'.'.$_FILES["file"]["name"][$i];
							move_uploaded_file($_FILES["file"]["tmp_name"][$i],$dirUpload.$fileName);
							$ret[]= $fileName;

							$insert2 = $mysqli->query("INSERT INTO pub_files(files_id, post_id, files_nm, files_down, _active, _cre, _cre_date, _chg, _chg_date) 
														VALUES('$files_id','$post_id','$fileName','$files_down','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
													  or die('Ada kesalahan pada query insert : '.$mysqli->error);
						  }

						}
						echo json_encode($ret);
					}
					/*end Dropzone Upload*/
				}
				// tutup koneksi
				$mysqli->close();
			break;
		case 7:
				if (isset($_REQUEST['gID'])) {
					// ambil data hasil post dari ajax
					$gID = $_REQUEST['gID'];
					$gPS = $_REQUEST['gPS'];
					$gNM = $_REQUEST['gNM'];
					$filesUpdate = substr($_dirFiles,3).$gNM;

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_files SET _active='0',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE files_id='$gID' AND post_id='$gPS'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
						unlink($_SERVER['DOCUMENT_ROOT'].'/'.$filesUpdate);
					// cek query
					if ($update) {
						// jika berhasil tampilkan pesan berhasil ubah data
						echo json_encode(array('stats'=>'sukses','msgErrors'=>$gPS));
					} else {
						// jika gagal tampilkan pesan gagal ubah data
						echo json_encode(array('stats'=>'gagal','msgErrors'=>'Data tidak ditemukan'));
					}
				}
				// tutup koneksi
				$mysqli->close();   			
		
			break;
		case 8:
			//SELECT files_id, post_id, files_nm, files_down, _active, _cre, _cre_date, _chg, _chg_date FROM pub_files
				// nama table
				$table = 'pub_files';
			
				// Table's primary key
				$primaryKey = 'files_id';

				$columns = array(
					array( 'db' => 'files_id', 'dt' => 0 ),
					array( 'db' => 'post_id', 'dt' => 1 ),
					array( 'db' => 'files_nm', 'dt' => 2 ),
					array( 'db' => '_active', 'dt' => 3 ),
				);
				
				$where ="_active=1 AND post_id=$_REQUEST[post_id]";

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