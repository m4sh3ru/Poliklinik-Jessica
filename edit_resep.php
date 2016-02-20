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
  $updateSQL = sprintf("UPDATE resep SET no_pemeriksaan=%s, kode_obat=%s, dosis=%s, jumlah=%s WHERE no_resep=%s",
                       GetSQLValueString($_POST['no_pemeriksaan'], "text"),
                       GetSQLValueString($_POST['kode_obat'], "text"),
                       GetSQLValueString($_POST['dosis'], "text"),
                       GetSQLValueString($_POST['jumlah'], "double"),
                       GetSQLValueString($_POST['no_resep'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "resep.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $updateGoTo));
  ?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=resep'  
  </script> <?php
}

$colname_edit_resep = "-1";
if (isset($_GET['no_resep'])) {
  $colname_edit_resep = $_GET['no_resep'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_resep = sprintf("SELECT * FROM resep WHERE no_resep = %s", GetSQLValueString($colname_edit_resep, "text"));
$edit_resep = mysql_query($query_edit_resep, $koneksi) or die(mysql_error());
$row_edit_resep = mysql_fetch_assoc($edit_resep);
$totalRows_edit_resep = mysql_num_rows($edit_resep);

mysql_select_db($database_koneksi, $koneksi);
$query_edit_pemeriksaan = "SELECT * FROM pemeriksaan";
$edit_pemeriksaan = mysql_query($query_edit_pemeriksaan, $koneksi) or die(mysql_error());
$row_edit_pemeriksaan = mysql_fetch_assoc($edit_pemeriksaan);
$totalRows_edit_pemeriksaan = mysql_num_rows($edit_pemeriksaan);

mysql_select_db($database_koneksi, $koneksi);
$query_edit_obat = "SELECT * FROM obat";
$edit_obat = mysql_query($query_edit_obat, $koneksi) or die(mysql_error());
$row_edit_obat = mysql_fetch_assoc($edit_obat);
$totalRows_edit_obat = mysql_num_rows($edit_obat);
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No_resep:</div></td>
      <td><div align="left"><?php echo $row_edit_resep['no_resep']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No_pemeriksaan:</div></td>
      <td><div align="left">
        <select name="no_pemeriksaan">
          <?php 
do {  
?>
          <option value="<?php echo $row_edit_pemeriksaan['no_pemeriksaan']?>" <?php if (!(strcmp($row_edit_pemeriksaan['no_pemeriksaan'], htmlentities($row_edit_resep['no_pemeriksaan'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_edit_pemeriksaan['no_pemeriksaan']?></option>
          <?php
} while ($row_edit_pemeriksaan = mysql_fetch_assoc($edit_pemeriksaan));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode_obat:</div></td>
      <td><div align="left">
        <select name="kode_obat">
          <?php 
do {  
?>
          <option value="<?php echo $row_edit_obat['kode_obat']?>" <?php if (!(strcmp($row_edit_obat['kode_obat'], htmlentities($row_edit_resep['kode_obat'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_edit_obat['nama_obat']?></option>
          <?php
} while ($row_edit_obat = mysql_fetch_assoc($edit_obat));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Dosis:</div></td>
      <td><div align="left">
        <input type="text" name="dosis" value="<?php echo htmlentities($row_edit_resep['dosis'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jumlah:</div></td>
      <td><div align="left">
        <input type="text" name="jumlah" value="<?php echo htmlentities($row_edit_resep['jumlah'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Ubah Data" class="button round blue image-right ic-edit text-upper"/>
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="no_resep" value="<?php echo $row_edit_resep['no_resep']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_resep);

mysql_free_result($edit_pemeriksaan);

mysql_free_result($edit_obat);
?>
