<?php
$clientid=$_GET['id'];
include("client-connect.php");
$q= "SELECT * FROM users WHERE userid='$clientid'";
$query=mysqli_query($con,$q);
$row = mysqli_fetch_array($query);
?>
<link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<div style="margin: auto;width: 60%;padding: 10px;">
<table>
<tr><td width=30%><a class="btn btn-danger" href="./client-list.php">Atgal</a></td><td width=30%>
</table>

<form type="post" action="client-edit.php">
<table>
<tr><td>Vardas:</td><td><input type="text" name="name" value="<?php echo $row['name']; ?>"></td></tr>
<tr><td>Pavardė:</td><td><input type="text" name="surname" value="<?php echo $row['surname']; ?>"></td></tr>
<tr><td>El. paštas:</td><td><input type="text" name="email" value="<?php echo $row['email']; ?>"></td></tr>
<tr><td>Telefono numeris:</td><td><input type="text" name="phone" value="<?php echo $row['phone']; ?>"></td></tr>
<tr><td>Kliento id:</td><td><input type="text" readonly name="id" value="<?php echo $row['userid']; ?>"></td></tr>
</table>
<input type="submit" value="Redaguoti">
</form>

<?php
if($_GET['name']??""!="" && $_GET['surname']??""!="" && $_GET['email']??""!="" && $_GET['phone']??""!=""){
    $name=$_GET['name'];
    $surname=$_GET['surname'];
    $email=$_GET['email'];
    $phone=$_GET['phone'];
    $q= "UPDATE users SET name='$name', surname='$surname', email='$email', phone='$phone' WHERE userid='$clientid'";
    $query=mysqli_query($con,$q);
    header("Location: client-list.php");
}
?>

</div>