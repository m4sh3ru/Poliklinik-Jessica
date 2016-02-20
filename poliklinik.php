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
  $insertSQL = sprintf("INSERT INTO poli_klinik (kode_poli, nama_poli) VALUES (%s, %s)",
                       GetSQLValueString($_POST['kode_poli'], "text"),
                       GetSQLValueString($_POST['nama_poli'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "poliklinik.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
  ?><script language="javascript">document.location.href='?page=poliklinik'</script> <?php
}

$maxRows_poliklinik = 10;
$pageNum_poliklinik = 0;
if (isset($_GET['pageNum_poliklinik'])) {
  $pageNum_poliklinik = $_GET['pageNum_poliklinik'];
}
$startRow_poliklinik = $pageNum_poliklinik * $maxRows_poliklinik;

mysql_select_db($database_koneksi, $koneksi);
$query_poliklinik = "SELECT * FROM poli_klinik";
$query_limit_poliklinik = sprintf("%s LIMIT %d, %d", $query_poliklinik, $startRow_poliklinik, $maxRows_poliklinik);
$poliklinik = mysql_query($query_limit_poliklinik, $koneksi) or die(mysql_error());
$row_poliklinik = mysql_fetch_assoc($poliklinik);

//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM poli_klinik";
$kode_poli=mysql_query($qry) or die(mysql_error());
$row_kode_poli=mysql_fetch_assoc($kode_poli);
$urutan=$row_kode_poli['tambah']+1;

if (isset($_GET['totalRows_poliklinik'])) {
  $totalRows_poliklinik = $_GET['totalRows_poliklinik'];
} else {
  $all_poliklinik = mysql_query($query_poliklinik);
  $totalRows_poliklinik = mysql_num_rows($all_poliklinik);
}
$totalPages_poliklinik = ceil($totalRows_poliklinik/$maxRows_poliklinik)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>poliklinik</title>
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode poli:</div></td>
      <td><div align="left">
        <input type="text" name="kode_poli" value="<?php echo "POLI-00".$urutan; ?>" size="15" 
class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama poli:</div></td>
      <td><div align="left">
        <input type="text" name="nama_poli" value="" size="15" 
class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input  type="submit" value="Simpan" class="round blue ic-right-arrow"/>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;  </p>
  <hr />
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
    </p>

  <table border="1">
    <tr>
      <td bgcolor="#333333"><div align="center" class="style1">kode poli</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Nama poli</div></td>
      <td colspan="2" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_poliklinik['kode_poli']; ?></div></td>
        <td><div align="center"><?php echo $row_poliklinik['nama_poli']; ?></div></td>
        <td><a href="?page=edit_poli&kode_poli=<?php echo $row_poliklinik['kode_poli']; ?>" class="button round blue image-right ic-edit text-upper">Edit</a></td>
        <td><a href="?page=del_poli&kode_poli=<?php echo $row_poliklinik['kode_poli']; ?>" class="button round blue image-right ic-delete text-upper">Delete</a></td>
      </tr>
      <?php } while ($row_poliklinik = mysql_fetch_assoc($poliklinik)); ?>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($poliklinik);
?>
