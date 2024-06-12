<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
require '../config/resize-class.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

//SELECT sos_id, sos_nm, sos_ic, sos_url, cat, _active, _cre, _cre_date, _chg, _chg_date FROM pub_socials WHERE 1

	switch($_REQUEST['_act']){
		case 1:
			
				$lin_id		= time();
				$lin_name	= isset($_REQUEST['lin_name']) ? strval($_REQUEST['lin_name']) : '';
				$lin_addr	= isset($_REQUEST['lin_addr']) ? strval($_REQUEST['lin_addr']) : '';
				$lin_img	= isset($_REQUEST['lin_img']) ? strval($_REQUEST['lin_img']) : '';
				$ka_id	= str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);
			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				//foder upload
				$dirImg = '../'.$_dirLink;

				//make directory
				if (!file_exists($dirImg) && !is_dir($dirImg)) {
					mkdir($dirImg, 0755, true);
				}
				if ($_FILES['lin_img']['name']) {
					$tempFile = explode(".", $_FILES["lin_img"]["name"]);
					$newFile = $lin_id.'.'.end($tempFile);
					
					//checking if file exsists
					if(file_exists($dirImg.$newFile)) {
						unlink($dirImg.$newFile);
					}
					
					chmod($dirImg, 0777);
					move_uploaded_file($_FILES["lin_img"]["tmp_name"], $dirImg.$newFile);
					// *** 1) Initialize / load image 
					$resizeObj = new resize($dirImg.$newFile);
					// *** 2) Resize image (options: exact, height, width, auto, crop) 
					$resizeObj -> resizeImage($resizeWLink, $resizeHLink, $resizeOLink);
					// *** 3) Save image 
					$resizeObj -> saveImage($dirImg.$newFile, 100);
					chmod($dirImg, 0755);

					//$lin_img = '.'.end($tempFile);
					$lin_img = $newFile;
				}else{
					$lin_img = '';
					//echo $_FILES['lin_img']['name'];
				}

			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO pub_socials(sos_id, sos_nm, sos_ic, sos_url, cat, _active, _cre, _cre_date, _chg, _chg_date) 
											VALUES('$lin_id','$lin_name','$lin_img','$lin_addr','$ka_id','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
			
				if (isset($_REQUEST['lin_id'])) {
					$lin_id = $_REQUEST['lin_id'];
					
					// ambil data hasil post dari ajax
					$lin_name		= isset($_REQUEST['lin_name']) ? strval($_REQUEST['lin_name']) : '';
					$lin_addr		= isset($_REQUEST['lin_addr']) ? strval($_REQUEST['lin_addr']) : '';
					$lin_img		= isset($_REQUEST['lin_img']) ? strval($_REQUEST['lin_img']) : '';
					$ka_id	= str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					//foder upload
					$dirImg = '../'.$_dirLink;

					//make directory
					if (!file_exists($dirImg) && !is_dir($dirImg)) {
						mkdir($dirImg, 0755, true);
					}
					//echo $_FILES['lin_img']['name'];
					if ($_FILES['lin_img']['name']) {
						$tempFile = explode(".", $_FILES["lin_img"]["name"]);
						$newFile = $lin_id.'.'.end($tempFile);

						//checking if file exsists
						if(file_exists($dirImg.$newFile)) {
							unlink($dirImg.$newFile);
						}
						
						chmod($dirImg, 0777);
						move_uploaded_file($_FILES["lin_img"]["tmp_name"], $dirImg.$newFile);
						// *** 1) Initialize / load image 
						$resizeObj = new resize($dirImg.$newFile);
						// *** 2) Resize image (options: exact, height, width, auto, crop) 
						$resizeObj -> resizeImage($resizeWLink, $resizeHLink, $resizeOLink);
						// *** 3) Save image 
						$resizeObj -> saveImage($dirImg.$newFile, 100);
						chmod($dirImg, 0755);

						//$lin_imgx = '.'.end($tempFile);
						
                        //chmod($dirImg, 0755);
                        //$lin_img = "lin_img='.".end($tempFile)."',";
                        $lin_img = "sos_ic='".$newFile."',";
						
						//echo $_FILES['lin_img']['name'];
					}else{
                        $lin_img = '';
						//echo $_FILES['lin_img']['name'];
					}
					
					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_socials SET sos_nm='$lin_name', 
																		sos_url='$lin_addr', 
																		$lin_img
																		_chg='$_chg', 
																		_chg_date=SYSDATE()
													WHERE _active=1 AND sos_id='$lin_id' AND cat='$ka_id'")
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
			
				if (isset($_REQUEST['lin_id'])) {
					// ambil data hasil post dari ajax
					$lin_id = $_REQUEST['lin_id'];
					$ka_id	= str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE pub_socials SET _active='0',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE _active=1 AND sos_id='$lin_id' AND cat='$ka_id'")
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
			
				if (isset($_REQUEST['lin_id'])) {
					// ambil data get dari ajax
					$lin_id = htmlentities($_REQUEST['lin_id']);
					$ka_id	= str_pad($_REQUEST['ka_id'], 3, "0", STR_PAD_LEFT);
					
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT sos_id, sos_nm, sos_ic, sos_url
													FROM pub_socials
												WHERE _active=1 AND sos_id='$lin_id' AND cat='$ka_id'")
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
			
				//SELECT sos_id, sos_nm, sos_ic, sos_url, cat, _active, _cre, _cre_date, _chg, _chg_date FROM pub_socials WHERE 1	
				// nama table
				$table = 'pub_socials';
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
				$primaryKey = 'sos_id';

				$columns = array(
					array( 'db' => 'sos_id', 'dt' => 0 ),
					array( 'db' => 'sos_nm', 'dt' => 1 ),
					array( 'db' => 'sos_url', 'dt' => 2 ),
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
				
				$where ="_active=1 AND cat=$_REQUEST[ka_id]";

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