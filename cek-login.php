<?php include('Connections/koneksi.php'); ?>
<?php
session_start();
if (isset($_POST['user'])) {
$username = $_POST['user']; // variablenya = username, dan nilainya sesuai yang dimasukkan di input name=”username” tadi
$password = md5($_POST['pass']); // variable password, dan nilainya sesuai yang dimasukkan di input name=”password” tadi
// md5 ada sebuah fungsi PHP untuk engkripsi. misalnya admin jadi 21232f297a57a5a743894a0e4a801fc3. untuk lengkapnya, silahkan googling tentang md5


// proses untuk login

// menyesuaikan dengan data di database
$perintah = "select * from login WHERE user = '$username' AND pass = '$password'";
$hasil = mysql_query($perintah);
$row = mysql_fetch_array($hasil);
if ($row['user'] == $username AND $row['pass'] == $password) {
session_start(); // memulai fungsi session
$_SESSION['user'] = $username;
$_SESSION['tipe_user'] = $row['tipe_user'];

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=dashboard.php">';
exit;

// header("location:dashboard.php"); // jika berhasil login, maka masuk ke file home.php
}
else {
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login_poliklinik.php">';
exit;
#header("location:login_poliklinik.php"); // jika gagal, maka muncul teks gagal masuk
}

}
?>