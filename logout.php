<?php
// logout.php naikina sesija ir cookius
session_start();

$message = '';
if(isset($_SESSION['message']) && $_SESSION['kicked']) {
    $message = $_SESSION['message'];
}
//echo "sesija:".$_SESSION['prev'];
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();

if($message != '') {
    header("Location:index.php?message=".$message."");
}
else {
    header("Location:index.php");
}

exit;
?>