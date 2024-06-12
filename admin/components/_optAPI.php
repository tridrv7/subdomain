<?php
require '../../conf/config.php';

//$mn_jlink 	= isset($_REQUEST['mn_jlink']) ? strval($_REQUEST['mn_jlink']) : '004';
$search_term= isset($_REQUEST['search']) ? strval($_REQUEST['search']) : '';

$result = $mysqli->query("SELECT sos_id, sos_nm
								FROM pub_socials 
							WHERE cat='004' AND sos_nm LIKE '%".$search_term."%'
							ORDER BY sos_id")
						  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
$usersData = array();
while($row = $result->fetch_assoc()) { 
	$data['id'] = $row['sos_id'];
	$data['text'] = $row['sos_nm'];
	array_push($usersData, $data);
	//$varOpt .= "<option value='".$row['post_id']."'>".$row['post_judul']."</option>"; // Tambahkan tag option ke variabel $html
}

//$call = array('dataLink'=>$varOpt);
echo json_encode($usersData);

?>
