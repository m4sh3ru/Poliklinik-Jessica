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

$colname_pemeriksaan = "-1";
if (isset($_GET['no_pemeriksaan'])) {
  $colname_pemeriksaan = $_GET['no_pemeriksaan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_pemeriksaan = sprintf("SELECT * FROM pemeriksaan WHERE no_pemeriksaan = %s", GetSQLValueString($colname_pemeriksaan, "text"));
$pemeriksaan = mysql_query($query_pemeriksaan, $koneksi) or die(mysql_error());
$row_pemeriksaan = mysql_fetch_assoc($pemeriksaan);
$totalRows_pemeriksaan = mysql_num_rows($pemeriksaan);

mysql_select_db($database_koneksi, $koneksi);
$query_pasien = "SELECT * FROM pasien";
$pasien = mysql_query($query_pasien, $koneksi) or die(mysql_error());
$row_pasien = mysql_fetch_assoc($pasien);
$totalRows_pasien = mysql_num_rows($pasien);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pemeriksaan SET no_pas=%s, keluhan=%s, diagnosa=%s, perawatan=%s, tindakan=%s, berat_badan=%s, tensi_diastolik=%s, tensi_sistolik=%s WHERE no_pemeriksaan=%s",
                       GetSQLValueString($_POST['no_pas'], "text"),
                       GetSQLValueString($_POST['keluhan'], "text"),
                       GetSQLValueString($_POST['diagnosa'], "text"),
                       GetSQLValueString($_POST['perawatan'], "text"),
                       GetSQLValueString($_POST['tindakan'], "text"),
                       GetSQLValueString($_POST['berat_badan'], "double"),
                       GetSQLValueString($_POST['tensi_diastolik'], "int"),
                       GetSQLValueString($_POST['tensi_sistolik'], "int"),
                       GetSQLValueString($_POST['no_pemeriksaan'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "pemeriksaan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $updateGoTo));

 ?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=pemeriksaan'  
  </script> <?php
}

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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pemeriksaan:</div></td>
      <td><div align="left"><?php echo $row_pemeriksaan['no_pemeriksaan']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pasien:</div></td>
      <td><div align="left">
        <select name="no_pas">
          <?php 
do {  
?>
          <option value="<?php echo $row_pemeriksaan['no_pemeriksaan']?>" <?php if (!(strcmp($row_pemeriksaan['no_pemeriksaan'], htmlentities($row_pemeriksaan['no_pas'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_pemeriksaan['no_pemeriksaan']?></option>
          <?php
} while ($row_pemeriksaan = mysql_fetch_assoc($pemeriksaan));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Keluhan:</div></td>
      <td><div align="left">
        <textarea name="keluhan" cols="50" rows="5"><?php echo htmlentities($row_pemeriksaan['keluhan'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Diagnosa:</div></td>
      <td><div align="left">
        <textarea name="diagnosa" cols="50" rows="5"><?php echo htmlentities($row_pemeriksaan['diagnosa'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Perawatan:</div></td>
      <td><div align="left">
        <textarea name="perawatan" cols="50" rows="5"><?php echo htmlentities($row_pemeriksaan['perawatan'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tindakan:</div></td>
      <td><div align="left">
        <input type="text" name="tindakan" value="<?php echo htmlentities($row_pemeriksaan['tindakan'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Berat badan:</div></td>
      <td><div align="left">
        <input type="text" name="berat_badan" value="<?php echo htmlentities($row_pemeriksaan['berat_badan'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tensi diastolik:</div></td>
      <td><div align="left">
        <input type="text" name="tensi_diastolik" value="<?php echo htmlentities($row_pemeriksaan['tensi_diastolik'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tensi sistolik:</div></td>
      <td><div align="left">
        <input type="text" name="tensi_sistolik" value="<?php echo htmlentities($row_pemeriksaan['tensi_sistolik'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
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
  <input type="hidden" name="no_pemeriksaan" value="<?php echo $row_pemeriksaan['no_pemeriksaan']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pemeriksaan);

mysql_free_result($pasien);
?>
