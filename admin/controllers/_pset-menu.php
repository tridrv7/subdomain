<?php
require '../config/checkAccess.php';
require '../../conf/config.php';
require '../../conf/phpFunction.php';

if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

//SELECT mn_id, mn_txt, mn_url, mn_tar, parent, _active, _cre, _cre_date, _chg, _chg_date FROM set_menu WHERE 1

	
	switch($_REQUEST['_act']){
		case 1:
				/*
				$result = $mysqli->query("SELECT mn_id FROM set_menu")
									or die('Ada kesalahan pada query tampil data id_transaksi: '.$mysqli->error);
				$rows = $result->num_rows;
				*/
				$countRec = loadRecText('count(mn_id)', 'set_menu', '1');

				$mn_id	= str_pad($countRec+1, 3, "0", STR_PAD_LEFT);
				$parent	= isset($_REQUEST['parent']) ? strval($_REQUEST['parent']) : '0';
				$mn_txt	= isset($_REQUEST['mn_txt']) ? strval($_REQUEST['mn_txt']) : '';
					$mn_txt	= ucwords($mn_txt);
				$mn_jlink = isset($_REQUEST['mn_jlink']) ? strval($_REQUEST['mn_jlink']) : '';
				$mn_link = isset($_REQUEST['mn_link']) ? strval($_REQUEST['mn_link']) : '';

				if($_REQUEST['mn_jlink']==='999'){
					$mn_url = isset($_REQUEST['mn_ext']) ? strval($_REQUEST['mn_ext']) : '';
					$mn_tar	= isset($_REQUEST['mn_tar']) ? strval($_REQUEST['mn_tar']) : '';
				} else if(($_REQUEST['mn_jlink']==='000') || ($_REQUEST['mn_jlink']==='')){
					$mn_url = '';
					$mn_tar	= '';
				} else {
					$mn_url = $mn_jlink.'/'.$mn_link;
					$mn_tar	= '';
				}
			
				$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
				$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
				$_chg = $_cre;
			
				// perintah query untuk menyimpan data ke tabel transaksi
				$insert = $mysqli->query("INSERT INTO set_menu(mn_id, mn_txt, mn_url, mn_tar, parent, _active, _cre, _cre_date, _chg, _chg_date) 
											VALUES('$mn_id','$mn_txt','$mn_url','$mn_tar','$parent','$_active','$_cre', SYSDATE(),'$_chg',SYSDATE())")
										  or die('Ada kesalahan pada query insert : '.$mysqli->error);
				
				/*
				// cek query
				if ($insert) {
					// jika berhasil tampilkan pesan berhasil simpan data
					return "1";
				} else {
					// jika gagal tampilkan pesan gagal simpan data
					echo $mysqli->error;
				}
				*/
				echo $mysqli->error;
				// tutup koneksi
				$mysqli->close();   
			
			break;
		case 2:
			
				if (isset($_REQUEST['mn_id'])) {
					
					// ambil data hasil post dari ajax
					$mn_id	= isset($_REQUEST['mn_id']) ? strval($_REQUEST['mn_id']) : '';
					$parent	= isset($_REQUEST['parent']) ? strval($_REQUEST['parent']) : '0';
					$mn_txt	= isset($_REQUEST['mn_txt']) ? strval($_REQUEST['mn_txt']) : '';
						$mn_txt	= ucwords($mn_txt);
					$mn_jlink = isset($_REQUEST['mn_jlink']) ? strval($_REQUEST['mn_jlink']) : '';
					$mn_link = isset($_REQUEST['mn_link']) ? strval($_REQUEST['mn_link']) : '';
					$mn_tar	= isset($_REQUEST['mn_tar']) ? strval($_REQUEST['mn_tar']) : '';

					if($mn_jlink==='999'){
						$mn_url = isset($_REQUEST['mn_ext']) ? strval($_REQUEST['mn_ext']) : '';
						$mn_tar	= isset($_REQUEST['mn_tar']) ? strval($_REQUEST['mn_tar']) : '';
                        $mn_urlx = "mn_url='".$mn_url."',";
					} else if(($mn_jlink==='000') || ($mn_jlink==='')){
						$mn_url = '';
						$mn_tar	= '';
                        $mn_urlx = "mn_url='".$mn_url."',";
					} else if($mn_link===''){
						$mn_url = $mn_jlink.'/'.$mn_link;
						$mn_tar	= '';
						$mn_urlx = '';
					} else {
						$mn_url = $mn_jlink.'/'.$mn_link;
						$mn_tar	= '';
                        $mn_urlx = "mn_url='".$mn_url."',";
					}

					$_active = isset($_REQUEST['_active']) ? strval($_REQUEST['_active']) : '1';
					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					//SELECT mn_id, parent, mn_text, mn_link, mn_target, _active, _cre, _cre_date, _chg, _chg_date FROM set_menu
					$update = $mysqli->query("UPDATE set_menu SET mn_txt='$mn_txt', 
																		$mn_urlx 
																		mn_tar='$mn_tar', 
																		_chg='$_chg', 
																		_chg_date=SYSDATE()
													WHERE mn_id='$mn_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					// cek query
					/*
					if ($update) {
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
			
				if (isset($_REQUEST['mn_id'])) {
					// ambil data hasil post dari ajax
					$mn_id = $_REQUEST['mn_id'];
					$_active = $_REQUEST['_active'];

					$_cre = isset($_REQUEST['_cre']) ? strval($_REQUEST['_cre']) : $_SESSION['usNip'];
					$_chg = $_cre;

					// perintah query untuk mengubah data pada tabel transaksi
					$update = $mysqli->query("UPDATE set_menu SET _active='$_active',
																_chg='$_chg', 
																_chg_date=SYSDATE()
											WHERE mn_id='$mn_id'")
											  or die('Ada kesalahan pada query update : '.$mysqli->error);
					
					// cek query
					/*
					if ($update) {
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
			
				if (isset($_REQUEST['mn_id'])) {
					// ambil data get dari ajax
					$mn_id = htmlentities($_REQUEST['mn_id']);
					// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
					$result = $mysqli->query("SELECT mn_id, mn_txt, mn_url, mn_tar, parent
													FROM set_menu
												WHERE _active=1 AND mn_id='$mn_id'")
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
			
			
			//SELECT mn_id, parent, mn_text, item_link, mn_target, _active, _cre, _cre_date, _chg, _chg_date FROM set_menu WHERE 1
				// perintah query untuk menampilkan data dari tabel transaksi berdasarkan id_transaksi
				$result = $mysqli->query("SELECT mn_id, mn_txt, mn_url, mn_tar, parent
												FROM set_menu 
											WHERE _active=1 
											ORDER BY parent, mn_id")
										  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
			

					if($result->num_rows!=0){
						
						while( $row = $result->fetch_assoc() ) { 
							$data[] = $row;
						}
						
						$itemsByReference = array();
						
						// Build array of item references:
						foreach($data as $key => &$item) {
							$itemsByReference[$item['mn_id']] = &$item;
						}
						
						// Set items as children of the relevant parent item.
						foreach($data as $key => &$item)  {    
							if($item['parent'] && isset($itemsByReference[$item['parent']])) {
								$itemsByReference [$item['parent']]['children'][] = &$item;
							}
						}
						// Remove items that were added to parents elsewhere:
						foreach($data as $key => &$item) {
						   if($item['parent'] && isset($itemsByReference[$item['parent']]))
							  unset($data[$key]);
						}
						// Encode:
						$output = array(
							"draw"				=> "0",
							"recordsTotal"		=> "0",
							"recordsFiltered"	=> "0",
							"data"				=> $data,
							"error"				=> null
						);
						
						echo json_encode($output);
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