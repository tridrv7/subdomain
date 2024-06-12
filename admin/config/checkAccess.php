<?PHP
//$SERVER = 'HTTP://'.$_SERVER['SERVER_NAME'].'/jdhn/';

session_start();

//$_SESSION['usNip']='555'; //temporary
if(empty($_SESSION['usNip'])) {
	//echo '<script>window.location = "'.$_SERVER['SERVER_NAME'].'";</script>';
	//echo "header('Location: $servLogs')";
	//header('Location: $servLogs');
	//echo header('Location:'.$_SERVER['HTTP_HOST']);
	echo '<meta content="0; url=http://'.$_SERVER['SERVER_NAME'].'/admin" http-equiv="refresh">';
}
/*START SESSION TIMEOUT*/
$time = $_SERVER['REQUEST_TIME'];

/* for a 30 minute timeout, specified in seconds*/
$timeout_duration = 1800;

/* Here we look for the user's LAST_ACTIVITY timestamp. If
* it's set and indicates our $timeout_duration has passed,
* blow away any previous $_SESSION data and start a new one.*/
if (isset($_SESSION['LAST_ACTIVITY']) && 
   ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    session_start();
}

/* Finally, update LAST_ACTIVITY so that our timeout
* is based on it and not the user's login time.*/
$_SESSION['LAST_ACTIVITY'] = $time;
/*END SESSION TIMEOUT*/
?>