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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO dokter (kode_dokter, kode_poli, nama_dokter, alamat_dokter, telpn_dokter) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kode_dokter'], "text"),
                       GetSQLValueString($_POST['kode_poli'], "text"),
                       GetSQLValueString($_POST['nama_dokter'], "text"),
                       GetSQLValueString($_POST['alamat_dokter'], "text"),
                       GetSQLValueString($_POST['telpn_dokter'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "dokter.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
//  header(sprintf("Location: %s", $insertGoTo));
?><script language="javascript">document.location.href='?page=dokter'</script> <?php
}

$maxRows_dokter = 10;
$pageNum_dokter = 0;
if (isset($_GET['pageNum_dokter'])) {
  $pageNum_dokter = $_GET['pageNum_dokter'];
}
$startRow_dokter = $pageNum_dokter * $maxRows_dokter;

mysql_select_db($database_koneksi, $koneksi);
$query_dokter = "SELECT dokter.kode_dokter, poli_klinik.nama_poli, dokter.nama_dokter, dokter.alamat_dokter, dokter.telpn_dokter FROM dokter, poli_klinik WHERE dokter.kode_poli=poli_klinik.kode_poli";
$query_limit_dokter = sprintf("%s LIMIT %d, %d", $query_dokter, $startRow_dokter, $maxRows_dokter);
$dokter = mysql_query($query_limit_dokter, $koneksi) or die(mysql_error());
$row_dokter = mysql_fetch_assoc($dokter);

if (isset($_GET['totalRows_dokter'])) {
  $totalRows_dokter = $_GET['totalRows_dokter'];
} else {
  $all_dokter = mysql_query($query_dokter);
  $totalRows_dokter = mysql_num_rows($all_dokter);
}
$totalPages_dokter = ceil($totalRows_dokter/$maxRows_dokter)-1;

//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM dokter";
$kode_dokter=mysql_query($qry) or die(mysql_error());
$row_kode_dokter=mysql_fetch_assoc($kode_dokter);
$urutan=$row_kode_dokter['tambah']+1;


mysql_select_db($database_koneksi, $koneksi);
$query_poli = "SELECT * FROM poli_klinik";
$poli = mysql_query($query_poli, $koneksi) or die(mysql_error());
$row_poli = mysql_fetch_assoc($poli);
$totalRows_poli = mysql_num_rows($poli);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>dokter</title>
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode_dokter:</div></td>
      <td><div align="left">
        <input type="text" name="kode_dokter" value="<?php echo "DKTR-00".$urutan; ?>" size="15" 
class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode_poli:</div></td>
      <td><div align="left">
        <select name="kode_poli">
          <?php 
do {  
?>
          <option value="<?php echo $row_poli['kode_poli']?>" ><?php echo $row_poli['nama_poli']?></option>
          <?php
} while ($row_poli = mysql_fetch_assoc($poli));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama_dokter:</div></td>
      <td><div align="left">
        <input type="text" name="nama_dokter" value="" size="20" 
class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Alamat_dokter:</div></td>
      <td><div align="left">
        <textarea name="alamat_dokter" cols="30" rows="5" 
class="round default-width-input"></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Telpon_dokter:</div></td>
      <td><div align="left">
        <input type="text" name="telpn_dokter" value="" size="15" 
class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Simpan" class="round blue ic-right-arrow" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <hr />
  <p>&nbsp;  </p>
  <table border="1" align="center">
    <tr>
      <td width="138" bgcolor="#333333"><div align="center" class="style1">Kode dokter</div></td>
      <td width="121" bgcolor="#333333"><div align="center" class="style1">Kode poli</div></td>
      <td width="139" bgcolor="#333333"><div align="center" class="style1">Nama dokter</div></td>
      <td width="146" bgcolor="#333333"><div align="center" class="style1">Alamat dokter</div></td>
      <td width="136" bgcolor="#333333"><div align="center" class="style1">Telpon dokter</div></td>
      <td colspan="2" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
    <tr>
      <td><div align="center"><?php echo $row_dokter['kode_dokter']; ?></div></td>
      <td><div align="center"><?php echo $row_dokter['nama_poli']; ?></div></td>
      <td><div align="center"><?php echo $row_dokter['nama_dokter']; ?></div></td>
      <td><div align="center"><?php echo $row_dokter['alamat_dokter']; ?></div></td>
      <td><div align="center"><?php echo $row_dokter['telpn_dokter']; ?></div></td>
      <td width="24"><a href="?page=edit_dokter&kode_dokter=<?php echo $row_dokter['kode_dokter']; ?>"class="button round blue image-right ic-edit text-upper">Edit</a></td>
      <td width="39"><a href="?page=del_dokter&kode_dokter=<?php echo $row_dokter['kode_dokter']; ?>"class="button round blue image-right ic-delete text-upper" onclick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
    </tr>
    <?php } while ($row_dokter = mysql_fetch_assoc($dokter)); ?>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form2" />
    </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($dokter);

mysql_free_result($poli);
?>
