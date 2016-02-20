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
  $insertSQL = sprintf("INSERT INTO resep (no_resep, no_pemeriksaan, kode_obat, dosis, jumlah) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_resep'], "text"),
                       GetSQLValueString($_POST['no_pemeriksaan'], "text"),
                       GetSQLValueString($_POST['kode_obat'], "text"),
                       GetSQLValueString($_POST['dosis'], "text"),
                       GetSQLValueString($_POST['jumlah'], "double"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "resep.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
  ?><script language="javascript">document.location.href='?page=resep'</script> <?php
}

$maxRows_resep = 10;
$pageNum_resep = 0;
if (isset($_GET['pageNum_resep'])) {
  $pageNum_resep = $_GET['pageNum_resep'];
}
$startRow_resep = $pageNum_resep * $maxRows_resep;

mysql_select_db($database_koneksi, $koneksi);
$query_resep = "SELECT resep.no_resep, resep.no_pemeriksaan,pemeriksaan.no_pas,pasien.nama_pas ,obat.nama_obat, resep.dosis, resep.jumlah FROM resep, obat, pemeriksaan, pasien WHERE resep.kode_obat=obat.kode_obat AND pemeriksaan.no_pas=pasien.no_pas";
$query_limit_resep = sprintf("%s LIMIT %d, %d", $query_resep, $startRow_resep, $maxRows_resep);
$resep = mysql_query($query_limit_resep, $koneksi) or die(mysql_error());
$row_resep = mysql_fetch_assoc($resep);

if (isset($_GET['totalRows_resep'])) {
  $totalRows_resep = $_GET['totalRows_resep'];
} else {
  $all_resep = mysql_query($query_resep);
  $totalRows_resep = mysql_num_rows($all_resep);
}
$totalPages_resep = ceil($totalRows_resep/$maxRows_resep)-1;

mysql_select_db($database_koneksi, $koneksi);
$query_pemeriksaan = "SELECT * FROM pemeriksaan";
$pemeriksaan = mysql_query($query_pemeriksaan, $koneksi) or die(mysql_error());
$row_pemeriksaan = mysql_fetch_assoc($pemeriksaan);
$totalRows_pemeriksaan = mysql_num_rows($pemeriksaan);

//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM resep";
$no_resep=mysql_query($qry) or die(mysql_error());
$row_no_resep=mysql_fetch_assoc($no_resep);
$urutan=$row_no_resep['tambah']+1;

mysql_select_db($database_koneksi, $koneksi);
$query_obat = "SELECT * FROM obat";
$obat = mysql_query($query_obat, $koneksi) or die(mysql_error());
$row_obat = mysql_fetch_assoc($obat);
$totalRows_obat = mysql_num_rows($obat);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Resep</title>
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No resep:</div></td>
      <td>        <div align="left">
        <input type="text" name="no_resep" value=" 
<?php echo "RSP-00".$urutan; ?>" size="15" 
class="round default-width-input"/>      
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pemeriksaan:</div></td>
      <td>
        <div align="left">
          <select name="no_pemeriksaan">
            <?php 
do {  
?>
            <option value="<?php echo $row_pemeriksaan['no_pemeriksaan']?>" ><?php echo $row_pemeriksaan['no_pemeriksaan']?></option>
            <?php
} while ($row_pemeriksaan = mysql_fetch_assoc($pemeriksaan));
?>
          </select>
        </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode obat:</div></td>
      <td>
        <div align="left">
          <select name="kode_obat">
            <?php 
do {  
?>
            <option value="<?php echo $row_obat['kode_obat']?>" ><?php echo $row_obat['nama_obat']?></option>
            <?php
} while ($row_obat = mysql_fetch_assoc($obat));
?>
          </select>
        </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Dosis:</div></td>
      <td>        <div align="left">
        <input type="text" name="dosis" value="" size="15" 
class="round default-width-input" />      
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Jumlah:</div></td>
      <td>        <div align="left">
        <input type="text" name="jumlah" value="" size="15" 
class="round default-width-input" />      
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td>        <div align="left">
        <input type="submit" value="Simpan" class="round blue ic-right-arrow"/>      
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
      <td bgcolor="#333333"><div align="center" class="style1">No resep</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">No pemeriksaan</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">No pasien</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Nama pasien</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Kode obat</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">dosis</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">jumlah</div></td>
      <td colspan="3" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
    <tr>
      <td height="59"><div align="center"><?php echo $row_resep['no_resep']; ?></div></td>
      <td><div align="center"><?php echo $row_resep['no_pemeriksaan']; ?></div></td>
      <td><div align="center"><?php echo $row_resep['no_pas']; ?></div></td>
      <td><div align="center"><?php echo $row_resep['nama_pas']; ?></div></td>
      <td><div align="center"><?php echo $row_resep['nama_obat']; ?></div></td>
      <td><div align="center"><?php echo $row_resep['dosis']; ?></div></td>
      <td><div align="center"><?php echo $row_resep['jumlah']; ?></div></td>
      <td><a href="?page=edit_resep&no_resep=<?php echo $row_resep['no_resep']; ?>" class="button round blue image-right ic-edit text-upper">Edit</a></td>
      <td><a href="?page=del_resep&no_resep=<?php echo $row_resep['no_resep']; ?>" class="button round blue image-right ic-delete text-upper" onClick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
      <td><a href="cetak_resep.php?no_resep=<?php echo $row_resep['no_resep']; ?>" target="_blank" class="button round blue image-right ic-print text-upper"> Resep</a></td>
    </tr>
    <?php } while ($row_resep = mysql_fetch_assoc($resep)); ?>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($resep);

mysql_free_result($pemeriksaan);

mysql_free_result($obat);
?>
