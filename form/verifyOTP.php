<?php 


require('../conf/config.php');
// require('../conf/config.php');


$key1 = $_POST['key1'];
$key2 = $_POST['key2'];
$key3 = $_POST['key3'];
$key4 = $_POST['key4'];

session_start();

$otp = $_SESSION['otp'];
$enterOTP = $key1. $key2 . $key3 . $key4;


if ($otp == $enterOTP) {
   $query = "UPDATE pesan SET status = 1 WHERE otp = '$otp'";
   $result = mysqli_query($mysqli, $query);

   if ($result) {
      echo json_encode(array("success" => true));
      session_destroy();
   }
} else {
   echo json_encode(array("success" => false));
}
?>