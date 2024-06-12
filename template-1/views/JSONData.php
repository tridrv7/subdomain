<?PHP
require('../../conf/config.php');

$loadField = isset($_REQUEST['lF']) ? strval($_REQUEST['lF']) : '';
$loadTbl = isset($_REQUEST['lT']) ? strval($_REQUEST['lT']) : '';
$loadWhere = isset($_REQUEST['lW']) ? strval($_REQUEST['lW']) : '';
$loadOrder = isset($_REQUEST['lO']) ? strval($_REQUEST['lO']) : '';
$limit = isset($_REQUEST['l']) ? strval($_REQUEST['l']) : '';

	$sql = "SELECT $loadField FROM $loadTbl";
	if(!empty($loadWhere)) { $sql.=" WHERE $loadWhere"; }
	if(!empty($loadOrder)){ $sql.=" ORDER BY $loadOrder"; }
	if(!empty($limit)){ $sql.=" LIMIT $limit"; }

	$rowLoad = '';
	$result = $GLOBALS['mysqli']->query($sql);
	$resArr = array();
	$arField = explode(", ",$loadField);

	if($result->num_rows!=0){
		while($row = $result->fetch_array()){
			//array_push($resArr, $row);
			foreach ($arField as $x) {
				$resArr[$x] = $row[$x];
			}
		}		
		
		echo json_encode($resArr);
	} else {
		echo json_encode(array('stats'=>404,'msgErrors'=>'Data tidak ditemukan'));
	}
	
	// tutup koneksi
	$mysqli->close(); 

?>