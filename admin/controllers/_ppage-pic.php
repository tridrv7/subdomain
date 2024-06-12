<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
require '../config/resize-class.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

//SELECT ga_id, ga_see, post_content, post_publish, ga_img, post_see, ka_id, _active, _cre, _cre_date, _chg, _chg_date FROM tb_galery;
//SELECT ban_id, ban_title, ban_desk, ban_img, ban_stat, _active, _cre, _cre_date, _chg, _chg_date FROM pub_banner	

	switch($_REQUEST['_act']){
		case 1:
			
				$ga_id		= time();
				$ga_judul	= isset($_REQUEST['ga_judul']) ? strval($_REQUEST['ga_judul']) : '';
				$ga_desk	= isset($_REQUEST['ga_desk']) ? strval($_REQUEST['ga_desk']) : '';
				$ga_img		= isset($_REQUEST['ga_img']) ? strval($_REQUEST['ga_img']) : '';
				$ka_id = str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);
			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				//foder upload
				$dirImg = '../'.$_dirGalery;

				//make directory
				if (!file_exists($dirImg) && !is_dir($dirImg)) {
					mkdir($dirImg, 0755, true);
				}
			
				if ($_FILES['ga_img']['name']) {
					$tempFile = explode(".", $_FILES["ga_img"]["name"]);
					$newFile = $ga_id.'.'.end($tempFile);
					
					//checking if file exsists
					if(file_exists($dirImg.$newFile)) {
						unlink($dirImg.$newFile);
					}
					
					if($ka_id=='1'){
						$optImg = 'exact';
					} else {
						$optImg = 'auto';
					}

					chmod($dirImg, 0777);
					move_uploaded_file($_FILES["ga_img"]["tmp_name"], $dirImg.$newFile);
					// *** 1) Initialize / load image 
					$resizeObj = new resize($dirImg.$newFile);
					// *** 2) Resize image (options: exact, height, width, auto, crop) 
					$resizeObj -> resizeImage($resizeWPost, $resizeHPost, $optImg);
					// *** 3) Save image 
					$resizeObj -> saveImage($dirImg.$newFile, 100);

					//watermark_image($dirImg.$newFile, '../img/watermark.png', $dirImg.$newFile);
					//move_uploaded_file($_FILES["ga_img"]["tmp_name"], $dirImg.$newFile);

					chmod($dirImg, 0755);
					//$ga_img = '.'.end($tempFile);
					$ga_img = $newFile;
				} else {
					$ga_img = '';
				}

			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO pub_banner(ban_id, ban_title, ban_desk, ban_img, ban_stat, _active, _cre, _cre_date, _chg, _chg_date) 
											VALUES('$ga_id','$ga_judul','$ga_desk','$ga_img','$ka_id','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
			
				if (isset($_REQUEST['ga_id'])) {
					$ga_id = $_REQUEST['ga_id'];
					
					// ambil data hasil post dari ajax
					$ga_judul	= isset($_REQUEST['ga_judul']) ? strval($_REQUEST['ga_judul']) : '';
					$ga_desk	= isset($_REQUEST['ga_desk']) ? strval($_REQUEST['ga_desk']) : '';
					$ga_img		= isset($_REQUEST['ga_img']) ? strval($_REQUEST['ga_img']) : '';
					$ka_id = str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					//foder upload
					$dirImg = '../'.$_dirGalery;

					//make directory
					if (!file_exists($dirImg) && !is_dir($dirImg)) {
						mkdir($dirImg, 0755, true);
					}
					//echo $_FILES['ga_img']['name'];
					if ($_FILES['ga_img']['name']) {
						$tempFile = explode(".", $_FILES["ga_img"]["name"]);
						//$newFile = $ga_id.'.'.end($tempFile);
						$newFile = $ga_id.'.'.end($tempFile);

						//checking if file exsists
						if(file_exists($dirImg.$newFile)) {
							unlink($dirImg.$newFile);
						}
						
						if($ka_id=='1'){
							$optImg = 'exact';
						} else {
							$optImg = 'auto';
						}

                        chmod($dirImg, 0777);
						move_uploaded_file($_FILES["ga_img"]["tmp_name"], $dirImg.$newFile);
						// *** 1) Initialize / load image 
						$resizeObj = new resize($dirImg.$newFile);
						// *** 2) Resize image (options: exact, height, width, auto, crop) 
						$resizeObj -> resizeImage($resizeWPost, $resizeHPost, $optImg);
						// *** 3) Save image 
						$resizeObj -> saveImage($dirImg.$newFile, 100);

						//watermark_image($dirImg.$newFile, '../img/watermark.png', $dirImg.$newFile);
						//move_uploaded_file($_FILES["ga_img"]["tmp_name"], $dirImg.$newFile);
						
                        chmod($dirImg, 0755);
                        //$ga_img = "ban_img='.".end($tempFile)."',";
                        $ga_img = "ban_img='".$newFile."',";
						
						//echo $_FILES['ga_img']['name'];
					}else{
                        $ga_img = '';
						//echo $_FILES['ga_img']['name'];
					}
					
					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_banner SET ban_title='$ga_judul', 
																	ban_desk='$ga_desk', 
																	$ga_img
																	_chg='$_chg', 
																	_chg_date=SYSDATE()
													WHERE _active=1 AND ban_id='$ga_id' AND ban_stat='$ka_id'")
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
			
				if (isset($_REQUEST['ga_id'])) {
					// ambil data hasil post dari ajax
					$ga_id = $_REQUEST['ga_id'];
					$ka_id = str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_banner SET _active='0',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE _active=1 AND ban_id='$ga_id' AND ban_stat='$ka_id'")
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
			
				if (isset($_REQUEST['ga_id'])) {
					// ambil data get dari ajax
					$ga_id = htmlentities($_REQUEST['ga_id']);
					$ka_id = str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);
					
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT ban_id, ban_title, ban_desk, ban_img, ban_stat
													FROM pub_banner
												WHERE _active=1 AND ban_id='$ga_id' AND ban_stat='$ka_id'")
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
			
				//SELECT ban_id, ban_title, ban_desk, ban_img, ban_stat, _active, _cre, _cre_date, _chg, _chg_date FROM pub_banner	
				// nama table
				$table = 'pub_banner';
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
				$primaryKey = 'ban_id';

				$columns = array(
					array( 'db' => 'ban_id', 'dt' => 0 ),
					array( 'db' => 'ban_title', 'dt' => 1 ),
					array( 'db' => '_active', 'dt' => 2 ),
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
				
				$where ="_active=1 AND ban_stat=$_REQUEST[ka_id]";

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