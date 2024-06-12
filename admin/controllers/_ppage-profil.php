<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
require '../config/resize-class.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

//SELECT prof_id, prof_lnm, prof_snm, prof_addr, prof_fax, prof_telp, prof_mail, prof_maps, prof_skm, prof_desk, prof_lg, _active, _cre, _cre_date, _chg, _chg_date FROM pub_profile WHERE 1

	switch($_REQUEST['_act']){
		case 1:
			
				$prof_id	= time();
				$prof_lnm	= isset($_REQUEST['prof_lnm']) ? strval($_REQUEST['prof_lnm']) : '';
				$prof_snm	= isset($_REQUEST['prof_snm']) ? strval($_REQUEST['prof_snm']) : '';
				$prof_addr	= isset($_REQUEST['prof_addr']) ? strval($_REQUEST['prof_addr']) : '';
				$prof_fax	= isset($_REQUEST['prof_fax']) ? strval($_REQUEST['prof_fax']) : '';
				$prof_telp	= isset($_REQUEST['prof_telp']) ? strval($_REQUEST['prof_telp']) : '';
				$prof_mail	= isset($_REQUEST['prof_mail']) ? strval($_REQUEST['prof_mail']) : '';
				$prof_pwd	= isset($_REQUEST['prof_pwd']) ? strval($_REQUEST['prof_pwd']) : '';
				$prof_maps	= isset($_REQUEST['prof_maps']) ? strval($_REQUEST['prof_maps']) : '';
				$prof_skm	= isset($_REQUEST['prof_skm']) ? strval($_REQUEST['prof_skm']) : '';
				$prof_desk	= isset($_REQUEST['prof_desk']) ? strval($_REQUEST['prof_desk']) : '';
				$prof_lg	= isset($_REQUEST['prof_lg']) ? strval($_REQUEST['prof_lg']) : '';
				$prof_sty	= isset($_REQUEST['prof_sty']) ? strval($_REQUEST['prof_sty']) : '';
			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				//foder upload
				$dirImg = '../'.$_dirProf;

				//make directory
				if (!file_exists($dirImg) && !is_dir($dirImg)) {
					mkdir($dirImg, 0755, true);
				}
				if ($_FILES['prof_lg']['name']) {
					$tempFile = explode(".", $_FILES["prof_lg"]["name"]);
					$newFile = $prof_id.'.'.end($tempFile);
					
					//checking if file exsists
					if(file_exists($dirImg.$newFile)) {
						unlink($dirImg.$newFile);
						//watermark_image($dirImg.$newFile, '../img/watermark.png', $dirImg.$newFile);
						//move_uploaded_file($_FILES["ga_img"]["tmp_name"], $dirImg.$newFile);
					}

					chmod($dirImg, 0777);
					move_uploaded_file($_FILES["prof_lg"]["tmp_name"], $dirImg.$newFile);
					// *** 1) Initialize / load image 
					$resizeObj = new resize($dirImg.$newFile);
					// *** 2) Resize image (options: exact, height, width, auto, crop) 
					$resizeObj -> resizeImage(800, 800, 'auto');
					// *** 3) Save image 
					$resizeObj -> saveImage($dirImg.$newFile, 100);
					chmod($dirImg, 0755);
					
					//prof_lg = '.'.end($tempFile);
					$prof_lg = $newFile;
				} else {
					$prof_lg = '';					
				}
			
				$update = $mysqli->query("UPDATE pub_profile SET _active='0',
															_chg='$_chg', 
															_chg_date=SYSDATE()
										WHERE _active=1")
										  or die('Ada kesalahan pada query update : '.$mysqli->error);

			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO pub_profile(prof_id, prof_lnm, prof_snm, prof_addr, prof_fax, prof_telp, prof_mail, prof_pwd, prof_maps, prof_skm, prof_desk, prof_lg, prof_sty, _active, _cre, _cre_date, _chg, _chg_date) 
											VALUES('$prof_id','$prof_lnm','$prof_snm','$prof_addr','$prof_fax','$prof_telp','$prof_mail','$prof_pwd','$prof_maps','$prof_skm','$prof_desk','$prof_lg','$prof_sty',
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
		case 4:

			
				// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
				$result = $mysqli->query("SELECT prof_id, prof_lnm, prof_snm, prof_addr, prof_fax, prof_telp, prof_mail, prof_pwd, prof_maps, prof_skm, prof_desk, prof_lg, prof_sty 
											FROM pub_profile 
											WHERE _active=1")
										  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
				if($result->num_rows!=0){
					$data = $result->fetch_assoc();

					echo json_encode($data);
				} else {
					echo json_encode(array('stats'=>404,'msgErrors'=>'Data tidak ditemukan'));
				}
			
				// tutup koneksi
				$mysqli->close();
			
			break;
	}

} else {
    echo '<script>window.location="'.$servLogs.'"</script>';
}
?>