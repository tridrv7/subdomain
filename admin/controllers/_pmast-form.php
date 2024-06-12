<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

	switch($_REQUEST['_act']){
		case 1:
				// fungsi untuk membuat id transaksi
				$result = $mysqli->query("SELECT fm_id FROM set_form")
									or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
				$rows = $result->num_rows;

				//$rows = $result->fetch_assoc;
				$fm_id = str_pad($rows+1, 3, "0", STR_PAD_LEFT);
				$fm_n = isset($_REQUEST['fm_name']) ? strval($_REQUEST['fm_name']) : '';
				$fm_name = ucwords($fm_n);
				$fm_file = isset($_REQUEST['fm_file']) ? strval($_REQUEST['fm_file']) : '';

				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : '555';
				$_chg = $_cre;
			

				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO set_form(fm_id, fm_name, fm_file, _active, _cre, _cre_date, _chg, _chg_date) 
									VALUES('$fm_id','$fm_name','$fm_file','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
			
				if (isset($_REQUEST['fm_id'])) {
					// ambil data hasil post dari ajax
					$fm_id     = isset($_REQUEST['fm_id']) ? strval($_REQUEST['fm_id']) : '';
					$fm_n = isset($_REQUEST['fm_name']) ? strval($_REQUEST['fm_name']) : '';
					$fm_name = ucwords($fm_n);
					$fm_file = isset($_REQUEST['fm_file']) ? strval($_REQUEST['fm_file']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : '555';
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_form SET fm_name='$fm_name', fm_file='$fm_file', _chg='$_chg', _chg_date=SYSDATE()
										WHERE fm_id='$fm_id'")
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
			
				if (isset($_REQUEST['fm_id'])) {
					// ambil data hasil post dari ajax
					$fm_id     = isset($_REQUEST['fm_id']) ? strval($_REQUEST['fm_id']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '0';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : '555';
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_form SET _active='0', _chg='$_chg', _chg_date=SYSDATE()
										WHERE fm_id='$fm_id'")
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
			
				if (isset($_GET['fm_id'])) {
					// ambil data get dari ajax
					$fm_id = $_GET['fm_id'];
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT fm_id, fm_name, fm_file, _active, _cre, _cre_date, _chg, _chg_date 
                                                FROM set_form 
											WHERE _active=1 AND fm_id='$fm_id'")
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

				echo json_encode($data); 			
			
			break;
		case 5:
			
				//SELECT fm_id, fm_name, fm_file, _active, _cre, _cre_date, _chg, _chg_date FROM set_form WHERE _active=1 
				// nama table
				$table = 'set_form';
				// Table's primary key
				$primaryKey = 'fm_id';

				$columns = array(
					array( 'db' => 'fm_id', 'dt' => 0 ),
					array( 'db' => 'fm_name', 'dt' => 1 ),
					array( 'db' => 'fm_file', 'dt' => 2 ),
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