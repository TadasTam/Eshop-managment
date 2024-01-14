<html>  
      <head>  
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		   <title>Pristatymų ir užsakymų informacija</title>
  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		   <link rel="stylesheet" href="css/style.css">  
      </head>  
 </html> 

<?php
	session_start();
	include "include/nustatymai.php";

	if ($_SESSION['user'] == "guest")
 	{ 	
		$_SESSION['kicked'] = 'yes';
		$_SESSION['message'] = 'Bandėte patekti į pristatymas.php puslapį, tačiau tam neturite privilegijų';
		header("Location: logout.php");
		exit;
	}

	$userlevel=$_SESSION['ulevel'];
	$_SESSION['prev'] = 'pristatymas';

    echo "<table width=100% border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"meniu\">";
	echo "<tr><td>";
	echo "</td></tr><tr><td>";
	echo "<form method='post' action='index.php' style='display:inline'><input type='submit' value='Grįžti' class='btn btn-danger' name='btn1'></form> &nbsp;&nbsp;";
	
	if(($userlevel == $user_roles["Administratorius"]) || ($userlevel == $user_roles["Darbuotojas"])) {
		echo "<form method='post' action='uzsakymu_redagavimas.php' style='display:inline'><input type='submit' value='Darbuotojo sąsaja' class='btn btn-danger' name='btn1'></form> &nbsp;&nbsp;";
	}
	
	echo "<center><h1>Tavo užsakymai</h1></center>";
    echo "</td></tr></table>";

	$dbc= new mysqli("localhost", "root", "", "vartvald");
	$userid = $_SESSION['userid'];
	$sql = "SELECT p.id, p.data, p.kaina, p.prekiu_kiekis, p.fk_pristatymo_id, budai.budas  FROM pirkimai AS p INNER JOIN apmokejimas AS a ON p.fk_apmokejimo_budo_id = a.id INNER JOIN apmokejimo_budai AS budai ON a.apmokejimo_budas = budai.id WHERE fk_vartotojas_id = '$userid' ORDER BY p.data DESC";
    
	$result = mysqli_query($dbc, $sql);
	if(mysqli_num_rows($result) <= 0) {
		echo "<center><h1>Nėra nei vieno užsakymo</h1></center>";
		return;
	}

	echo "<table style='width:50%' align='center' class='table table-bordered table-dark'>";
	echo "<tr>
	<th>Užsakymo data</th>
	<th>Bendra kaina</th>
	<th>Prekių kiekis</th>
	<th>Mokėjimo būdas</th>
	<th>Užsakymo statusas</th>
	<th>Pristatymo adresas</th>
	<th colspan='2'>Papildoma informacija</th>
	</tr>";
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<tr><td>".$row['data']."</td>";
		echo "<td>".$row['kaina']."</td>";
		echo "<td>".$row['prekiu_kiekis']."</td>";
		echo "<td>".$row['budas']."</td>";

		$shippment_id = $row['fk_pristatymo_id'];
		$sql_for_shippment_information = "SELECT * FROM pristatymai INNER JOIN statusai ON pristatymai.statusas = statusai.id WHERE pristatymai.id = $shippment_id";
    	$array_result_shippment = mysqli_query($dbc, $sql_for_shippment_information);
		$shippment_information = mysqli_fetch_assoc($array_result_shippment);

		echo "<td>".$shippment_information['statusas']."</td>";
		echo "<td>".$shippment_information['adresas']."";
		echo "<td><a href='detalesne_informacija_uzsakymo.php?id=".$row['id']."'>Detalesnė informacija</a></td>";

		if($shippment_information['statusas'] == "Užsakyta") {
			echo "<td><a href='uzsakymo_info_keitimas-2.php?id=".$row['id']."'>Užsakymo informacijos keitimas</a></td>";
		}
	} 
	echo "</table>";

	if(isset($_SESSION['message']) && isset($_SESSION['header']) && $_SESSION['header'] == "yes") {
		echo "<center><h3 style='color: green'>".$_SESSION['message']."</h3></center>";
		$_SESSION['message'] = '';
		$_SESSION['header'] = 'no';
	}
?>