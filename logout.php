<?php
//lanjutkan session yang sudah dibuat sebelumnya
session_start();

//hapus session yang sudah dibuat

$_SESSION['username']=NULL;
$_SESSION['tipe_user']=NULL;
session_destroy();

//redirect ke halaman login
header('location:login_poliklinik.php');
?>