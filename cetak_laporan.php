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

$colname_cetak_laporan = "-1";
if (isset($_GET['no_pemeriksaan'])) {
	$colname_cetak_laporan = $_GET['no_pemeriksaan'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_cetak_laporan = sprintf("SELECT pemeriksaan.no_pemeriksaan, pemeriksaan.no_pas, pasien.nama_pas, pasien.alamat_pas, pasien.tgl_lhr, pasien.jenis_kel, pemeriksaan.keluhan, pemeriksaan.diagnosa, pemeriksaan.perawatan, pemeriksaan.tindakan, pemeriksaan.berat_badan, pemeriksaan.tensi_diastolik, pemeriksaan.tensi_sistolik FROM pemeriksaan, pasien WHERE  no_pemeriksaan = %s AND pemeriksaan.no_pas=pasien.no_pas", GetSQLValueString($colname_cetak_laporan, "text"));
$cetak_laporan = mysql_query($query_cetak_laporan, $koneksi) or die(mysql_error());
$row_cetak_laporan = mysql_fetch_assoc($cetak_laporan);
$totalRows_cetak_laporan = mysql_num_rows($cetak_laporan);
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

	.table th, .table td {
			padding: 6px !important;
	}
	.table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
	    border: none !important;
	}
	.table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
	    border-bottom-width: 1px !important;
	}
	hr {
	    margin-top: 20px;
	    margin-bottom: 20px;
	    
	}
	</style>
</head>

<body onload="window.print();">
	<div class="container" style="margin-bottom:100px;">
		<div class="row">
		  	<div class="col-md-8 col-md-offset-2" style="border: 1px solid #DDD; margin-top: 30px;">
		  		<div class="row">
		  			<div class="col-md-12">
			  			<div class="col-md-3">
			  				<p align="center"><img src="images/sejahtera.png" width="168" height="87" align="left" /></p>
					
			  			</div>
			  			<div class="col-md-9">
			  				<p align="center"><strong>POLIKLINIK SEJAHTERA</strong><br>
							Jalan Bakti NO.01 Kec.Mojoagung - Kota Kediri<br>
							Telp (0354)786989912 | Email : <em>poliklinik_sejahtera@Gmail.com</em>
							</p>						
			  			</div>
			  		</div>
		  		</div>
				<div class="row">
					<div class="col-md-12">
					<hr>
						<div class="col-md-3">
							<img src="images/img1.jpg" height="200" />
						</div>
						<div class="col-md-6 col-md-offset-1">
							<table class="table">
								<tr>
									<th width="150">No Pasien</th>
									<td>:</td>
									<td><?php echo $row_cetak_laporan['no_pas']; ?></td>
								</tr>
								<tr>
									<td><strong>Nama Pasien</strong></td>
									<td>:</td>
									<td><?php echo $row_cetak_laporan['nama_pas']; ?></td>
								</tr>
								<tr>
									<td><strong>Alamat Pasien</strong></td>
									<td>:</td>
									<td><?php echo $row_cetak_laporan['alamat_pas']; ?></td>
								</tr>
								<tr>
									<td><strong>Tgl lahir Pasien</strong></td>
									<td>:</td>
									<td><?php echo $row_cetak_laporan['tgl_lhr']; ?></td>
								</tr>
								<tr>
									<td><strong>Jenis Kelamin</strong></td>
									<td>:</td>
									<td><?php echo $row_cetak_laporan['jenis_kel']; ?></td>
								</tr>
							</table>
						</div>
						<div class="col-md-2">
							<h4><?php echo $row_cetak_laporan['no_pemeriksaan']; ?></h4>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-10">
							<table class="table table-bordered" style="margin-top: 20px;">
							<thead>
								<tr>
									<th colspan="3">
										<h5><strong>Hasil Pemeriksaan</strong></h5>
									</th>
								</tr>
							</thead>
							<tr>
								<td width="150">Keluhan</td>
								<td width="40">:</td>
								<td><?php echo $row_cetak_laporan['keluhan']; ?></td>
							</tr>
							<tr>
								<td>Diagnosa</td>
								<td>:</td>
								<td><?php echo $row_cetak_laporan['diagnosa']; ?></td>
							</tr>
							<tr>
								<td>Perawatan</td>
								<td>:</td>
								<td><?php echo $row_cetak_laporan['perawatan']; ?></td>
							</tr>
							<tr>
								<td>Tindakan</td>
								<td>:</td>
								<td><?php echo $row_cetak_laporan['tindakan']; ?></td>
							</tr>
							<tr>
								<td>Berat Badan</td>
								<td>:</td>
								<td><?php echo $row_cetak_laporan['berat_badan']; ?></td>
							</tr>
							<tr>
								<td>Tensi Diastolik</td>
								<td>:</td>
								<td><?php echo $row_cetak_laporan['tensi_diastolik']; ?></td>
							</tr>
							<tr>
								<td>Tensi Sistolik</td>
								<td>:</td>
								<td><?php echo $row_cetak_laporan['tensi_sistolik']; ?></td>
							</tr>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
<?php
mysql_free_result($cetak_laporan);
?>
