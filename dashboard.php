<?php 
if(!isset($_SESSION)) {
session_start();
}

if(empty($_SESSION['user'])) {
header('location:login_poliklinik.php');
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Poliklinik Sejahtera</title>
	
	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
	<link rel="stylesheet" href="css/style.css">		
	<!-- Optimize for mobile devices -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- jQuery & JS files -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="js/script.js"></script>  
    <style type="text/css">
<!--
.style2 {color: #999999}
-->
    </style>
</head>
<body>

	<!-- TOP BAR -->
	<div id="top-bar">
		
		<div class="page-full-width cf">

			<ul id="nav" class="fl">
			  <li class="v-sep"><a href="#" class="round button dark menu-user image-left">Logged in as <strong><?php echo $_SESSION['user']; ?></strong></a>
				</li>
			
				<li><a href="logout.php" class="round button dark menu-logoff image-left" onClick="return confirm('Anda yakin keluar dari halaman ini !')">Log out</a></li>
			</ul> 
      <!-- end nav -->

					
			<form action="cek_login3.php" method="POST" id="search-form" class="fr">
				<fieldset>
					<input type="text" id="search-keyword" class="round button dark ic-search image-right" placeholder="Search..." />
					<input type="hidden" value="SUBMIT" />
				</fieldset>
			</form>

		</div> <!-- end full-width -->	
	
	</div> <!-- end top-bar -->
	
	
	
	<!-- HEADER -->
	<div id="header-with-tabs">
		
		<div class="page-full-width cf">
<!-- end tabs -->
			
			<!-- Change this image to your own company's logo -->
			<!-- The logo will automatically be resized to 30px height. -->
			<a href="#" id="company-branding-small" class="fr"><img src="images/sejahtera.png" alt="Blue Hosting" width="124" height="100" /></a>		</div> 
	  <!-- end full-width -->	

	</div> <!-- end header -->
	
	
	
	<!-- MAIN CONTENT -->
	<div id="content">
		
		<div class="page-full-width cf">

			<div class="side-menu fl">
				
				<h3>Side Menu</h3>
				<ul>
                	<?php if ($_SESSION['tipe_user']=='admin') {?>
						<li><a href="?page=pegawai">Pegawai</a></li>
                   		<li><a href="?page=poliklinik">Poliklinik</a></li>
						<li><a href="?page=dokter">Dokter</a></li>
						<li><a href="?page=jadwal_praktek">Jadwal Praktek</a></li>					 
						<li><a href="?page=login">User</a></li>
					<?php } else if ($_SESSION['tipe_user']=='pegawai') {?>
                    	<li><a href="?page=pendaftaran">Pendaftaran</a></li>
						<li><a href="?page=pasien">Pasien</a></li>
                        <li><a href="?page=jenis_biaya">Jenis Biaya</a></li>
                        <?php } else if ($_SESSION['tipe_user']=='dokter') {?>
                    	<li><a href="?page=pemeriksaan">Pemeriksaan</a></li>
                         <li><a href="?page=resep">Resep</a></li>
                    <?php } else { ?>
                    <li><a href="?page=obat">Obat</a></li>
                    <li><a href="?page=resep">Resep</a></li>
                    	
                       
                        
                    <?php } ?>
			  </ul>
				
			</div> <!-- end side-menu -->
			
			<div class="side-content fr">
			
				<?php
				if (isset($_GET['page'])) {
				     $get=htmlentities($_GET['page']);
				     $page=$get.".php";
				     $cek=strlen($page);

				     if($cek<=0 || !file_exists($page) || empty($page)) {
				                  echo  "Halaman yang dicari tidak ada";  
					 }else {
				                   include ($page);}
				} else {
					echo  "<h1>Selamat Datang</h1>";
				}
				?>

		
			</div> <!-- end side-content -->
		
		</div> <!-- end full-width -->
			
	</div> <!-- end content -->
	
	
	
	<!-- FOOTER -->
	<div id="footer">

		<p>&copy; Copyright 2016.<strong>POLI<span class="style2">KLINIK</span></strong> <em>Sejahtera</em></p>
	  <p><strong>Jessica aisyah khumairoh</strong></p>
	
</div> <!-- end footer -->

</body>
</html>
