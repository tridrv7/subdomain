<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

	switch($_REQUEST['_act']){
		case 1:
				// fungsi untuk membuat id transaksi
				$result = $mysqli->query("SELECT sda_id FROM set_sda")
									or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
				$rows = $result->num_rows;

				//$rows = $result->fetch_assoc;
				$sda_id = str_pad($rows+1, 2, "0", STR_PAD_LEFT);
				$sda_n = isset($_REQUEST['sda_name']) ? strval($_REQUEST['sda_name']) : '';
				$sda_name = ucwords($sda_n);

				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : '555';
				$_chg = $_cre;
			

				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO set_sda(sda_id, sda_name, _active, _cre, _cre_date, _chg, _chg_date) 
									VALUES('$sda_id','$sda_name','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
			
				if (isset($_REQUEST['sda_id'])) {
					// ambil data hasil post dari ajax
					$sda_id     = isset($_REQUEST['sda_id']) ? strval($_REQUEST['sda_id']) : '';
					$sda_n = isset($_REQUEST['sda_name']) ? strval($_REQUEST['sda_name']) : '';
					$sda_name = ucwords($sda_n);

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : '555';
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_sda SET sda_name='$sda_name', _chg='$_chg', _chg_date=SYSDATE()
										WHERE sda_id='$sda_id'")
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
			
				if (isset($_REQUEST['sda_id'])) {
					// ambil data hasil post dari ajax
					$sda_id     = isset($_REQUEST['sda_id']) ? strval($_REQUEST['sda_id']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '0';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : '555';
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_sda SET _active='0', _chg='$_chg', _chg_date=SYSDATE()
										WHERE sda_id='$sda_id'")
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
			
				if (isset($_GET['sda_id'])) {
					// ambil data get dari ajax
					$sda_id = $_GET['sda_id'];
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT sda_id, sda_name, _active, _cre, _cre_date, _chg, _chg_date 
                                                FROM set_sda 
											WHERE _active=1 AND sda_id='$sda_id'")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
					$data = $result->fetch_assoc();
				}
				// tutup koneksi
				$mysqli->close(); 

				echo json_encode($data); 			
			
			break;
		case 5:
			
				//SELECT sda_id, sda_name, _active, _cre, _cre_date, _chg, _chg_date FROM set_sda WHERE _active=1 
				/*
				$query = "SELECT a.sda_id, a.sda_name
								, (SELECT th_ang FROM tb_sdath WHERE sda_id=a.sda_id AND th_id=date('Y')-2) as th2
								, (SELECT th_ang FROM tb_sdath WHERE sda_id=a.sda_id AND th_id=date('Y')-1) as th1
								, (SELECT th_ang FROM tb_sdath WHERE sda_id=a.sda_id AND th_id=date('Y')-0) as th0
								, a._active
							FROM set_sda a
							WHERE a._active=1";
				*/
				$th0 = date('Y')-0;
				$th1 = date('Y')-1;
				$th2 = date('Y')-2;
			
				$query = "SELECT a.sda_id, a.sda_name, b.th_ang, c.th_ang, d.th_ang, a._active
							FROM set_sda a
								LEFT JOIN tb_sdath b ON b.sda_id=a.sda_id AND b.th_id='$th2'
								LEFT JOIN tb_sdath c ON c.sda_id=a.sda_id AND c.th_id='$th1'
								LEFT JOIN tb_sdath d ON d.sda_id=a.sda_id AND d.th_id='$th0'
							WHERE a._active=1";
			
				$result = $mysqli->query($query);
			
				$data = array();
				while($row = $result->fetch_array(MYSQLI_NUM)){
					//$data[] = $row;
					$data[] = array($row[0], $row[1], curWord($row[2]), curWord($row[3]), curWord($row[4]), $row[5]);
				}
				
				$results = ["draw" => 0,
						  "recordsTotal" => count($data),
						  "recordsFiltered" => count($data),
						  "data" => $data];

				echo json_encode($results);
			
			break;
		case 6:
				//SELECT th_id, sda_id, th_ang, _active, _cre, _cre_date, _chg, _chg_date FROM tb_sdath;			
				if (isset($_GET['th_id']) && isset($_GET['sda_id'])) {
					// ambil data get dari ajax
					$th_id = $_GET['th_id'];
					$sda_id = $_GET['sda_id'];
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT th_id, sda_id, th_ang, _active, _cre, _cre_date, _chg, _chg_date 
                                                FROM tb_sdath 
											WHERE _active=1 AND th_id='$th_id' AND sda_id='$sda_id'")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
					$data = $result->fetch_assoc();
				}
				// tutup koneksi
				$mysqli->close(); 

				echo json_encode($data);
			
			break;
		case 7:
			
				$th_id = isset($_REQUEST['th_id']) ? strval($_REQUEST['th_id']) : '';
				$sda_id = isset($_REQUEST['sda_id']) ? strval($_REQUEST['sda_id']) : '';
				$th_ang = isset($_REQUEST['th_ang']) ? strval($_REQUEST['th_ang']) : '';

				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : '555';
				$_chg = $_cre;
			
				//SELECT th_id, sda_id, th_ang, _active, _cre, _cre_date, _chg, _chg_date FROM tb_sdath;			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO tb_sdath(th_id, sda_id, th_ang, _active, _cre, _cre_date, _chg, _chg_date) 
									VALUES('$th_id','$sda_id','$th_ang','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())
										ON DUPLICATE KEY
											UPDATE th_ang='$th_ang'")
									or die('Ada kesalahan pada query insert : '.$mysqli->error); 
				// cek query
				if ($insert) {
					// jika berhasil tampilkan pesan berhasil simpan data
					echo "sukses";
				} else {
					// jika gagal tampilkan pesan gagal simpan data
					echo $mysqli->error;
					//echo "gagal";
				}
				// tutup koneksi
				$mysqli->close();

			
			break;
	}
} else {
    echo '<script>window.location="../index.php"</script>';
}
?>