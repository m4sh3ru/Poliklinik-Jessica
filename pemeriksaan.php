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
  $insertSQL = sprintf("INSERT INTO pemeriksaan (no_pemeriksaan, no_pas, keluhan, diagnosa, perawatan, tindakan, berat_badan, tensi_diastolik, tensi_sistolik) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_pemeriksaan'], "text"),
                       GetSQLValueString($_POST['no_pas'], "text"),
                       GetSQLValueString($_POST['keluhan'], "text"),
                       GetSQLValueString($_POST['diagnosa'], "text"),
                       GetSQLValueString($_POST['perawatan'], "text"),
                       GetSQLValueString($_POST['tindakan'], "text"),
                       GetSQLValueString($_POST['berat_badan'], "double"),
                       GetSQLValueString($_POST['tensi_diastolik'], "int"),
                       GetSQLValueString($_POST['tensi_sistolik'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "pemeriksaan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $insertGoTo));
 ?><script language="javascript">document.location.href='?page=pemeriksaan'</script> <?php
}

$maxRows_pemeriksaan = 10;
$pageNum_pemeriksaan = 0;
if (isset($_GET['pageNum_pemeriksaan'])) {
  $pageNum_pemeriksaan = $_GET['pageNum_pemeriksaan'];
}
$startRow_pemeriksaan = $pageNum_pemeriksaan * $maxRows_pemeriksaan;

mysql_select_db($database_koneksi, $koneksi);
$query_pemeriksaan = "SELECT * FROM pemeriksaan";
$query_limit_pemeriksaan = sprintf("%s LIMIT %d, %d", $query_pemeriksaan, $startRow_pemeriksaan, $maxRows_pemeriksaan);
$pemeriksaan = mysql_query($query_limit_pemeriksaan, $koneksi) or die(mysql_error());
$row_pemeriksaan = mysql_fetch_assoc($pemeriksaan);

if (isset($_GET['totalRows_pemeriksaan'])) {
  $totalRows_pemeriksaan = $_GET['totalRows_pemeriksaan'];
} else {
  $all_pemeriksaan = mysql_query($query_pemeriksaan);
  $totalRows_pemeriksaan = mysql_num_rows($all_pemeriksaan);
}
$totalPages_pemeriksaan = ceil($totalRows_pemeriksaan/$maxRows_pemeriksaan)-1;


//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM pemeriksaan";
$no_pemeriksaan=mysql_query($qry) or die(mysql_error());
$row_no_pemeriksaan=mysql_fetch_assoc($no_pemeriksaan);
$urutan=$row_no_pemeriksaan['tambah']+1;


mysql_select_db($database_koneksi, $koneksi);
$query_pasien = "SELECT * FROM pasien";
$pasien = mysql_query($query_pasien, $koneksi) or die(mysql_error());
$row_pasien = mysql_fetch_assoc($pasien);
$totalRows_pasien = mysql_num_rows($pasien);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>pemeriksaan</title>
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pemeriksaan:</div></td>
      <td><div align="left">
        <input type="text" name="no_pemeriksaan" value="<?php echo "PMRS-00".$urutan; ?>" size="15" class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">No pasien:</div></td>
      <td><div align="left">
        <select name="no_pas">
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
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Keluhan:</div></td>
      <td><div align="left">
        <textarea name="keluhan" cols="30" rows="5" class="round default-width-input"></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Diagnosa:</div></td>
      <td><div align="left">
        <textarea name="diagnosa" cols="30" rows="5" class="round default-width-input"></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Perawatan:</div></td>
      <td><div align="left">
        <textarea name="perawatan" cols="30" rows="5" class="round default-width-input"></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Tindakan:</div></td>
      <td><div align="left">
        <textarea name="tindakan" cols="30" rows="5" class="round default-width-input"></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Berat badan:</div></td>
      <td><div align="left">
        <input type="text" name="berat_badan" value="" size="15" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tensi diastolik:</div></td>
      <td><div align="left">
        <input type="text" name="tensi_diastolik" value="" size="15" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tensi sistolik:</div></td>
      <td><div align="left">
        <input type="text" name="tensi_sistolik" value="" size="15" class="round default-width-input"/>
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

  <table border="1">
    <tr>
      <td bgcolor="#333333"><div align="center" class="style1">No pemeriksaan</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">No pasien</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Keluhan</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Diagnosa</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Perawatan</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Tindakan</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Berat badan</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Tensi diastolik</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Tensi sistolik</div></td>
      <td colspan="3" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_pemeriksaan['no_pemeriksaan']; ?></div></td>
        <td><div align="center"><?php echo $row_pemeriksaan['no_pas']; ?></div></td>
        <td><div align="center"><?php echo $row_pemeriksaan['keluhan']; ?></div></td>
        <td><div align="center"><?php echo $row_pemeriksaan['diagnosa']; ?></div></td>
        <td><div align="center"><?php echo $row_pemeriksaan['perawatan']; ?></div></td>
        <td><div align="center"><?php echo $row_pemeriksaan['tindakan']; ?></div></td>
        <td><div align="center"><?php echo $row_pemeriksaan['berat_badan']; ?></div></td>
        <td><div align="center"><?php echo $row_pemeriksaan['tensi_diastolik']; ?></div></td>
        <td><div align="center"><?php echo $row_pemeriksaan['tensi_sistolik']; ?></div></td>
        <td><a href="?page=edit_pemeriksaan&no_pemeriksaan=<?php echo $row_pemeriksaan['no_pemeriksaan']; ?>" class="button round blue image-right ic-edit text-upper">Edit</a></td>
        <td><a href="?page=del_pemeriksa&no_pemeriksaan=<?php echo $row_pemeriksaan['no_pemeriksaan']; ?>" class="button round blue image-right ic-delete text-upper" onClick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
        <td><div align="center"><a href="cetak_laporan.php?no_pemeriksaan=<?php echo $row_pemeriksaan['no_pemeriksaan']; ?>" target="_blank" class="button round blue image-right ic-print text-upper">Laporan</a></td>
      </tr>
      <?php } while ($row_pemeriksaan = mysql_fetch_assoc($pemeriksaan)); ?>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($pemeriksaan);

mysql_free_result($pasien);
?>
