<link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<div style="margin: auto;width: 60%;padding: 10px;">
<a class="btn btn-danger" href="./client-menu.php">Atgal</a>

<h1>Klientai</h1>
<a class="btn btn-info" href="./client-add.php">Pridėti naują klientą</a>
<table class="table table-hover">
<tr><td><b>Vardas</b></td><td><b>Pavardė</b></td><td><b>El. paštas</b></td><td><b>Telefono numeris</b></td><td><b>Tipas</b></td><td><b>Redaguoti</b></td><td><b>Pašalinti</b></td></tr>
<?php
include("client-connect.php");
$q= "SELECT * FROM users WHERE type='klientas' ORDER BY name ASC";
//$result = mysql_query();
$query=mysqli_query($con,$q);
while($row = mysqli_fetch_array($query)) {
echo "<tr><td>" . $row['name'] . "</td><td>" . $row['surname'] . "</td><td>" . $row['email'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['type'] . "</td><td><a href='./client-edit.php?id=" . $row['userid'] . "'>Redaguoti</a></td><td><a href='./client-delete.php?id=" . $row['userid'] . "'>Pašalinti</a></td></tr>";
}
echo "</table>";
?>
</div>