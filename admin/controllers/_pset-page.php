<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

	switch($_REQUEST['_act']){
		case 1:
			
				$ro_n = isset($_REQUEST['page_name']) ? strval($_REQUEST['page_name']) : '';
				$page_name = ucwords($ro_n);
				$page_addr = isset($_REQUEST['page_addr']) ? strval($_REQUEST['page_addr']) : '';

				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				// fungsi untuk membuat id transaksi
				$result = $mysqli->query("SELECT page_id FROM set_page")
									or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
				$rows = $result->num_rows;

				//$rows = $result->fetch_assoc;
				$page_id = str_pad($rows+1, 3, "0", STR_PAD_LEFT);

				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO set_page(page_id, page_name, page_addr, _active, _cre, _cre_date, _chg, _chg_date) 
									VALUES('$page_id','$page_name','$page_addr','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
			
				if (isset($_REQUEST['page_id'])) {
					// ambil data hasil post dari ajax
					$page_id     = isset($_REQUEST['page_id']) ? strval($_REQUEST['page_id']) : '';
					$ro_n = isset($_REQUEST['page_name']) ? strval($_REQUEST['page_name']) : '';
					$page_name = ucwords($ro_n);
					$page_addr = isset($_REQUEST['page_addr']) ? strval($_REQUEST['page_addr']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_page SET page_name='$page_name', page_addr='$page_addr', _chg='$_chg', _chg_date=SYSDATE()
										WHERE page_id='$page_id'")
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
			
				if (isset($_REQUEST['page_id'])) {
					// ambil data hasil post dari ajax
					$page_id     = isset($_REQUEST['page_id']) ? strval($_REQUEST['page_id']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '0';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_page SET _active='0', _chg='$_chg', _chg_date=SYSDATE()
										WHERE page_id='$page_id'")
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
			
				if (isset($_REQUEST['page_id'])) {
					// ambil data get dari ajax
					$page_id = $_REQUEST['page_id'];
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT page_id, page_name, page_addr, _active, _cre, _cre_date, _chg, _chg_date 
                                                FROM set_page 
											WHERE _active=1 AND page_id='$page_id'")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
					$data = $result->fetch_assoc();
				}
				// tutup koneksi
				$mysqli->close(); 

				echo json_encode($data); 			
			
			break;
		case 5:
			
				//SELECT page_id, page_name, _active, _cre, _cre_date, _chg, _chg_date FROM set_page WHERE _active=1 
				// nama table
				$table = 'set_page';
				// Table's primary key
				$primaryKey = 'page_id';

				$columns = array(
					array( 'db' => 'page_id', 'dt' => 0 ),
					array( 'db' => 'page_name', 'dt' => 1 ),
					array( 'db' => 'page_addr', 'dt' => 2 ),
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
				
				$where ="_active='1'";

				// ssp class
				require '../config/ssp.class.php';

				echo json_encode(
					//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
					SSP::complex( $_GET, $con, $table, $primaryKey, $columns, null, $where )
				);
			
			break;
	}
} else {
    echo '<script>window.location="../index.php"</script>';
}
?>