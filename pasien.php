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
  $insertSQL = sprintf("INSERT INTO pasien (no_pas, nama_pas, alamat_pas, tlp_pas, tgl_lhr, jenis_kel, tgl_registrasi) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_pas'], "text"),
                       GetSQLValueString($_POST['nama_pas'], "text"),
                       GetSQLValueString($_POST['alamat_pas'], "text"),
                       GetSQLValueString($_POST['tlp_pas'], "text"),
                       GetSQLValueString($_POST['tgl_lhr'], "date"),
                       GetSQLValueString($_POST['jenis_kel'], "text"),
                       GetSQLValueString($_POST['tgl_registrasi'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "pasien.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $insertGoTo));
 ?><script language="javascript">document.location.href='?page=pasien'</script> <?php
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pasien (no_pas, nama_pas, alamat_pas, tlp_pas, tgl_lhr, jenis_kel, tgl_registrasi) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_pas'], "text"),
                       GetSQLValueString($_POST['nama_pas'], "text"),
                       GetSQLValueString($_POST['alamat_pas'], "text"),
                       GetSQLValueString($_POST['tlp_pas'], "text"),
                       GetSQLValueString($_POST['tgl_lhr'], "date"),
                       GetSQLValueString($_POST['jenis_kel'], "text"),
                       GetSQLValueString($_POST['tgl_registrasi'], "date"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "pasien.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_pasien = 10;
$pageNum_pasien = 0;
if (isset($_GET['pageNum_pasien'])) {
  $pageNum_pasien = $_GET['pageNum_pasien'];
}
$startRow_pasien = $pageNum_pasien * $maxRows_pasien;

mysql_select_db($database_koneksi, $koneksi);
$query_pasien = "SELECT * FROM pasien";
$query_limit_pasien = sprintf("%s LIMIT %d, %d", $query_pasien, $startRow_pasien, $maxRows_pasien);
$pasien = mysql_query($query_limit_pasien, $koneksi) or die(mysql_error());
$row_pasien = mysql_fetch_assoc($pasien);

if (isset($_GET['totalRows_pasien'])) {
  $totalRows_pasien = $_GET['totalRows_pasien'];
} else {
  $all_pasien = mysql_query($query_pasien);
  $totalRows_pasien = mysql_num_rows($all_pasien);
}
$totalPages_pasien = ceil($totalRows_pasien/$maxRows_pasien)-1;

mysql_select_db($database_koneksi, $koneksi);
$query_edit_pas = "SELECT * FROM pasien";
$edit_pas = mysql_query($query_edit_pas, $koneksi) or die(mysql_error());
$row_edit_pas = mysql_fetch_assoc($edit_pas);
$totalRows_edit_pas = mysql_num_rows($edit_pas);

//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM pasien";
$no_pasien=mysql_query($qry) or die(mysql_error());
$row_no_pasien=mysql_fetch_assoc($no_pasien);
$urutan=$row_no_pasien['tambah']+1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pasien</title>
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pasien:</div></td>
      <td><div align="left">
        <input type="text" name="no_pas" value="<?php echo "PSN-00".$urutan; ?>"  size="15" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama pasien:</div></td>
      <td><div align="left">
        <input type="text" name="nama_pas" value="" size="15" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Alamat pasien:</div></td>
      <td><div align="left">
        <textarea name="alamat_pas" cols="30" rows="5" class="round default-width-input"></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tlp pasien:</div></td>
      <td><div align="left">
        <input type="text" name="tlp_pas" value="" size="20" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tgl lahir:</div></td>
      <td><div align="left">
        <input type="text" name="tgl_lhr" value="" size="20" placeholder="yyyy-mm-dd" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jenis kelamin:</div></td>
      <td valign="baseline"><div align="left">
        <input type="radio" name="jenis_kel" value="L" />
Laki-laki
<input type="radio" name="jenis_kel" value="P" />
Perempuan</div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tgl registrasi:</div></td>
      <td><div align="left">
        <input type="text" name="tgl_registrasi" value="<?php echo date('Y-m-d H:m:s'); ?>" size="20" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Simpan" class="round blue ic-right-arrow" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;  </p>
  <hr />
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
    </p>

  <table border="1" align="center">
    <tr>
      <td bgcolor="#333333"><div align="center" class="style1">No pasien</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Nama pasien</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Alamat pasien</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Telepon pasien</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Tgl lahir</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Jenis kelamin</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Tgl registrasi</div></td>
      <td colspan="3" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_pasien['no_pas']; ?></div></td>
        <td><div align="center"><?php echo $row_pasien['nama_pas']; ?></div></td>
        <td><div align="center"><?php echo $row_pasien['alamat_pas']; ?></div></td>
        <td><div align="center"><?php echo $row_pasien['tlp_pas']; ?></div></td>
        <td><div align="center"><?php echo $row_pasien['tgl_lhr']; ?></div></td>
        <td><div align="center"><?php echo $row_pasien['jenis_kel']; ?></div></td>
        <td><div align="center"><?php echo $row_pasien['tgl_registrasi']; ?></div></td>
        <td><a href="?page=edit_pas&no_pas=<?php echo $row_pasien['no_pas']; ?>"
class="button round blue image-right ic-edit text-upper">Edit</a></td>
        <td><a href="?page=del_pas&no_pas=<?php echo $row_pasien['no_pas']; ?>" class="button round blue image-right ic-delete text-upper" onClick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
        <td><a href="kartu_pasien.php?no_pas=<?php echo $row_pasien['no_pas']; ?>" target="_blank"class="button round blue image-right ic-print text-upper"> Kartu</a></td>
      </tr>
      <?php } while ($row_pasien = mysql_fetch_assoc($pasien)); ?>
  </table>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pasien);

mysql_free_result($edit_pas);
?>
