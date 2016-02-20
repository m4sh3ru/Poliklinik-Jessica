<?php require_once('Connections/koneksi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jadwal_praktek (kode_jadwal, kode_dokter, hari, jam_mulai, jam_selesai) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_jadwal'], "text"),
                       GetSQLValueString($_POST['kode_dokter'], "text"),
                       GetSQLValueString($_POST['hari'], "text"),
                       GetSQLValueString($_POST['jam_mulai'], "date"),
                       GetSQLValueString($_POST['jam_selesai'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "jadwal_praktek.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $insertGoTo));
 ?><script language="javascript">document.location.href='?page=jadwal_praktek'</script> <?php
}

$maxRows_jadwal = 10;
$pageNum_jadwal = 0;
if (isset($_GET['pageNum_jadwal'])) {
  $pageNum_jadwal = $_GET['pageNum_jadwal'];
}
$startRow_jadwal = $pageNum_jadwal * $maxRows_jadwal;

mysql_select_db($database_koneksi, $koneksi);
$query_jadwal = "SELECT jadwal_praktek.kode_jadwal, dokter.nama_dokter, jadwal_praktek.hari, jadwal_praktek.jam_mulai, jadwal_praktek.jam_selesai FROM jadwal_praktek, dokter WHERE jadwal_praktek.kode_dokter=dokter.kode_dokter";
$query_limit_jadwal = sprintf("%s LIMIT %d, %d", $query_jadwal, $startRow_jadwal, $maxRows_jadwal);
$jadwal = mysql_query($query_limit_jadwal, $koneksi) or die(mysql_error());
$row_jadwal = mysql_fetch_assoc($jadwal);

if (isset($_GET['totalRows_jadwal'])) {
  $totalRows_jadwal = $_GET['totalRows_jadwal'];
} else {
  $all_jadwal = mysql_query($query_jadwal);
  $totalRows_jadwal = mysql_num_rows($all_jadwal);
}
$totalPages_jadwal = ceil($totalRows_jadwal/$maxRows_jadwal)-1;

//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM jadwal_praktek";
$kode_jadwal=mysql_query($qry) or die(mysql_error());
$row_kode_jadwal=mysql_fetch_assoc($kode_jadwal);
$urutan=$row_kode_jadwal['tambah']+1;

mysql_select_db($database_koneksi, $koneksi);
$query_dokter = "SELECT * FROM dokter";
$dokter = mysql_query($query_dokter, $koneksi) or die(mysql_error());
$row_dokter = mysql_fetch_assoc($dokter);
$totalRows_dokter = mysql_num_rows($dokter);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>jadwal praktek</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode jadwal:</div></td>
      <td valign="top"><div align="left">
        <input type="text" name="kode_jadwal" value="<?php echo "JDWL-00".$urutan; ?>" size="15" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode dokter:</div></td>
      <td valign="top"><div align="left">
        <select name="kode_dokter">
          <?php 
do {  
?>
          <option value="<?php echo $row_dokter['kode_dokter']?>" ><?php echo $row_dokter['nama_dokter']?></option>
          <?php
} while ($row_dokter = mysql_fetch_assoc($dokter));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Hari:</div></td>
      <td valign="top"><div align="left">
        <input type="text" name="hari" value="" size="15" class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jam mulai:</div></td>
      <td valign="top"><div align="left">
        <input type="text" name="jam_mulai" value="" size="15" placeholder="00:00:00" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jam selesai:</div></td>
      <td valign="top"><div align="left">
        <input type="text" name="jam_selesai" value="" size="15" placeholder="00:00:00" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td valign="top"><div align="left">
        <input name="Submit" type="submit" value="Simpan" class="round blue ic-right-arrow" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;  </p>
  <hr />
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
    </p>

  <table border="1">
    <tr>
      <td bgcolor="#333333"><div align="center" class="style1">Kode jadwal</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Kode dokter</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Hari</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Jam mulai</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Jam selesai</div></td>
      <td colspan="2" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_jadwal['kode_jadwal']; ?></div></td>
        <td><div align="center"><?php echo $row_jadwal['nama_dokter']; ?></div></td>
        <td><div align="center"><?php echo $row_jadwal['hari']; ?></div></td>
        <td><div align="center"><?php echo $row_jadwal['jam_mulai']; ?></div></td>
        <td><div align="center"><?php echo $row_jadwal['jam_selesai']; ?></div></td>
        <td><a href="?page=edit_jadwal&kode_jadwal=<?php echo $row_jadwal['kode_jadwal']; ?>" class="button round blue image-right ic-edit text-upper">Edit </a></td>
        <td><a href="?page=del_jdwl&kode_jadwal=<?php echo $row_jadwal['kode_jadwal']; ?>" class="button round blue image-right ic-delete text-upper" onclick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
      </tr>
      <?php } while ($row_jadwal = mysql_fetch_assoc($jadwal)); ?>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($jadwal);

mysql_free_result($dokter);
?>
