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
  $insertSQL = sprintf("INSERT INTO pendaftaran (no_pendaftaran, nip, no_pas, kode_jadwal, id_jenisbiaya, tgl_pendaftaran, no_urut) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_pendaftaran'], "text"),
                       GetSQLValueString($_POST['nip'], "text"),
                       GetSQLValueString($_POST['no_pas'], "text"),
                       GetSQLValueString($_POST['kode_jadwal'], "text"),
                       GetSQLValueString($_POST['id_jenisbiaya'], "text"),
                       GetSQLValueString($_POST['tgl_pendaftaran'], "date"),
                       GetSQLValueString($_POST['no_urut'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "pendaftaran.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
   ?><script language="javascript">document.location.href='?page=pendaftaran'</script> <?php
}

$maxRows_pendaftaran = 10;
$pageNum_pendaftaran = 0;
if (isset($_GET['pageNum_pendaftaran'])) {
  $pageNum_pendaftaran = $_GET['pageNum_pendaftaran'];
}
$startRow_pendaftaran = $pageNum_pendaftaran * $maxRows_pendaftaran;

mysql_select_db($database_koneksi, $koneksi);
$query_pendaftaran = "SELECT * FROM pendaftaran";
$query_limit_pendaftaran = sprintf("%s LIMIT %d, %d", $query_pendaftaran, $startRow_pendaftaran, $maxRows_pendaftaran);
$pendaftaran = mysql_query($query_limit_pendaftaran, $koneksi) or die(mysql_error());
$row_pendaftaran = mysql_fetch_assoc($pendaftaran);

if (isset($_GET['totalRows_pendaftaran'])) {
  $totalRows_pendaftaran = $_GET['totalRows_pendaftaran'];
} else {
  $all_pendaftaran = mysql_query($query_pendaftaran);
  $totalRows_pendaftaran = mysql_num_rows($all_pendaftaran);
}
$totalPages_pendaftaran = ceil($totalRows_pendaftaran/$maxRows_pendaftaran)-1;

mysql_select_db($database_koneksi, $koneksi);
$query_pasien = "SELECT * FROM pasien";
$pasien = mysql_query($query_pasien, $koneksi) or die(mysql_error());
$row_pasien = mysql_fetch_assoc($pasien);
$totalRows_pasien = mysql_num_rows($pasien);

mysql_select_db($database_koneksi, $koneksi);
$query_biaya = "SELECT * FROM jenis_biaya";
$biaya = mysql_query($query_biaya, $koneksi) or die(mysql_error());
$row_biaya = mysql_fetch_assoc($biaya);
$totalRows_biaya = mysql_num_rows($biaya);

mysql_select_db($database_koneksi, $koneksi);
$query_pegawai = "SELECT * FROM pegawai";
$pegawai = mysql_query($query_pegawai, $koneksi) or die(mysql_error());
$row_pegawai = mysql_fetch_assoc($pegawai);
$totalRows_pegawai = mysql_num_rows($pegawai);

mysql_select_db($database_koneksi, $koneksi);
$query_jadwal = "SELECT * FROM jadwal_praktek";
$jadwal = mysql_query($query_jadwal, $koneksi) or die(mysql_error());
$row_jadwal = mysql_fetch_assoc($jadwal);
$totalRows_jadwal = mysql_num_rows($jadwal);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>pendaftaran</title>
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pendaftaran:</div></td>
      <td><div align="left">
        <input type="text" name="no_pendaftaran" size="15" 
class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pasien:</div></td>
      <td><div align="left">
        <select name="no_pas" required>
          <option value="">Pilih Nomor Pasien :</option>
          <?php 
do {  
?>
          <option value="<?php echo $row_pasien['no_pas']?>" ><?php echo $row_pasien['nama_pas']?></option>
          <?php
} while ($row_pasien = mysql_fetch_assoc($pasien));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nip:</div></td>
      <td><div align="left">
        <select name="nip">
          <?php 
do {  
?>
          <option value="<?php echo $row_pegawai['nip']?>" ><?php echo $row_pegawai['nama_peg']?></option>
          <?php
} while ($row_pegawai = mysql_fetch_assoc($pegawai));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Kode jadwal:</div></td>
      <td><div align="left">
        <select name="kode_jadwal">
          <?php 
do {  
?>
          <option value="<?php echo $row_jadwal['kode_jadwal']?>" ><?php echo $row_jadwal['hari']?></option>
          <?php
} while ($row_jadwal = mysql_fetch_assoc($jadwal));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Id jenisbiaya:</div></td>
      <td><div align="left">
        <select name="id_jenisbiaya">
          <?php 
do {  
?>
          <option value="<?php echo $row_biaya['id_jenisbiaya']?>" ><?php echo $row_biaya['nama_biaya']?></option>
          <?php
} while ($row_biaya = mysql_fetch_assoc($biaya));
?>
        </select>
      </div></td>
    </tr>
    <tr> </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tgl pendaftaran:</div></td>
      <td><div align="left">
        <input type="text" name="tgl_pendaftaran" value="<?php echo date('Y-m-d H:m:s'); ?>" size="20" 
class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No urut:</div></td>
      <td><div align="left">
        <input type="text" name="no_urut" value="" size="15" 
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
  <hr />
  <p>&nbsp;</p>
  
  <table border="1" align="center">
    <tr>
      <td width="184" bgcolor="#333333"><div align="center" class="style1">No pendaftaran</div></td>
      <td width="134" bgcolor="#333333"><div align="center" class="style1">No pas</div></td>
      <td width="108" bgcolor="#333333"><div align="center" class="style1">Nip</div></td>
      <td width="169" bgcolor="#333333"><div align="center" class="style1">Kode jadwal</div></td>
      <td width="168" bgcolor="#333333"><div align="center" class="style1">Id jenisbiaya</div></td>
      <td width="183" bgcolor="#333333"><div align="center" class="style1">Tgl pendaftaran</div></td>
      <td width="136" bgcolor="#333333"><div align="center" class="style1">No urut</div></td>
      <td width="39" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_pendaftaran['no_pendaftaran']; ?></div></td>
        <td><div align="center"><?php echo $row_pendaftaran['no_pas']; ?></div></td>
        <td><div align="center"><?php echo $row_pendaftaran['nip']; ?></div></td>
        <td><div align="center"><?php echo $row_pendaftaran['kode_jadwal']; ?></div></td>
        <td><div align="center"><?php echo $row_pendaftaran['id_jenisbiaya']; ?></div></td>
        <td><div align="center"><?php echo $row_pendaftaran['tgl_pendaftaran']; ?></div></td>
        <td><div align="center"><?php echo $row_pendaftaran['no_urut']; ?></div></td>
        <td><a href="?page=del_pendaftaran&no_pendaftaran=<?php echo $row_pendaftaran['no_pendaftaran']; ?>" class="button round blue image-right ic-delete text-upper">Delete</a></td>
      </tr>
      <?php } while ($row_pendaftaran = mysql_fetch_assoc($pendaftaran)); ?>
  </table>
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
    </p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pendaftaran);

mysql_free_result($pasien);

mysql_free_result($biaya);

mysql_free_result($pegawai);

mysql_free_result($jadwal);
?>
