<?PHP
session_start();
session_destroy();
require '../../conf/config.php';

//header('Location: http://'.$SERVER);

echo 'http://'.$servLogs;
exit;
?>