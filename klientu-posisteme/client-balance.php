<link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<div class="center" style=" margin: auto;width: 60%;padding: 10px;">
<table class="center" style=" width:75%; border-width: 2px;">
<tr><td width=30%><a class='btn btn-info' href="./client-menu.php">Atgal</a></td><td width=30%> 
</table>
<h1>Jūsų sąskaitos balansas</h1>

<?php
include("client-connect.php");
session_start();
$userid=$_SESSION['userid'];
$sql = "SELECT * FROM users us INNER JOIN saskaita sk ON us.userid = sk.client WHERE us.userid='$userid'";
$result = $con->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Sąskaitos likutis: " . $row["amount"]. " €";
    }
} else {
    echo "Sąskaita nerasta";
}
$con->close();
?>

</div>