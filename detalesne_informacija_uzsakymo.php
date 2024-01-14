

<html>  
      <head>  
           <title>Peržiūrėjimas apklausos temų</title>  
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		   <title>Užsakymo redagavimas</title>
  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		   <link rel="stylesheet" href="css/style.css">  

		   <style>
				h5.align-left {
					text-align:left;
					padding-left: 40px;
				}
			</style>
      </head>  
 </html> 

<?php
	session_start();
	include "include/nustatymai.php";
	$userlevel=$_SESSION['ulevel'];
	$userid = $_SESSION['userid'];

	if ($_SESSION['user'] == "guest")
 	{ 	
		$_SESSION['kicked'] = 'yes';
		$_SESSION['message'] = 'Bandėte patekti į detalesne_informacija_uzsakymo.php puslapį, tačiau tam neturite privilegijų';
		header("Location: logout.php");
		exit;
	}

	$dbc= new mysqli("localhost", "root", "", "vartvald");
	$id = $_GET['id'];
	$sql_owner_of_order = "SELECT fk_vartotojas_id FROM pirkimai WHERE id = $id";
	$result = mysqli_query($dbc, $sql_owner_of_order);
	$owner_of_order = mysqli_fetch_assoc($result)['fk_vartotojas_id'];
	if(($userid != $owner_of_order) && (($userlevel != $user_roles["Darbuotojas"]) && ($userlevel != $user_roles[ADMIN_LEVEL]))) {
		$_SESSION['kicked'] = 'yes';
		$_SESSION['message'] = 'Bandėte patekti į kito žmogaus detalesne_informacija_uzsakymo.php puslapį, tačiau tam neturite privilegijų';
		header("Location: logout.php");
		exit;
	}

	$previous_page = $_SESSION['prev'];
	$_SESSION['prev'] = 'detalesne_informacija_uzsakymo';
    

    echo "<table width=100% border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"meniu\">";
	echo "<tr><td>";
	echo "</td></tr><tr><td>";
	echo "<form method='post' action='".$previous_page.".php' style='display:inline'><input type='submit' value='Grįžti' class='btn btn-danger' name='btn1'></form> &nbsp;&nbsp;";
    echo "</td></tr></table>";

	echo "<center><div style='width:50%; display:inline-block;'>";
	echo "<h1 style='text-aling:left'>Užsakymo ID: ".$id." detalesnė informacija</h1><br>";
	
	$userid = $_SESSION['userid'];
	$sql = "SELECT p.id, p.data, p.kaina, p.prekiu_kiekis, p.fk_pristatymo_id, budai.budas  FROM pirkimai AS p INNER JOIN apmokejimas AS a ON p.fk_apmokejimo_budo_id = a.id INNER JOIN apmokejimo_budai AS budai ON a.apmokejimo_budas = budai.id WHERE p.id = $id ORDER BY p.data DESC";
    
	$result = mysqli_query($dbc, $sql);
	
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<h5 class='align-left'>Užsakymo data: ".$row['data']."</h3><br>";
		echo "<h5 class='align-left'>Bendra užsakymo kaina: ".$row['kaina']."</h3><br>";
		echo "<h5 class='align-left'>Bendras prekių kiekis: ".$row['prekiu_kiekis']."</h3><br>";
		echo "<h5 class='align-left'>Mokėjimo būdas: ".$row['budas']."</h3><br>";

		$shippment_id = $row['fk_pristatymo_id'];
		$sql_for_shippment_information = "SELECT * FROM pristatymai INNER JOIN statusai ON pristatymai.statusas = statusai.id WHERE pristatymai.id = $shippment_id";
    	$array_result_shippment = mysqli_query($dbc, $sql_for_shippment_information);
		$shippment_information = mysqli_fetch_assoc($array_result_shippment);

		echo "<h5 class='align-left'>Užsakymo statusas: ".$shippment_information['statusas']."</h3><br>";
		echo "<h5 class='align-left'>Pristatymo adresas: ".$shippment_information['adresas']."</h3><br>";		
	} 

	$sql = "SELECT prekes.pavadinimas, prekes.Pardavimo_kaina, ppt.pirktas_kiekis FROM prekes INNER JOIN preke_pirkimai_tarpinis AS ppt ON prekes.id = ppt.fk_preke_id WHERE ppt.fk_pirkimas_id = $id";
	$result = mysqli_query($dbc, $sql);

	echo "<center><h1>Užsakytos prekės</h1><br></center>";
	echo "<table style='width:50%' align='center' class='table table-bordered table-dark'>";
	echo "<tr>
	<th>Užsakyta prekė</th>
	<th>Kiekis</th>
	<th>Kaina</th>
	</tr>";
	while($row = mysqli_fetch_assoc($result))
	{
		$total_price = $row['pirktas_kiekis'] * $row['Pardavimo_kaina'];
		echo "<tr><td>".$row['pavadinimas']."</td>";
		echo "<td>".$row['pirktas_kiekis']."</td>";
		echo "<td>".$total_price."</td>";
	} 
	echo "</table>";

	echo "</div></center>";

	
?>