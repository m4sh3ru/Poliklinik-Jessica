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
  $updateSQL = sprintf("UPDATE pegawai SET nama_peg=%s, almt_peg=%s, telpn_peg=%s, tgl_lhr=%s, jenis_kel=%s WHERE nip=%s",
                       GetSQLValueString($_POST['nama_peg'], "text"),
                       GetSQLValueString($_POST['almt_peg'], "text"),
                       GetSQLValueString($_POST['telpn_peg'], "text"),
                       GetSQLValueString($_POST['tgl_lhr'], "date"),
                       GetSQLValueString($_POST['jenis_kel'], "text"),
                       GetSQLValueString($_POST['nip'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "?page=pegawai";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $updateGoTo));
  ?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=pegawai'  
  </script> <?php
}

$colname_edit_pegawai = "-1";
if (isset($_GET['nip'])) {
  $colname_edit_pegawai = $_GET['nip'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_pegawai = sprintf("SELECT * FROM pegawai WHERE nip = %s", GetSQLValueString($colname_edit_pegawai, "text"));
$edit_pegawai = mysql_query($query_edit_pegawai, $koneksi) or die(mysql_error());
$row_edit_pegawai = mysql_fetch_assoc($edit_pegawai);
$totalRows_edit_pegawai = mysql_num_rows($edit_pegawai);
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nip:</div></td>
      <td><div align="left"><?php echo $row_edit_pegawai['nip']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama pegawai:</div></td>
      <td><div align="left">
        <input type="text" name="nama_peg" value="<?php echo htmlentities($row_edit_pegawai['nama_peg'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Almt pegawai:</div></td>
      <td><div align="left">
        <textarea name="almt_peg" cols="50" rows="5"><?php echo htmlentities($row_edit_pegawai['almt_peg'], ENT_COMPAT, 'utf-8'); ?></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Telpon pegawai:</div></td>
      <td><div align="left">
        <input type="text" name="telpn_peg" value="<?php echo htmlentities($row_edit_pegawai['telpn_peg'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tgl lahir:</div></td>
      <td><div align="left">
        <input type="text" name="tgl_lhr" value="<?php echo htmlentities($row_edit_pegawai['tgl_lhr'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jenis kelamin:</div></td>
      <td valign="baseline"><div align="left">
        <input type="radio" name="jenis_kel" value="L" <?php if (!(strcmp(htmlentities($row_edit_pegawai['jenis_kel'], ENT_COMPAT, 'utf-8'),"L"))) {echo "CHECKED";} ?> />
Laki-laki
<input type="radio" name="jenis_kel" value="P" <?php if (!(strcmp(htmlentities($row_edit_pegawai['jenis_kel'], ENT_COMPAT, 'utf-8'),"P"))) {echo "CHECKED";} ?> />
Perempuan</div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Ubah Data" class="button round blue image-right ic-edit text-upper" />
      </div>
      <label></label></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="nip" value="<?php echo $row_edit_pegawai['nip']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_pegawai);
?>
