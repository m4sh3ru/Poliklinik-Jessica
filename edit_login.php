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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE login SET `user`=%s, pass=%s, tipe_user=%s WHERE id=%s",
                       GetSQLValueString($_POST['user'], "text"),
                       GetSQLValueString(md5($_POST['pass']), "text"),
                       GetSQLValueString($_POST['tipe_user'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_koneksi, $koneksi);
  $Result1 = mysql_query($updateSQL, $koneksi) or die(mysql_error());

  $updateGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
 // header(sprintf("Location: %s", $updateGoTo));
 
 ?><script language="javascript">
  alert("Data Berhasil Diubah!");
  document.location.href='?page=login'  
  </script> <?php
}

$colname_edit_login = "-1";
if (isset($_GET['id'])) {
  $colname_edit_login = $_GET['id'];
}
mysql_select_db($database_koneksi, $koneksi);
$query_edit_login = sprintf("SELECT * FROM login WHERE id = %s", GetSQLValueString($colname_edit_login, "int"));
$edit_login = mysql_query($query_edit_login, $koneksi) or die(mysql_error());
$row_edit_login = mysql_fetch_assoc($edit_login);
$totalRows_edit_login = mysql_num_rows($edit_login);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="left">Id:</div></td>
      <td><div align="left"><?php echo $row_edit_login['id']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="left">User:</div></td>
      <td><div align="left">
        <input type="text" name="user" value="<?php echo htmlentities($row_edit_login['user'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="left">Password:</div></td>
      <td><div align="left">
        <input type="password" name="pass" value="" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="left">Tipe user:</div></td>
      <td><div align="left">
        <input type="text" name="tipe_user" value="<?php echo htmlentities($row_edit_login['tipe_user'], ENT_COMPAT, 'utf-8'); ?>" size="32" />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right"><div align="left"></div></td>
      <td><div align="left">
        <input type="submit" value="Ubah" class="button round blue image-right ic-edit text-upper" />
      </div></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id" value="<?php echo $row_edit_login['id']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($edit_login);
?>
