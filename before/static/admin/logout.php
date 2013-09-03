<?php
session_start();

$_SESSION=array();
@session_regenerate_id();
$_SESSION['AdminID']="";
unset($_SESSION);
session_unset();
session_destroy();

echo "<script>document.location.href='index.php'</script>";
?>