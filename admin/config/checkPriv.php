<?PHP 
//echo $_REQUEST['bread'].'-'.$_SESSION['usRole'];
if(!empty($_SESSION['usNip'])){
	
	$_f = privAcc($_REQUEST['bread'], $_SESSION['usRole']);
	
	//echo $_f['_num'];
	if($_f['_num']!=='0'){

		$_re = $_f['_re'];
		$_re = isset($_f['_re']) ? strval($_f['_re']) : '0';

		if($_re=='0'){
			//header("Location: 404.php");
			//header("location: 404.php",  true,  301 );  exit;
			echo "<script type='text/javascript'>$('#panel-1').load('views/404.php');</script>"; exit;
		} else {
			$_cr = isset($_f['_cr']) ? strval($_f['_cr']) : '0';
			$_up = isset($_f['_up']) ? strval($_f['_up']) : '0';
			$_de = isset($_f['_de']) ? strval($_f['_de']) : '0';

			if($_cr=='0'){
				$_cr_class = 'd-none';
			} else {
				$_cr_class = '';
			}

			if($_up=='0' && $_de=='0'){
				$_upde_class = 'd-none';
			} else {
				$_upde_class = '';
			}

			if($_up=='0'){
				$_up_class = 'd-none';
			} else {
				$_up_class = '';
			}

			if($_de=='0'){
				$_de_class = 'd-none';
			} else {
				$_de_class = '';
			}
		}

	} else {
			header("Location: 404.php");
	}
} else {
	echo '<meta content="0; url=http://'.$_SERVER['SERVER_NAME'].'/admin" http-equiv="refresh">';
}

?> 