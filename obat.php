<?php require_once('Connections/koneksi.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO obat (kode_obat, no_resep, nama_obat, merk, satuan, harga_jual) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_obat'], "text"),
                       GetSQLValueString($_POST['no_resep'], "text"),
                       GetSQLValueString($_POST['nama_obat'], "text"),
                       GetSQLValueString($_POST['merk'], "text"),
                       GetSQLValueString($_POST['satuan'], "text"),
                       GetSQLValueString($_POST['harga_jual'], "double"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "obat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO obat (kode_obat, nama_obat, merk, satuan, harga_jual) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_obat'], "text"),
                       GetSQLValueString($_POST['nama_obat'], "text"),
                       GetSQLValueString($_POST['merk'], "text"),
                       GetSQLValueString($_POST['satuan'], "text"),
                       GetSQLValueString($_POST['harga_jual'], "double"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "obat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
?><script language="javascript">document.location.href='?page=obat'</script> <?php
}

$maxRows_obat = 10;
$pageNum_obat = 0;
if (isset($_GET['pageNum_obat'])) {
  $pageNum_obat = $_GET['pageNum_obat'];
}
$startRow_obat = $pageNum_obat * $maxRows_obat;

mysql_select_db($database_koneksi, $koneksi);
$query_obat = "SELECT * FROM obat";
$query_limit_obat = sprintf("%s LIMIT %d, %d", $query_obat, $startRow_obat, $maxRows_obat);
$obat = mysql_query($query_limit_obat, $koneksi) or die(mysql_error());
$row_obat = mysql_fetch_assoc($obat);

//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM obat";
$kode_obat=mysql_query($qry) or die(mysql_error());
$row_kode_obat=mysql_fetch_assoc($kode_obat);
$urutan=$row_kode_obat['tambah']+1;

if (isset($_GET['totalRows_obat'])) {
  $totalRows_obat = $_GET['totalRows_obat'];
} else {
  $all_obat = mysql_query($query_obat);
  $totalRows_obat = mysql_num_rows($all_obat);
}
$totalPages_obat = ceil($totalRows_obat/$maxRows_obat)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>obat</title>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>
</head>

<body>


<form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
 
  <table>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode obat:</div></td>
      <td><div align="left">
        <input type="text" name="kode_obat" value="<?php echo "OBT-00".$urutan; ?>" size="15" 
class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama obat:</div></td>
      <td><div align="left">
        <input type="text" name="nama_obat" value="" size="15" 
class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Merk:</div></td>
      <td><div align="left">
        <input type="text" name="merk" value="" size="15" 
class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Satuan:</div></td>
      <td><div align="left">
        <input type="text" name="satuan" value="" size="15" 
class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Harga jual:</div></td>
      <td><div align="left">
        <input type="text" name="harga_jual" value="" size="15" 
class="round default-width-input"/>
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
    <input type="hidden" name="MM_insert" value="form2" />
    </p>


  <table border="1">
    <tr>
      <td bgcolor="#333333"><div align="center" class="style1">Kode obat</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Nama obat</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Merk</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Satuan</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Harga jual</div></td>
      <td colspan="2" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_obat['kode_obat']; ?></div></td>
        <td><div align="center"><?php echo $row_obat['nama_obat']; ?></div></td>
        <td><div align="center"><?php echo $row_obat['merk']; ?></div></td>
        <td><div align="center"><?php echo $row_obat['satuan']; ?></div></td>
        <td><div align="center"><?php echo $row_obat['harga_jual']; ?></div></td>
        <td><a href="?page=edit_obat&kode_obat=<?php echo $row_obat['kode_obat']; ?>" 
class="button round blue image-right ic-edit text-upper">Edit</a></td>
        <td><a href="?page=del_obat&kode_obat=<?php echo $row_obat['kode_obat']; ?>" class="button round blue image-right ic-delete text-upper" onclick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
      </tr>
      <?php } while ($row_obat = mysql_fetch_assoc($obat)); ?>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($obat);
?>
