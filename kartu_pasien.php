<?php

include ('Connections/koneksi.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak kartu pasien</title>

<link id="bootstrap-style" href="assets/css/bootstrap.css" rel="stylesheet">
<style type="text/css">
body{
  font-size: 12px !important;
}
.table th, .table td {
    padding: 8px;
    line-height: 20px;
    text-align: left;
    vertical-align: top;
    border-top: none !important;
}
h1, h2, h3 {
    line-height: none !important;
}
.table th, .table td {
    padding: 4px !important;
}
</style>
</head>

<body onload="window.print();">
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
$no_pas=$_GET['no_pas'];
$query="select * from pasien where no_pas='$no_pas'";
$edit=mysql_query($query) or die(mysql_error());
$data=mysql_fetch_assoc($edit);
?>
<table class="table" style="width:400px; font-size:12x; border:1px solid #000;padding:100px 5px 5px 5px !important;" align="center">
  <tr>
    <td height="73" colspan="3" bgcolor="#99CC66">
      <div class="text-center">
        <h4 style="margin:0px">KARTU PASIEN</h4>
        <h3 align="center" style="margin:0px">POLIKLINIK SEJAHTERA</h3>
        <p align="center">Jalan Bakti NO.01 Kec.Mojoagung Kota Kediri</p>
      </div>
      <hr style="border-color:black !important;margin:0px;">
    </td>
  </tr>
  
  <tr style="border:none;">
    <td width="150" bgcolor="#99CC66"><strong>NO PASIEN</strong></td>
    <td bgcolor="#99CC66"><strong>:</strong></td>
    <td bgcolor="#99CC66"><?php echo $data['no_pas'];?></td>
  </tr>
  <tr>
    <td bgcolor="#99CC66"><strong>NAMA</strong></td>
    <td bgcolor="#99CC66"><strong>:</strong></td>
    <td bgcolor="#99CC66"><?php echo strtoupper($data['nama_pas']); ?></td>

  </tr>
  <tr>
    <td bgcolor="#99CC66"><strong>JENIS KELAMIN</strong></td>
    <td bgcolor="#99CC66"><strong>:</strong></td>
    <td bgcolor="#99CC66"><?php if ($data['jenis_kel']=='L') {
                                # code...
                                      echo "Laki-Laki";
                                    } else if ($data['jenis_kel']=='P'){
                                # code...
                                      echo "Perempuan";
                                    } else {
                                    echo " ";
                                    }; ?></td>
  </tr>
  <tr>
    <td bgcolor="#99CC66"><strong>ALAMAT</strong></td>
    <td bgcolor="#99CC66"><strong>:</strong></td>
    <td bgcolor="#99CC66"><?php echo $data['alamat_pas']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#99CC66"><strong>TGL PENDAFTARAN</strong></td>
    <td bgcolor="#99CC66"><strong>:</strong></td>
    <td bgcolor="#99CC66"><?php echo $data['tgl_registrasi']; ?></td>
  </tr>
  <tr>
    <td bgcolor="#99CC66" colspan="3"><strong>Perhatian:</strong><br> <em>Kartu ini harap dibawa pada saat melakukan <br>pemeriksaan di Poliklinik Sejahtera</em></td>
  </tr>
</table>
<div align="center"><button type="button" onclick="window.print()" value="cetak" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-print"></span> Cetak Kartu Pasien</button>
</body>
</html>
