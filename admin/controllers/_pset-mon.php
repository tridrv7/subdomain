<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

//SELECT ka_id, ka_name, ka_desk, ka_icon, fm_id, _active, _cre, _cre_date, _chg, _chg_date FROM mast_kategori;

	switch($_REQUEST['_act']){
		case 1:
				//count mast_kategori
				$sub_kdskpd	= isset($_REQUEST['kdskpd']) ? strval($_REQUEST['kdskpd']) : '';
				list($var1, $var2) = explode('.',$_REQUEST['kdskpd']);
			
				$result = $mysqli->query("SELECT idskpd FROM mast_skpd WHERE idskpd LIKE '$var2%'")
									or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
				$rows = $result->num_rows;
			
				$idskpd		= $var2.str_pad($rows, 2, "0", STR_PAD_LEFT);
				$nmskpd	= isset($_REQUEST['nmskpd']) ? ucwords(strval($_REQUEST['nmskpd'])) : '';
				$kdskpd	= isset($_REQUEST['kdskpd']) ? strval($_REQUEST['kdskpd']) : '';
				$prskpd	= isset($_REQUEST['prskpd']) ? strval($_REQUEST['prskpd']) : '';
				$website	= isset($_REQUEST['website']) ? strval($_REQUEST['website']) : '';
			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO mast_skpd(idskpd, nmskpd, kdskpd, prskpd, website, last_chk, last_up, _active, _cre, _cre_date, _chg, _chg_date) 
											VALUES('$idskpd','$nmskpd','$kdskpd','$prskpd','$website','','','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
				if (isset($_REQUEST['idskpd'])) {
					$idskpd = $_REQUEST['idskpd'];
					
					// ambil data hasil post dari ajax
					$nmskpd	= isset($_REQUEST['nmskpd']) ? ucwords(strval($_REQUEST['nmskpd'])) : '';
					$kdskpd	= isset($_REQUEST['kdskpd']) ? strval($_REQUEST['kdskpd']) : '';
					$prskpd	= isset($_REQUEST['prskpd']) ? strval($_REQUEST['prskpd']) : '';
					$website	= isset($_REQUEST['website']) ? strval($_REQUEST['website']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE mast_skpd SET nmskpd='$nmskpd', 
																		kdskpd='$kdskpd', 
																		prskpd='$prskpd', 
																		website='$website', 
																		_chg='$_chg', 
																		_chg_date=SYSDATE()
													WHERE idskpd='$idskpd'")
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
				if (isset($_REQUEST['idskpd'])) {
					// ambil data hasil post dari ajax
					$idskpd = $_REQUEST['idskpd'];
					$_active = $_REQUEST['_active'];

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE mast_skpd SET _active='$_active',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE idskpd='$idskpd'")
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
				if (isset($_REQUEST['idskpd'])) {
					// ambil data get dari ajax
					$idskpd = htmlentities($_REQUEST['idskpd']);
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT idskpd, nmskpd, kdskpd, prskpd, website
													FROM mast_skpd
												WHERE _active=1 AND idskpd='$idskpd'")
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
			
				//SELECT idskpd, nmskpd, kdskpd, prskpd, website, last_chk, last_up FROM mast_skpd;
				// nama table
				$table = 'mast_skpd';
				// Table's primary key
				$primaryKey = 'idskpd';

				$columns = array(
					array( 'db' => 'idskpd', 'dt' => 0 ),
					array( 'db' => 'nmskpd', 'dt' => 1 ),
					array( 'db' => 'website', 'dt' => 2 ),
					array( 'db' => 'last_chk', 'dt' => 3 ),
					array( 'db' => 'last_up', 'dt' => 4 ),
					array( 'db' => '_active', 'dt' => 5 ),
				);
				
				$where ='';

				// ssp class
				require '../config/ssp.class.php';

				echo json_encode(
					//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
					SSP::complex( $_GET, $con, $table, $primaryKey, $columns, null, $where )
				);
			
			break;
		case 6://CEK LAST UPDATE SUBDOMAIN
			
                // fungsi untuk loop desa
                $result = $mysqli->query("SELECT idskpd, nmskpd, kdskpd, prskpd, website
                                            FROM mast_skpd
                                        WHERE _active=1 AND website!=''")
                                    or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
				$i=1;
                while($rrest = $result->fetch_assoc()){
					
					$idskpd 	= $rrest['idskpd'];
					$_url 		= trim($rrest['website']);
					$_complete 	= $_url.'/backend/api.php';

					$jsondata = file_get_contents($_complete);
					$data = json_decode($jsondata, true);

					$last_up	= $data['news']['date'];

					$update = $mysqli->query("UPDATE mast_skpd SET last_up='$last_up', last_chk=SYSDATE() WHERE idskpd='$idskpd'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
						
				}
			
				// cek query
				if ($update) {
					echo "sukses";
				} else {
					echo $mysqli->error;
				}

				// tutup koneksi
                $mysqli->close();   
			
			break;
	}
} else {
    echo '<script>window.location="'.$servLogs.'"</script>';
}
?>