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
  $updateSQL = sprintf("UPDATE obat SET nama_obat=%s, merk=%s, satuan=%s, harga_jual=%s WHERE kode_obat=%s",
                       GetSQLValueString($_POST['nama_obat'], "text"),
                       GetSQLValueString($_POST['merk'], "text"),
                       GetSQLValueString($_POST['satuan'], "text"),
                       GetSQLValueString($_POST['harga_jual'], "double"),
                       GetSQLValueString($_POST['kode_obat'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "obat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $updateGoTo));
  ?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=obat'  
  </script> <?php

}

$colname_edit_obat = "-1";
if (isset($_GET['kode_obat'])) {
  $colname_edit_obat = $_GET['kode_obat'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_obat = sprintf("SELECT * FROM obat WHERE kode_obat = %s", GetSQLValueString($colname_edit_obat, "text"));
$edit_obat = mysql_query($query_edit_obat, $koneksi) or die(mysql_error());
$row_edit_obat = mysql_fetch_assoc($edit_obat);
$totalRows_edit_obat = mysql_num_rows($edit_obat);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>edit obat</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode obat:</div></td>
      <td><div align="left"><?php echo $row_edit_obat['kode_obat']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama obat:</div></td>
      <td><div align="left">
        <input type="text" name="nama_obat" value="<?php echo htmlentities($row_edit_obat['nama_obat'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Merk:</div></td>
      <td><div align="left">
        <input type="text" name="merk" value="<?php echo htmlentities($row_edit_obat['merk'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Satuan:</div></td>
      <td><div align="left">
        <input type="text" name="satuan" value="<?php echo htmlentities($row_edit_obat['satuan'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Harga_jual:</div></td>
      <td><div align="left">
        <input type="text" name="harga_jual" value="<?php echo htmlentities($row_edit_obat['harga_jual'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Ubah Data" class="button round blue image-right ic-edit text-upper" />
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="kode_obat" value="<?php echo $row_edit_obat['kode_obat']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_obat);
?>
