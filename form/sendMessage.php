<?php 


require('../conf/config.php');
require('../conf/phpFunction.php');






$id = strtotime("now");
$nama = $_POST['nama'];
$email = $_POST['mail'];
$message = $_POST['message'];
$otp = rand(1000, 9999);

$query = "INSERT INTO pesan (idpesan, nama, email, pesan, otp) VALUES ('$id', '$nama', '$email', '$message', '$otp')";
$result = mysqli_query($mysqli, $query);

if ($result) {
    // Jika query berhasil dieksekusi
    sendOTP($email, $otp);
    session_start();
    $_SESSION['otp'] = $otp;
    exit();
} else {
    echo "Error: " . mysqli_error($mysqli);
}








?>