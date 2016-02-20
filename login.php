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

$maxRows_login = 10;
$pageNum_login = 0;
if (isset($_GET['pageNum_login'])) {
  $pageNum_login = $_GET['pageNum_login'];
}
$startRow_login = $pageNum_login * $maxRows_login;

mysql_select_db($database_koneksi, $koneksi);
$query_login = "SELECT * FROM login";
$query_limit_login = sprintf("%s LIMIT %d, %d", $query_login, $startRow_login, $maxRows_login);
$login = mysql_query($query_limit_login, $koneksi) or die(mysql_error());
$row_login = mysql_fetch_assoc($login);

if (isset($_GET['totalRows_login'])) {
  $totalRows_login = $_GET['totalRows_login'];
} else {
  $all_login = mysql_query($query_login);
  $totalRows_login = mysql_num_rows($all_login);
}
$totalPages_login = ceil($totalRows_login/$maxRows_login)-1;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
<!--
.style2 {color: #181B1D; }
-->
</style>
</head>

<body>
<table border="1">
  <tr>
    <td bgcolor="#333333"><div align="center" class="style2">Id</div></td>
    <td bgcolor="#333333"><div align="center" class="style2">User</div></td>
    <td bgcolor="#333333"><div align="center" class="style2">Password</div></td>
    <td bgcolor="#333333"><div align="center" class="style2">Tipe user</div></td>
    <td colspan="2" bgcolor="#333333"> <div align="center" class="style2">Aksi</div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><div align="center"><?php echo $row_login['id']; ?></div></td>
      <td><div align="center"><?php echo $row_login['user']; ?></div></td>
      <td><div align="center"><?php echo $row_login['pass']; ?></div></td>
      <td><div align="center"><?php echo $row_login['tipe_user']; ?></div></td>
      <td><a href="?page=edit_login&id=<?php echo $row_login['id']; ?>" class="button round blue image-right ic-edit text-upper">Edit</a></td>
      <td><a href="?page=del_login&id=<?php echo $row_login['id']; ?>" class="button round blue image-right ic-delete text-upper">Delete</a></td>
    </tr>
    <?php } while ($row_login = mysql_fetch_assoc($login)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($login);
?>
