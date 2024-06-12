<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
require '../config/resize-class.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

//SELECT post_id, post_judul, post_desk, post_publish, post_datex, post_img, post_see, ca_id, _active, _cre, _cre_date, _chg, _chg_date FROM pub_post

	switch($_REQUEST['_act']){
		case 1:
			
				$agnd_id		= time();
				$agnd_judul		= isset($_REQUEST['agnd_judul']) ? strval($_REQUEST['agnd_judul']) : '';
				$agnd_content	= isset($_REQUEST['agnd_content']) ? strval($_REQUEST['agnd_content']) : '';
				$agnd_start		= isset($_REQUEST['agnd_start']) ? strval($_REQUEST['agnd_start']) : '';
				$agnd_end		= isset($_REQUEST['agnd_end']) ? strval($_REQUEST['agnd_end']) : '';
				$agnd_img		= isset($_REQUEST['agnd_img']) ? strval($_REQUEST['agnd_img']) : '';
				$agnd_see		= isset($_REQUEST['agnd_see']) ? strval($_REQUEST['agnd_see']) : '0';
				$ka_id	= str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);
			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				//foder upload
				$dirImg = '../'.$_dirPost;

				//make directory
				if (!file_exists($dirImg) && !is_dir($dirImg)) {
					mkdir($dirImg, 0755, true);
				}
			
				if (isset($_FILES['agnd_img']['name'])) {
					$tempFile = explode(".", $_FILES["agnd_img"]["name"]);
					$newFile = $agnd_id.'.'.end($tempFile);
					
					//checking if file exsists
					if(file_exists($dirImg.$newFile)) {
						unlink($dirImg.$newFile);
					}
					
					chmod($dirImg, 0777);
					move_uploaded_file($_FILES["agnd_img"]["tmp_name"], $dirImg.$newFile);
					// *** 1) Initialize / load image 
					$resizeObj = new resize($dirImg.$newFile);
					// *** 2) Resize image (options: exact, height, width, auto, crop) 
					$resizeObj -> resizeImage($resizeWPost, $resizeHPost, $resizeOPost);
					// *** 3) Save image 
					$resizeObj -> saveImage($dirImg.$newFile, 100);
					chmod($dirImg, 0755);
					
						//watermark_image($dirImg.$newFile, '../img/watermark.png', $dirImg.$newFile);
						//move_uploaded_file($_FILES["agnd_img"]["tmp_name"], $dirImg.$newFile);

					//$agnd_img = '.'.end($tempFile);
					$agnd_img = $newFile;
				} else {
					$agnd_img = '';
				}

				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO pub_post(post_id, post_judul, post_desk, post_publish, post_datex, post_img, post_see, ca_id,
											_active, _cre, _cre_date, _chg, _chg_date) 
											VALUES('$agnd_id','$agnd_judul','$agnd_content','$agnd_start','$agnd_end','$agnd_img','$agnd_see','$ka_id',
											'$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
			
				if (isset($_REQUEST['agnd_id'])) {
					$agnd_id = $_REQUEST['agnd_id'];
					
					// ambil data hasil post dari ajax
					$agnd_judul		= isset($_REQUEST['agnd_judul']) ? strval($_REQUEST['agnd_judul']) : '';
					$agnd_content	= isset($_REQUEST['agnd_content']) ? strval($_REQUEST['agnd_content']) : '';
					$agnd_start		= isset($_REQUEST['agnd_start']) ? strval($_REQUEST['agnd_start']) : '';
					$agnd_end		= isset($_REQUEST['agnd_end']) ? strval($_REQUEST['agnd_end']) : '';
					$agnd_img		= isset($_REQUEST['agnd_img']) ? strval($_REQUEST['agnd_img']) : '';
					$ka_id	= str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					//foder upload
					$dirImg = '../'.$_dirPost;

					//make directory
					if (!file_exists($dirImg) && !is_dir($dirImg)) {
						mkdir($dirImg, 0777, true);
					}
					//echo $_FILES['agnd_img']['name'];
					if (!empty($_FILES['agnd_img']['name'])) {
						$tempFile = explode(".", $_FILES["agnd_img"]["name"]);
						$newFile = $agnd_id.'.'.end($tempFile);

						//checking if file exsists
						if(file_exists($dirImg.$newFile)) {
							unlink($dirImg.$newFile);
						}
						
						chmod($dirImg, 0777);
						move_uploaded_file($_FILES["agnd_img"]["tmp_name"], $dirImg.$newFile);
						// *** 1) Initialize / load image 
						$resizeObj = new resize($dirImg.$newFile);
						// *** 2) Resize image (options: exact, height, width, auto, crop) 
						$resizeObj -> resizeImage($resizeWPost, $resizeHPost, $resizeOPost);
						// *** 3) Save image 
						$resizeObj -> saveImage($dirImg.$newFile, 100);
						chmod($dirImg, 0755);
						
						//watermark_image($dirImg.$newFile, '../img/watermark.png', $dirImg.$newFile);
						//move_uploaded_file($_FILES["agnd_img"]["tmp_name"], $dirImg.$newFile);

						//$agnd_imgx = '.'.end($tempFile);
						
                        //chmod($dirImg, 0755);
                        //$agnd_img = "agnd_img='.".end($tempFile)."',";
						$agnd_img = "post_img='".$newFile."',";
						
						//echo $_FILES['agnd_img']['name'];
					}else{
                        $agnd_img = '';
						//echo $_FILES['agnd_img']['name'];
					}
					
					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_post SET post_judul='$agnd_judul', 
																		post_desk='$agnd_content', 
																		post_publish='$agnd_start', 
																		post_datex='$agnd_end', 
																		$agnd_img
																		_chg='$_chg', 
																		_chg_date=SYSDATE()
													WHERE post_id='$agnd_id' AND ca_id='$ka_id'")
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
			
				if (isset($_REQUEST['agnd_id'])) {
					// ambil data hasil post dari ajax
					$agnd_id = $_REQUEST['agnd_id'];
					$ka_id	= str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_post SET _active='0',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE post_id='$agnd_id' AND ca_id='$ka_id'")
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
			
				if (isset($_REQUEST['agnd_id'])) {
					// ambil data get dari ajax
					$agnd_id = htmlentities($_REQUEST['agnd_id']);
					$ka_id	= str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT post_id, post_judul, post_desk, post_publish, post_datex, post_img, post_see, ca_id
													FROM pub_post
												WHERE _active=1 AND post_id='$agnd_id' AND ca_id='$ka_id'")
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
			
				//SELECT agnd_id, agnd_judul, agnd_content, agnd_publish, agnd_img, agnd_see, ka_id, _active, _cre, _cre_date, _chg, _chg_date FROM pub_post;
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
					array( 'db' => 'post_datex', 'dt' => 3 ),
					array( 'db' => '_active', 'dt' => 4 ),
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
	}
} else {
    echo '<script>window.location="'.$servLogs.'"</script>';
}
?>