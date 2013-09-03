<?php
session_start();
include("../../config.php");
if(!empty($_SESSION['AdminID']))
{
	echo "<script>document.location.href='index.php'</script>";
}
$adminlogin = $_REQUEST['adminlogin'];
$admin_loginid = $_REQUEST['admin_loginid'];
$admin_loginpassword = $_REQUEST['admin_loginpassword'];

if(isset($adminlogin))
{
	$sql = "select * from admin where admin_loginid='$admin_loginid' and admin_loginpassword='".md5($admin_loginpassword)."'";
	$re = mysql_query($sql) or die("Internal Error");
	if(mysql_num_rows($re) > 0)
	{
		$row = mysql_fetch_array($re);
		$_SESSION['AdminID'] = $row['id'];
		echo "<script>document.location.href='index.php'</script>";
	}
	else
	{
		$err = "Invalid login id or password.";
	}
	
}
?>
<!DOCTYPE HTML>
<html>

<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
       <link rel='stylesheet' href="../vitumob.css">
<link rel="shortcut icon" href="../favicon.ico">
<script language="javascript" src="../jquery.js"></script>
<script>
function changestatus(cartid,mode,col,idtype)
{
	location.href='index.php?viewid=<?php echo $_REQUEST['viewid']?>&cartid='+cartid+'&col='+col+'&idtype='+idtype+'&mode='+mode;
}
</script>
</head>

<body>
<?php
 if(empty($_REQUEST['viewid']))
 {
?>
<div id='header'>
    <img id='logo' src="../../images/logo.png">
</div>
<?php }?>


<div id='main' class='' style="margin-top:20px;">
<form id='loginForm' method='POST' name="loginForm">

  <table width="323" border="0" bgcolor="#FFFFFF" cellpadding="1" cellspacing="1" style="border:1px solid #999999">
  <tr>
    <td colspan="2" align="left" bgcolor="#FFFFFF"><strong>Login</strong></td>
    </tr>
  <?php if(isset($err)){?>
  <tr>
    <td colspan="2" align="center" bgcolor="#FFFFFF" style="color:#FF0000"><?php echo $err;?>&nbsp;</td>
    </tr>
   <?php }?> 
  <tr>
    <td width="130" align="center" bgcolor="#FFFFFF">Login ID:</td>
    <td width="184" align="center" bgcolor="#FFFFFF"><input type="text" name="admin_loginid" value="<?php echo $admin_loginid?>">&nbsp;</td>
    </tr>

   
	<tr>
    <td align="center" valign="top" >Password :&nbsp;</td>
    <td align="center" valign="top" ><input type="password" name="admin_loginpassword" value="<?php echo $admin_loginpassword?>">&nbsp;</td>
    </tr>
	<tr>
	  <td align="center" valign="top" >&nbsp;</td>
	  <td align="center" valign="top" ><input type="submit" name="adminlogin" value="Login">&nbsp;</td>
	  </tr>
</table>

</form>





</div>

<div id='bottom-bar'>
    <span>&copy;2013 VituMob</span>
    <span><a href='http://www.vitumob.com/faq'>FAQ</a></span>
    <span><a href='http://www.vitumob.com/privacy'>privacy</a></span>
    <span><a href='http://www.vitumob.com/returns'>returns</a></span>
</div>

</body>

</html>