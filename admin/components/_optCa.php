<?php
require '../../conf/config.php';

$mn_jlink 	= isset($_REQUEST['mn_jlink']) ? strval($_REQUEST['mn_jlink']) : '001';
$search_term= isset($_REQUEST['search']) ? strval($_REQUEST['search']) : '';

$result = $mysqli->query("SELECT post_id, post_judul
								FROM pub_post 
							WHERE ca_id='$mn_jlink' AND post_judul LIKE '%".$search_term."%'
							ORDER BY post_publish")
						  or die('Ada kesalahan pada query tampil data transaksi: '.$mysqli->error);
$usersData = array();
while($row = $result->fetch_assoc()) { 
	$data['id'] = $row['post_id'];
	$data['text'] = $row['post_judul'];
	array_push($usersData, $data);
	//$varOpt .= "<option value='".$row['post_id']."'>".$row['post_judul']."</option>"; // Tambahkan tag option ke variabel $html
}

//$call = array('dataLink'=>$varOpt);
echo json_encode($usersData);

?>
