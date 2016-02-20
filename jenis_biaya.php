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
  $insertSQL = sprintf("INSERT INTO jenis_biaya (id_jenisbiaya, nama_biaya, tarif) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_jenisbiaya'], "text"),
                       GetSQLValueString($_POST['nama_biaya'], "text"),
                       GetSQLValueString($_POST['tarif'], "double"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "jenis_biaya.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $insertGoTo));
 ?><script language="javascript">document.location.href='?page=jenis_biaya'</script> <?php
}

$maxRows_biaya = 10;
$pageNum_biaya = 0;
if (isset($_GET['pageNum_biaya'])) {
  $pageNum_biaya = $_GET['pageNum_biaya'];
}
$startRow_biaya = $pageNum_biaya * $maxRows_biaya;

//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM jenis_biaya";
$id_jenisbiaya=mysql_query($qry) or die(mysql_error());
$row_id_jenisbiaya=mysql_fetch_assoc($id_jenisbiaya);
$urutan=$row_id_jenisbiaya['tambah']+1;


mysql_select_db($database_koneksi, $koneksi);
$query_biaya = "SELECT * FROM jenis_biaya";
$query_limit_biaya = sprintf("%s LIMIT %d, %d", $query_biaya, $startRow_biaya, $maxRows_biaya);
$biaya = mysql_query($query_limit_biaya, $koneksi) or die(mysql_error());
$row_biaya = mysql_fetch_assoc($biaya);

if (isset($_GET['totalRows_biaya'])) {
  $totalRows_biaya = $_GET['totalRows_biaya'];
} else {
  $all_biaya = mysql_query($query_biaya);
  $totalRows_biaya = mysql_num_rows($all_biaya);
}
$totalPages_biaya = ceil($totalRows_biaya/$maxRows_biaya)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>jenis biaya</title>
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
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Id jenisbiaya:</div></td>
      <td><div align="left">
        <input type="text" name="id_jenisbiaya" value="<?php echo "BAY-00".$urutan; ?>" size="15" 
class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama biaya:</div></td>
      <td><div align="left">
        <input type="text" name="nama_biaya" value="" size="15" 
class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Tarif:</div></td>
      <td><div align="left">
        <input type="text" name="tarif" value="" size="15" 
class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Simpan" class="round blue ic-right-arrow"/>
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
      <td bgcolor="#333333"width="129"><div align="center" class="style1">Id jenisbiaya</div></td>
      <td bgcolor="#333333" width="123"><div align="center" class="style1">Nama biaya</div></td>
      <td bgcolor="#333333"width="74"><div align="center" class="style1">Tarif</div></td>
      <td bgcolor="#333333"colspan="2"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_biaya['id_jenisbiaya']; ?></div></td>
        <td><div align="center"><?php echo $row_biaya['nama_biaya']; ?></div></td>
        <td><div align="center"><?php echo $row_biaya['tarif']; ?></div></td>
        <td width="32"><a href="?page=edit_biaya&id_jenisbiaya=<?php echo $row_biaya['id_jenisbiaya']; ?>" class="button round blue image-right ic-edit text-upper">Edit</a></td>
        <td width="32"><a href="?page=del_biaya&id_jenisbiaya=<?php echo $row_biaya['id_jenisbiaya']; ?>" class="button round blue image-right ic-delete text-upper" onclick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
      </tr>
      <?php } while ($row_biaya = mysql_fetch_assoc($biaya)); ?>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($biaya);
?>
