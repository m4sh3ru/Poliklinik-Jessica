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
  $updateSQL = sprintf("UPDATE pasien SET nama_pas=%s, alamat_pas=%s, tlp_pas=%s, tgl_lhr=%s, jenis_kel=%s, tgl_registrasi=%s WHERE no_pas=%s",
                       GetSQLValueString($_POST['nama_pas'], "text"),
                       GetSQLValueString($_POST['alamat_pas'], "text"),
                       GetSQLValueString($_POST['tlp_pas'], "text"),
                       GetSQLValueString($_POST['tgl_lhr'], "date"),
                       GetSQLValueString($_POST['jenis_kel'], "text"),
                       GetSQLValueString($_POST['tgl_registrasi'], "date"),
                       GetSQLValueString($_POST['no_pas'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "pasien.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $updateGoTo));
 ?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=pasien'  
  </script> <?php
}

$colname_edit_pas = "-1";
if (isset($_GET['no_pas'])) {
  $colname_edit_pas = $_GET['no_pas'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_pas = sprintf("SELECT * FROM pasien WHERE no_pas = %s", GetSQLValueString($colname_edit_pas, "text"));
$edit_pas = mysql_query($query_edit_pas, $koneksi) or die(mysql_error());
$row_edit_pas = mysql_fetch_assoc($edit_pas);
$totalRows_edit_pas = mysql_num_rows($edit_pas);
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pasien:</div></td>
      <td><div align="left"><?php echo $row_edit_pas['no_pas']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama pasien:</div></td>
      <td><div align="left">
        <input type="text" name="nama_pas" value="<?php echo htmlentities($row_edit_pas['nama_pas'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Alamat pasien:</div></td>
      <td><div align="left">
        <textarea name="alamat_pas" cols="50" rows="5"><?php echo htmlentities($row_edit_pas['alamat_pas'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tlp pasien:</div></td>
      <td><div align="left">
        <input type="text" name="tlp_pas" value="<?php echo htmlentities($row_edit_pas['tlp_pas'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tgl lahir:</div></td>
      <td><div align="left">
        <input type="text" name="tgl_lhr" value="<?php echo htmlentities($row_edit_pas['tgl_lhr'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jenis kelamin:</div></td>
      <td valign="baseline"><div align="left">
        <input type="radio" name="jenis_kel" value="L" <?php if (!(strcmp(htmlentities($row_edit_pas['jenis_kel'], ENT_COMPAT, 'utf-8'),"L"))) {echo "CHECKED";} ?> />
Laki-laki
<input type="radio" name="jenis_kel" value="P" <?php if (!(strcmp(htmlentities($row_edit_pas['jenis_kel'], ENT_COMPAT, 'utf-8'),"P"))) {echo "CHECKED";} ?> />
Perempuan</div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tgl registrasi:</div></td>
      <td><div align="left">
        <input type="text" name="tgl_registrasi" value="<?php echo htmlentities($row_edit_pas['tgl_registrasi'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
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
  <input type="hidden" name="no_pas" value="<?php echo $row_edit_pas['no_pas']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_pas);
?>
