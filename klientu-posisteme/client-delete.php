<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<div style="margin: auto;width: 60%;padding: 10px;">

<?php
$clientid=$_GET['id'];
include("client-connect.php");
$q= "SELECT * FROM users WHERE userid='$clientid'";
$query=mysqli_query($con,$q);
$row = mysqli_fetch_array($query);
?>
<h1>Ar tikrai norite pašalinti klientą <?php echo $row['name'] . " " . $row['surname']; ?>?</h1>
<table class="center" style=" width:75%; border-width: 2px; border-style: dotted;">
<tr><td width=30%><a class="btn btn-danger" href="./client-list.php">NE</a></td><td width=30%>
<a class="btn btn-success" href="./client-delete.php?id=<?php echo $clientid; ?>&sure=yes">taip</a></td></tr>
</table>
<?php
if($_GET['sure']??""=="yes"){
$q= "DELETE FROM users WHERE userid='$clientid'";
$query=mysqli_query($con,$q);
send_deletion_email($row['email'], $row['name'], $row['surname']);
header("Location: client-list.php");
}

function send_deletion_email($email, $name, $surname){
    $to = $email;
    $subject = "Kliento pašalinimas";
    $txt = "Sveiki, " . $name . " " . $surname . ". Jūsų paskyra buvo pašalinta.";
    $headers = "From:
";
    mail($to,$subject,$txt,$headers);
}
?>
</div>