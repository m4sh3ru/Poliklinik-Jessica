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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE jadwal_praktek SET kode_dokter=%s, hari=%s, jam_mulai=%s, jam_selesai=%s WHERE kode_jadwal=%s",
                       GetSQLValueString($_POST['kode_dokter'], "text"),
                       GetSQLValueString($_POST['hari'], "text"),
                       GetSQLValueString($_POST['jam_mulai'], "date"),
                       GetSQLValueString($_POST['jam_selesai'], "date"),
                       GetSQLValueString($_POST['kode_jadwal'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "jadwal_praktek.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $updateGoTo));
  ?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=jadwal_praktek'  
  </script> <?php
}

$colname_jadwal = "-1";
if (isset($_GET['kode_jadwal'])) {
  $colname_jadwal = $_GET['kode_jadwal'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_jadwal = sprintf("SELECT * FROM jadwal_praktek WHERE kode_jadwal = %s", GetSQLValueString($colname_jadwal, "text"));
$jadwal = mysql_query($query_jadwal, $koneksi) or die(mysql_error());
$row_jadwal = mysql_fetch_assoc($jadwal);
$totalRows_jadwal = mysql_num_rows($jadwal);

mysql_select_db($database_koneksi, $koneksi);
$query_dokter = "SELECT * FROM dokter";
$dokter = mysql_query($query_dokter, $koneksi) or die(mysql_error());
$row_dokter = mysql_fetch_assoc($dokter);
$totalRows_dokter = mysql_num_rows($dokter);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode_jadwal:</div></td>
      <td><div align="left"><?php echo $row_jadwal['kode_jadwal']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode_dokter:</div></td>
      <td><div align="left">
        <select name="kode_dokter">
          <?php 
do {  
?>
          <option value="<?php echo $row_dokter['kode_dokter']?>" <?php if (!(strcmp($row_dokter['kode_dokter'], htmlentities($row_jadwal['kode_dokter'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_dokter['nama_dokter']?></option>
          <?php
} while ($row_dokter = mysql_fetch_assoc($dokter));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Hari:</div></td>
      <td><div align="left">
        <input type="text" name="hari" value="<?php echo htmlentities($row_jadwal['hari'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jam_mulai:</div></td>
      <td><div align="left">
        <input type="text" name="jam_mulai" value="<?php echo htmlentities($row_jadwal['jam_mulai'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jam_selesai:</div></td>
      <td><div align="left">
        <input type="text" name="jam_selesai" value="<?php echo htmlentities($row_jadwal['jam_selesai'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Ubah Data" 
class="button round blue image-right ic-edit text-upper"/>
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="kode_jadwal" value="<?php echo $row_jadwal['kode_jadwal']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($jadwal);

mysql_free_result($dokter);
?>
