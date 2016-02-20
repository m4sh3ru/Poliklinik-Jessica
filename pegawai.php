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
  $insertSQL = sprintf("INSERT INTO pegawai (nip, nama_peg, almt_peg, telpn_peg, tgl_lhr, jenis_kel) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nip'], "text"),
                       GetSQLValueString($_POST['nama_peg'], "text"),
                       GetSQLValueString($_POST['almt_peg'], "text"),
                       GetSQLValueString($_POST['telpn_peg'], "text"),
                       GetSQLValueString($_POST['tgl_lhr'], "date"),
                       GetSQLValueString($_POST['jenis_kel'], "text"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($insertSQL, $koneksi) or die(mysql_error());

  $insertGoTo = "pegawai.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  //header(sprintf("Location: %s", $insertGoTo));
  ?><script language="javascript">document.location.href='?page=pegawai'</script> <?php
}

$maxRows_pegawai = 10;
$pageNum_pegawai = 0;
if (isset($_GET['pageNum_pegawai'])) {
  $pageNum_pegawai = $_GET['pageNum_pegawai'];
}
$startRow_pegawai = $pageNum_pegawai * $maxRows_pegawai;

mysql_select_db($database_koneksi, $koneksi);
$query_pegawai = "SELECT * FROM pegawai";
$query_limit_pegawai = sprintf("%s LIMIT %d, %d", $query_pegawai, $startRow_pegawai, $maxRows_pegawai);
$pegawai = mysql_query($query_limit_pegawai, $koneksi) or die(mysql_error());
$row_pegawai = mysql_fetch_assoc($pegawai);


//membuat nomor pasien otomatis
$qry="SELECT COUNT(*) AS tambah FROM pegawai";
$nip=mysql_query($qry) or die(mysql_error());
$row_nip=mysql_fetch_assoc($nip);
$urutan=$row_nip['tambah']+1;


if (isset($_GET['totalRows_pegawai'])) {
  $totalRows_pegawai = $_GET['totalRows_pegawai'];
} else {
  $all_pegawai = mysql_query($query_pegawai);
  $totalRows_pegawai = mysql_num_rows($all_pegawai);
}
$totalPages_pegawai = ceil($totalRows_pegawai/$maxRows_pegawai)-1;
?>
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style>

<title>pegawai</title><form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nip:</div></td>
      <td><div align="left">
        <input type="text" name="nip" value="
<?php echo "PGW-00".$urutan; ?>" size="15" class="round default-width-input"/>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Nama pegawai:</div></td>
      <td><div align="left">
        <input type="text" name="nama_peg" value="" size="20" class="round default-width-input" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right" valign="top"><div align="left">Alamt pegawai:</div></td>
      <td><div align="left">
        <textarea name="almt_peg" cols="30" rows="5" class="round default-width-input"></textarea>
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left">Telpon pegawai:</div></td>
      <td><div align="left">
        <input type="text" name="telpn_peg" value="" size="20" class="round default-width-input" />
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
        <input type="radio" name="jenis_kel" value="P" />
        Perempuan
        <input type="radio" name="jenis_kel" value="L" />
              Laki-laki
        
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="top" nowrap="nowrap"><div align="left"></div></td>
      <td><div align="left">
        <input name="Submit" type="submit" value="Simpan" class="round blue ic-right-arrow" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;  </p>
  <hr />
  <p>
    <input type="hidden" name="MM_insert" value="form1" />
    </p>

  <table>
    <tr>
      <td bgcolor="#333333"><div align="center" class="style1">Nip </div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Nama pegawai </div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Alamt pegawai</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Telepon pegawai</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Tgl lahir</div></td>
      <td bgcolor="#333333"><div align="center" class="style1">Jenis kelamin</div></td>
      <td colspan="2" bgcolor="#333333"><div align="center" class="style1">Aksi</div></td>
    </tr>
    <?php do { ?>
      <tr>
        <td><div align="center"><?php echo $row_pegawai['nip']; ?></div></td>
        <td><div align="center"><?php echo $row_pegawai['nama_peg']; ?></div></td>
        <td><div align="center"><?php echo $row_pegawai['almt_peg']; ?></div></td>
        <td><div align="center"><?php echo $row_pegawai['telpn_peg']; ?></div></td>
        <td><div align="center"><?php echo $row_pegawai['tgl_lhr']; ?></div></td>
        <td><div align="center"><?php echo $row_pegawai['jenis_kel']; ?></div></td>
        <td><a href="?page=edit_pegawai&nip=<?php echo $row_pegawai['nip']; ?>" class="button round blue image-right ic-edit text-upper">Edit</a></td>
        <td><a href="?page=del_pegawai&nip=<?php echo $row_pegawai['nip']; ?>"  class="button round blue image-right ic-delete text-upper" onclick="return confirm('Anda yakin menghapus data ini ?')">Delete</a></td>
      </tr>
      <?php } while ($row_pegawai = mysql_fetch_assoc($pegawai)); ?>
  </table>
</form>

<?php
mysql_free_result($pegawai);
?>
