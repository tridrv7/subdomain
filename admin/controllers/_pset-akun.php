<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
	
//SELECT us_nip, us_nama, us_email, us_roles, us_passwd, us_last, _active, _cre, _cre_date, _chg, _chg_date FROM set_users WHERE 1
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

	switch($_REQUEST['_act']){
		case 1:
			
				$us_nip		= time();
				$us_nama	= isset($_REQUEST['us_nama']) ? strval($_REQUEST['us_nama']) : '';
				$us_email	= isset($_REQUEST['us_email']) ? strval($_REQUEST['us_email']) : '';
				$us_roles	= isset($_REQUEST['us_roles']) ? strval($_REQUEST['us_roles']) : '';
				//if(!empty($_REQUEST['us_passwd2'])) $us_passwd2 = md5(enc($_REQUEST['us_passwd2'])); else echo "gagal";
				if(!empty($_REQUEST['us_passwd2'])) $us_passwd2 = password_hash($_REQUEST['us_passwd2'], PASSWORD_DEFAULT); else echo "gagal";

				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
						
			
			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO set_users(us_nip, us_nama, us_email, us_roles, us_passwd, us_last, _active, _cre, _cre_date, _chg, _chg_date) 
													VALUES('$us_nip','$us_nama','$us_email','$us_roles','$us_passwd2',SYSDATE(),'$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
			
				if (isset($_REQUEST['us_nip'])) {
					$us_nip = $_REQUEST['us_nip'];
					
					// ambil data hasil post dari ajax
					$us_nip		= isset($_REQUEST['us_nip']) ? strval($_REQUEST['us_nip']) : '';
					$us_nama	= isset($_REQUEST['us_nama']) ? strval($_REQUEST['us_nama']) : '';
					$us_email	= isset($_REQUEST['us_email']) ? strval($_REQUEST['us_email']) : '';
					$us_roles	= isset($_REQUEST['us_roles']) ? strval($_REQUEST['us_roles']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;


					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_users SET us_nama='$us_nama', 
																us_email='$us_email', 
																us_roles='$us_roles', 
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE us_nip='$us_nip'")
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
		case 6:
			
				if (isset($_REQUEST['us_nip'])) {
					$us_nip = $_REQUEST['us_nip'];
					
					// ambil data hasil post dari ajax
					$us_nip		= isset($_REQUEST['us_nip']) ? strval($_REQUEST['us_nip']) : '';
					if(!empty($_REQUEST['us_passwd2'])) $us_passwd2 = password_hash($_REQUEST['us_passwd2'], PASSWORD_DEFAULT); else echo "gagal";

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;


					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_users SET us_passwd='$us_passwd2', 
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE us_nip='$us_nip'")
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
			
				if (isset($_REQUEST['us_nip'])) {
					// ambil data hasil post dari ajax
					$us_nip = $_REQUEST['us_nip'];

					$_active = $_REQUEST['_active'];
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_users SET _active='$_active',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE us_nip='$us_nip'")
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
			
				if (isset($_REQUEST['us_nip'])) {
					// ambil data get dari ajax
					$us_nip = htmlentities($_REQUEST['us_nip']);
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT us_nip, us_nama, us_email, us_roles, us_passwd, us_last, _active, _cre, _cre_date, _chg, _chg_date
                                                FROM set_users 
											WHERE _active=1 AND us_nip='$us_nip'")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
					if($result->num_rows!=0){
						$data = $result->fetch_assoc();
						
						echo json_encode($data);
					} else {
						echo json_encode(array('stats'=>404,'msgErrors'=>'Akun tidak ditemukan'));
					}
				}
				// tutup koneksi
				$mysqli->close();
			
			break;
		case 5:
			
				//SELECT us_nip, us_nama, us_email, us_roles, us_passwd, us_last, _active, _cre, _cre_date, _chg, _chg_date FROM set_users WHERE 1
				// nama table
				$table = 'set_users';
				// Table's primary key
				$primaryKey = 'us_nip';

				$columns = array(
					array( 'db' => 'us_nip', 'dt' => 0 ),
					array( 'db' => 'us_nama', 'dt' => 1 ),
					array( 'db' => 'us_email', 'dt' => 2 ),
					array( 'db' => 'us_last', 'dt' => 3 ),
					array( 
                        'db' => 'us_roles', 
                        'dt' => 4,
						'formatter' => function( $d, $row ) {
							return loadRecText('ro_name','set_role','ro_id="'.$d.'"');
						}
                        //loadRecText('ro_name','set_role',$row)
                    ),
					array( 'db' => '_active', 'dt' => 5 ),
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
				
				$where ="";

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