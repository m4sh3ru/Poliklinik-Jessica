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
  $updateSQL = sprintf("UPDATE poli_klinik SET nama_poli=%s WHERE kode_poli=%s",
                       GetSQLValueString($_POST['nama_poli'], "text"),
                       GetSQLValueString($_POST['kode_poli'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "poliklinik.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_poli = "-1";
if (isset($_GET['kode_poli'])) {
  $colname_edit_poli = $_GET['kode_poli'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_poli = sprintf("SELECT * FROM poli_klinik WHERE kode_poli = %s", GetSQLValueString($colname_edit_poli, "text"));
$edit_poli = mysql_query($query_edit_poli, $koneksi) or die(mysql_error());
$row_edit_poli = mysql_fetch_assoc($edit_poli);
$totalRows_edit_poli = mysql_num_rows($edit_poli);
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
      <td nowrap="nowrap" align="right"><div align="left">Kode poli:</div></td>
      <td><div align="left"><?php echo $row_edit_poli['kode_poli']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="left">Nama poli:</div></td>
      <td><div align="left">
        <input type="text" name="nama_poli" value="<?php echo htmlentities($row_edit_poli['nama_poli'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Ubah Data" class="button round blue image-right ic-edit text-upper"/>
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="kode_poli" value="<?php echo $row_edit_poli['kode_poli']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_poli);
?>
