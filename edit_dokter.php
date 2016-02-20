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
  $updateSQL = sprintf("UPDATE dokter SET kode_poli=%s, nama_dokter=%s, alamat_dokter=%s, telpn_dokter=%s WHERE kode_dokter=%s",
                       GetSQLValueString($_POST['kode_poli'], "text"),
                       GetSQLValueString($_POST['nama_dokter'], "text"),
                       GetSQLValueString($_POST['alamat_dokter'], "text"),
                       GetSQLValueString($_POST['telpn_dokter'], "text"),
                       GetSQLValueString($_POST['kode_dokter'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "dokter.php?kode_dokter=" . $row_edit_dokter['kode_dokter'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
//  header(sprintf("Location: %s", $updateGoTo));
?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=Dokter'  
  </script> <?php
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE dokter SET kode_poli=%s, nama_dokter=%s, alamat_dokter=%s, telpn_dokter=%s WHERE kode_dokter=%s",
                       GetSQLValueString($_POST['kode_poli'], "text"),
                       GetSQLValueString($_POST['nama_dokter'], "text"),
                       GetSQLValueString($_POST['alamat_dokter'], "text"),
                       GetSQLValueString($_POST['telpn_dokter'], "text"),
                       GetSQLValueString($_POST['kode_dokter'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "edit_dokter.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE dokter SET kode_poli=%s, nama_dokter=%s, alamat_dokter=%s, telpn_dokter=%s WHERE kode_dokter=%s",
                       GetSQLValueString($_POST['kode_poli'], "text"),
                       GetSQLValueString($_POST['nama_dokter'], "text"),
                       GetSQLValueString($_POST['alamat_dokter'], "text"),
                       GetSQLValueString($_POST['telpn_dokter'], "text"),
                       GetSQLValueString($_POST['kode_dokter'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "dokter.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_edit_dokter = "-1";
if (isset($_GET['kode_dokter'])) {
  $colname_edit_dokter = $_GET['kode_dokter'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_dokter = sprintf("SELECT * FROM dokter WHERE kode_dokter = %s", GetSQLValueString($colname_edit_dokter, "text"));
$edit_dokter = mysql_query($query_edit_dokter, $koneksi) or die(mysql_error());
$row_edit_dokter = mysql_fetch_assoc($edit_dokter);
$totalRows_edit_dokter = mysql_num_rows($edit_dokter);

mysql_select_db($database_koneksi, $koneksi);
$query_edit_poli = "SELECT * FROM poli_klinik";
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode dokter:</div></td>
      <td><div align="left"><?php echo $row_edit_dokter['kode_dokter']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode poli:</div></td>
      <td><div align="left">
        <select name="kode_poli">
          <?php 
do {  
?>
          <option value="<?php echo $row_edit_poli['kode_poli']?>" <?php if (!(strcmp($row_edit_poli['kode_poli'], htmlentities($row_edit_dokter['kode_poli'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_edit_poli['nama_poli']?></option>
          <?php
} while ($row_edit_poli = mysql_fetch_assoc($edit_poli));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama dokter:</div></td>
      <td><div align="left">
        <input type="text" name="nama_dokter" value="<?php echo htmlentities($row_edit_dokter['nama_dokter'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Alamat dokter:</div></td>
      <td><div align="left">
        <textarea name="alamat_dokter" cols="50" rows="5"><?php echo htmlentities($row_edit_dokter['alamat_dokter'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Telpn_dokter:</div></td>
      <td><div align="left">
        <input type="text" name="telpn_dokter" value="<?php echo htmlentities($row_edit_dokter['telpn_dokter'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
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
  <input type="hidden" name="kode_dokter" value="<?php echo $row_edit_dokter['kode_dokter']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_dokter);

mysql_free_result($edit_poli);
?>