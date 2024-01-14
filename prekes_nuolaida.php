<html>
  
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

table.center {
  margin-left: auto; 
  margin-right: auto;
}
</style>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
      
    <title>Update List</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
  
<body>
    <div class="container mt-5">
                        <form action="operacija1.php">
			<div class="text-center">
                <input type="submit" 
                    value="Grįžti" 
                    class="btn btn-danger" 
                    name="btn1">
            </div>  
			</form>
    </div>
	<center>
	<h3> Geriausios mūsų nuolaidos!</h3>
	<center/>
</body>
  
</html>
<?php
    include("prekes_db_connect.php");
	$dbc=mysqli_connect("localhost","root","", "vartvald");
	if(!$dbc){ die ("Negaliu prisijungti prie MySQL:".mysqli_error($dbc)); }
	$sql = "SELECT * FROM prekes ORDER BY 5 DESC";
	$result = mysqli_query($dbc, $sql);
	echo "";
	echo "<table class=center>";
	echo "<tr>
	<th>Pavadinimas</th>
	<th>Kaina</th>
	<th>Nuolaida</th>
	</tr>";
	while($row = mysqli_fetch_assoc($result))
	{
		if ($row['Nuolaida']==NULL)
			$nuolaida = 0;
		else
			$nuolaida = $row['Nuolaida'];
		echo "<tr>
		<td>".$row['pavadinimas']."</td>
		<td>".$row['Pardavimo_kaina']."€"."</td>
		<td>".$nuolaida."%"."</td>
		</tr>";
	}
	echo "</table>";
	echo "<br>";
	         if(isset($_POST["btn1"])) {
			 header("location:operacija1.php");
		 }
?>
