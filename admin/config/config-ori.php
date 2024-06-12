<?php
// set default timezone
date_default_timezone_set("ASIA/JAKARTA");

// panggil file parameter koneksi database
$con = array(
    'user' => 'root',
    'pass' => '@D.p@ssw0rd',
    'db'   => 'dbnewsidoarjo',
    'host' => 'localhost'
);

// koneksi database
$mysqli = new mysqli($con['host'], $con['user'], $con['pass'], $con['db']);

// cek koneksi
if ($mysqli->connect_error) {
    die('Koneksi Database Gagal : '.$mysqli->connect_error);
}


//variable pendukung
$dateY = date('Y');
$dateYM = date('Ym');
$dateYMD = date('Ymd');
$serverHost = $_SERVER['DOCUMENT_ROOT'];
$SERVER = $_SERVER['SERVER_NAME'];
$servAdmin = $SERVER.'/admini/default.php';
$servLogs = $SERVER;

$dirBanner = $SERVER."/upload/banner/";
$dirTeam = $SERVER."/upload/team/";

$errorPages = '<script>window.location="'.$SERVER.'/404.php"</script>';
?>
