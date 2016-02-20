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

$colname_resep = "-1";
if (isset($_GET['no_resep'])) {
  $colname_resep = $_GET['no_resep'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_resep = sprintf("SELECT resep.no_resep, resep.no_pemeriksaan,pemeriksaan.no_pas,pasien.nama_pas ,obat.merk, resep.dosis, resep.jumlah FROM resep, obat, pemeriksaan, pasien WHERE resep.kode_obat=obat.kode_obat AND pemeriksaan.no_pas=pasien.no_pas AND resep.no_resep=%s", GetSQLValueString($colname_resep, "text"));
$resep = mysql_query($query_resep, $koneksi) or die(mysql_error());
$row_resep = mysql_fetch_assoc($resep);
$totalRows_resep = mysql_num_rows($resep);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>cetak resep</title>
  <link id="bootstrap-style" href="assets/css/bootstrap.css" rel="stylesheet">
  <style type="text/css">
	.table th, .table td {
	    padding: 8px;
	    line-height: 20px;
	    text-align: left;
	    vertical-align: top;
	    border-top: none !important;
	}
	hr {
	    margin-top: 0px !important;
	    margin-bottom: 0px !important;
	    border-width: 1px 0px 0px;
	}
	.table th, .table td {
	    padding: 6px !important;
	}
  </style>
</head>

<body onload="window.print();">
  <div class="container">
	<div class="row">
	  <div class="col-md-6 col-md-offset-4" style="border: 1px solid #000;margin-top: 30px;">
		<div class="col-md-3">
			<img src="images/sejahtera.png" width="130" height="70" align="left" />
		</div>
		<div class="col-md-9">
			<p align="center"><strong>POLIKLINIK SEJAHTERA</strong><br>
			Jalan Bakti NO.01 Kec.Mojoagung - Kota Kediri<br>
			Telp (0354)786989912 | Email : <em>poliklinik_sejahtera@Gmail.com</em> </p>
		</div>
		<div class="col-md-12">
			<table class="table" style="border:none !important" width="100%" align="center">
			<tr><td colspan="3"><hr style="border:1px solid #000;"></td></tr>
			  <tr>
				<td width="115">NO Pasien</td>
				<td>:</td>
				<td><?php echo $row_resep['no_pas']; ?></td>
			  </tr>
			  <tr>
				<td>Nama Pasien</td>
				<td>:</td>
				<td><?php echo strtoupper($row_resep['nama_pas']); ?></td>
			  </tr>
			  <tr>
				<td colspan="3">R/ </td>
			  </tr>
			  <tr>
				<td>Obat </td>
				<td>:</td>
				<td><?php echo strtoupper($row_resep['merk']); ?> </td>
			  </tr>
			  <tr>
				<td>Tanggal :</td>
				<td>:</td>
				<td><?php echo date('d-F-Y'); ?></td>
			  </tr>
			</table>
		</div>
	  </div>
	</div>
  </div>
</body>
</html>
<?php
mysql_free_result($resep);
?>
