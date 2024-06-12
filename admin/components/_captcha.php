<?php
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' )) {

	session_start();
	
	$captcha = "";
	$digit1 = rand(1, 9);
	$digit2 = rand(1, 9);
	$array = ["+", "-", "*"];
	$random = array_rand($array);

	switch($array[$random]){
		case "+":
			$_SESSION['captcha'] = $digit1." + ".$digit2;
			$_SESSION['keys'] = $digit1+$digit2;
			break;
		case "-":
			$_SESSION['captcha'] = $digit1." - ".$digit2;
			$_SESSION['keys'] = $digit1-$digit2;
			break;
		case "*":
			$_SESSION['captcha'] = $digit1." x ".$digit2;
			$_SESSION['keys'] = $digit1*$digit2;
			break;
	}

	echo $_SESSION['captcha']." = ";
} else {
	header('Location:'.$_SERVER['HTTP_HOST']);
}
?>