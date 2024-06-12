<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';
	
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

	switch($_REQUEST['_act']){
		case 1:
			
				$ro_n = isset($_REQUEST['ro_name']) ? strval($_REQUEST['ro_name']) : '';
				$ro_name = ucwords($ro_n);

				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				// fungsi untuk membuat id transaksi
				$result = $mysqli->query("SELECT ro_id FROM set_role")
									or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
				$rows = $result->num_rows;

				//$rows = $result->fetch_assoc;
				$ro_id = str_pad($rows+1, 3, "0", STR_PAD_LEFT);

				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO set_role(ro_id, ro_name, _active, _cre, _cre_date, _chg, _chg_date) 
									VALUES('$ro_id','$ro_name','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
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
			
				if (isset($_REQUEST['ro_id'])) {
					// ambil data hasil post dari ajax
					$ro_id     = isset($_REQUEST['ro_id']) ? strval($_REQUEST['ro_id']) : '';
					$ro_n = isset($_REQUEST['ro_name']) ? strval($_REQUEST['ro_name']) : '';
					$ro_name = ucwords($ro_n);

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_role SET ro_name='$ro_name', _chg='$_chg', _chg_date=SYSDATE()
										WHERE ro_id='$ro_id'")
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
			
				if (isset($_REQUEST['ro_id'])) {
					// ambil data hasil post dari ajax
					$ro_id     = isset($_REQUEST['ro_id']) ? strval($_REQUEST['ro_id']) : '';

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '0';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_role SET _active='0', _chg='$_chg', _chg_date=SYSDATE()
										WHERE ro_id='$ro_id'")
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
			
				if (isset($_GET['ro_id'])) {
					// ambil data get dari ajax
					$ro_id = $_GET['ro_id'];
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT ro_id, ro_name, _active, _cre, _cre_date, _chg, _chg_date 
                                                FROM set_role 
											WHERE _active=1 AND ro_id='$ro_id'")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
					$data = $result->fetch_assoc();
				}
				// tutup koneksi
				$mysqli->close(); 

				echo json_encode($data); 			
			
			break;
		case 5:
			
				//SELECT ro_id, ro_name, _active, _cre, _cre_date, _chg, _chg_date FROM set_role WHERE _active=1 
				// nama table
				$table = 'set_role';
				// Table's primary key
				$primaryKey = 'ro_id';

				$columns = array(
					array( 'db' => 'ro_id', 'dt' => 0 ),
					array( 'db' => 'ro_name', 'dt' => 1 ),
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
				
				$where ="_active='1'";

				// ssp class
				require '../config/ssp.class.php';

				echo json_encode(
					//SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
					SSP::complex( $_GET, $con, $table, $primaryKey, $columns, null, $where )
				);
			
			break;
        case 6:
				if (isset($_REQUEST['ro_id'])) {
					// ambil data get dari ajax
					$ro_id = $_REQUEST['ro_id'];
					$ro_name = loadRecText('ro_name', 'set_role', 'ro_id='.$ro_id);
                    
					/*
                    $head = '<input class="form-control" type="text" name="ro_id" id="ro_id" value="'.$ro_id.'">'
							.'<table id="_table" class="table table-bordered table-hover table-striped w-100">'
								.'<thead class="bg-primary-600">'
                                    .'<tr>'
                                        .'<th>Halaman</th>'
                                        .'<th>Read</th>'
                                        .'<th>Create</th>'
                                        .'<th>Update</th>'
                                        .'<th>Delete</th>'
                                    .'</tr>'
                                .'</thead>'
                                .'<tbody>';
                    
                    $foot =    '</tbody>'
                            .'</table>';
                    */
					
                    $cont = '';
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT a.page_id, a.page_name, b.ro_id, b.rr_read, b.rr_cre, b.rr_up, b.rr_del
                                                FROM set_page a
                                                    LEFT JOIN set_rules b
                                                        ON a.page_id = b.page_id AND b.ro_id=$ro_id
                                                WHERE a._active=1")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);

                	while ($row = $result->fetch_assoc()) {
                        $ru_name = $row['page_name'];
                        $ru_id = $ro_id.$row['page_id'];
                        
                        $allchecked = "$('.".$ru_id."').prop('checked', this.checked);";
                        if($row['rr_read']=='1') $ru_re = 'checked'; else $ru_re = '';
                        if($row['rr_cre']=='1') $ru_cr = 'checked'; else $ru_cr = '';
                        if($row['rr_up']=='1') $ru_up = 'checked'; else $ru_up = '';
                        if($row['rr_del']=='1') $ru_de = 'checked'; else $ru_de = '';

						$cont .= '<tr>'
                                    .'<td>'.$row['page_name'].'</td>'
                                    .'<td><div class="form-check text-center"><input class="form-check-input role_check" onclick="'.$allchecked.'" type="checkbox" value="1" name="re'.$ru_id.'" '.$ru_re.'></div></td>'
                                    .'<td><div class="form-check text-center"><input class="form-check-input role_check '.$ru_id.'" type="checkbox" value="1" name="cr'.$ru_id.'" '.$ru_cr.'></div></td>'
                                    .'<td><div class="form-check text-center"><input class="form-check-input role_check '.$ru_id.'" type="checkbox" value="1" name="up'.$ru_id.'" '.$ru_up.'></div></td>'
                                    .'<td><div class="form-check text-center"><input class="form-check-input role_check '.$ru_id.'" type="checkbox" value="1" name="de'.$ru_id.'" '.$ru_de.'></div></td>'
                                .'</tr>';
                    }
				}
				// tutup koneksi
				$mysqli->close();
                //echo $head.$cont.$foot; SELECT ro_id, ro_name FROM set_role
				echo json_encode(array('ro_id'=>$ro_id,'_tbRules'=>$cont,'ro_name'=>$ro_name));
				//echo json_encode($data);
            
            break;
        case 7:
				if (isset($_REQUEST['ro_id'])) {
					// ambil data get dari ajax
					$ro_id = $_REQUEST['ro_id'];
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;
                    $_active = '1';
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT page_id, page_name
                                                    FROM set_page
                                                WHERE _active=1")
											  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);

                	while ($row = $result->fetch_assoc()) {
                        $page_id = $row['page_id'];
                        $rr_r = 're'.$ro_id.$row['page_id'];
                            $rr_read = isset($_REQUEST[$rr_r]) ? 1 : 0;
                        $rr_c = 'cr'.$ro_id.$row['page_id'];
                            $rr_cre = isset($_REQUEST[$rr_c]) ? 1 : 0;
                        $rr_u = 'up'.$ro_id.$row['page_id'];
                            $rr_up = isset($_REQUEST[$rr_u]) ? 1 : 0;
                        $rr_d = 'de'.$ro_id.$row['page_id'];
                            $rr_del = isset($_REQUEST[$rr_d]) ? 1 : 0;
                        
                        $insert = $mysqli->query("INSERT INTO set_rules(ro_id, page_id, rr_read, rr_cre, rr_up, rr_del, _active, _cre, _cre_date, _chg, _chg_date)
                                                VALUES('$ro_id', '$page_id', '$rr_read', '$rr_cre', '$rr_up', '$rr_del', '$_active', '$_cre', SYSDATE(), '$_chg', SYSDATE())
                                        ON DUPLICATE KEY UPDATE
                                                rr_read='$rr_read', 
                                                rr_cre='$rr_cre', 
                                                rr_up='$rr_up', 
                                                rr_del='$rr_del', 
                                                _active='$_active', 
                                                _chg='$_chg', 
                                                _chg_date=SYSDATE()")
                                                  or die('Ada kesalahan pada query insert : '.$mysqli->error);
                        
                    }
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
	}

} else {
    echo '<script>window.location="../index.php"</script>';
}
?>