<?php
date_default_timezone_set("ASIA/JAKARTA");
$con = array(
    'user' => 'root',
    'pass' => '@D.p@ssw0rd',
    'db'   => 'sites_db_fiks_new',
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

//$serverHost = $_SERVER['DOCUMENT_ROOT'];
$SERVER = $_SERVER['SERVER_NAME'];
$servAdmin = $SERVER.'/admin/default.php';
$servLogs = $SERVER;
$servRoot = $_SERVER['DOCUMENT_ROOT'];

$errorPages = '<script>window.location="'.$SERVER.'/404.php"</script>';

//setting dir
$_dirPost	= '../images/post/'; //POST
$_dirEmp	= '../images/employees/'; //EMP
$_dirLHKPN	= '../images/lhkpn/'; //LHKPN
$_dirKategori = '../images/kategori/'; //KATEGORY
$_dirGalery = '../images/galery/'; //GALERY & BANNER
$_dirFiles = '../images/files/';//FILES PENGUMUMAN
$_dirProf = '../images/profile/';//PROFIL
$_dirLink	= '../images/socials/'; //SOSMED
$_dirServices	= '../images/services/'; //SERVICES

$resizeWPost = '1920';
$resizeHPost = '1080';
$resizeOPost = 'exact';// *** 2) Resize image (options: exact, height, width, auto, crop)

$resizeWEmp = '600';
$resizeHEmp = '800';
$resizeOEmp = 'exact';// *** 2) Resize image (options: exact, height, width, auto, crop)

$resizeWLink = '500';
$resizeHLink = '500';
$resizeOLink = 'auto';// *** 2) Resize image (options: exact, height, width, auto, crop)
?>

