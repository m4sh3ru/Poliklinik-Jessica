<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_koneksi = "localhost";
$database_koneksi = "poliklinik";
$username_koneksi = "admin";
$password_koneksi = "1234";
$koneksi = mysql_pconnect($hostname_koneksi, $username_koneksi, $password_koneksi) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_koneksi) or die('Database Tidak ditemukan');
?>
