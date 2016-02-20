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
  $updateSQL = sprintf("UPDATE jenis_biaya SET nama_biaya=%s, tarif=%s WHERE id_jenisbiaya=%s",
                       GetSQLValueString($_POST['nama_biaya'], "text"),
                       GetSQLValueString($_POST['tarif'], "double"),
                       GetSQLValueString($_POST['id_jenisbiaya'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "jenis_biaya.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $updateGoTo));
  
 ?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=jenis_biaya'  
  </script> <?php
}

$colname_edit_biaya = "-1";
if (isset($_GET['id_jenisbiaya'])) {
  $colname_edit_biaya = $_GET['id_jenisbiaya'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_biaya = sprintf("SELECT * FROM jenis_biaya WHERE id_jenisbiaya = %s", GetSQLValueString($colname_edit_biaya, "text"));
$edit_biaya = mysql_query($query_edit_biaya, $koneksi) or die(mysql_error());
$row_edit_biaya = mysql_fetch_assoc($edit_biaya);
$totalRows_edit_biaya = mysql_num_rows($edit_biaya);
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Id jenisbiaya:</div></td>
      <td><div align="left"><?php echo $row_edit_biaya['id_jenisbiaya']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama biaya:</div></td>
      <td><div align="left">
        <input type="text" name="nama_biaya" value="<?php echo htmlentities($row_edit_biaya['nama_biaya'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tarif:</div></td>
      <td><div align="left">
        <input type="text" name="tarif" value="<?php echo htmlentities($row_edit_biaya['tarif'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Ubah Data" 
class="button round blue image-right ic-edit text-upper" />
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_jenisbiaya" value="<?php echo $row_edit_biaya['id_jenisbiaya']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_biaya);
?>