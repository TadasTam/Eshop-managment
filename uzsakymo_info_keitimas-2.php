<html>  
      <head>  
           <title>Peržiūrėjimas apklausos temų</title>  
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		   <title>Užsakymo informacija</title>
  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		   <link rel="stylesheet" href="css/style.css">  
		   <script src="path-to/js/bootstrap-select.min.js"></script>

		   <style>
				h5.align-left {
					text-align:left;
					padding-left: 60px;
				}
			</style>
      </head>  
 </html> 

<?php
	session_start();
	include "include/nustatymai.php";
	$userlevel=$_SESSION['ulevel'];
	$userid = $_SESSION['userid'];
	$dbc= new mysqli("localhost", "stud", "stud", "vartvald");

	if ($_SESSION['user'] == "guest")
 	{ 	
		$_SESSION['kicked'] = 'yes';
		$_SESSION['message'] = 'Bandėte patekti į uzsakymo_info_keitimas-2.php puslapį, tačiau tam neturite privilegijų';
		header("Location: logout.php");
		exit;
	}

	$previous_page = $_SESSION['prev'];
	$id = $_GET['id'];
	$sql_owner_of_order = "SELECT * FROM pirkimai INNER JOIN pristatymai ON pirkimai.fk_pristatymo_id = pristatymai.id WHERE pirkimai.id = $id";
	$result = mysqli_query($dbc, $sql_owner_of_order);
	$owner_of_order = mysqli_fetch_assoc($result);
	$shipmment_id = $owner_of_order['fk_pristatymo_id'];

	if(($userid != $owner_of_order['fk_vartotojas_id']) && (($userlevel != $user_roles["Darbuotojas"]) && ($userlevel != $user_roles[ADMIN_LEVEL]))) {
		$_SESSION['kicked'] = 'yes';
		$_SESSION['message'] = 'Bandėte patekti į kito žmogaus uzsakymo_info_keitimas-2.php puslapį, tačiau tam neturite privilegijų';
		header("Location: logout.php");
		exit;
	}

	if($owner_of_order['statusas'] != 1 && (($userlevel != $user_roles["Darbuotojas"]) && ($userlevel != $user_roles[ADMIN_LEVEL]))) {
		$_SESSION['kicked'] = 'yes';
		$_SESSION['message'] = 'Bandėte patekti į savo pristatymo redagavimą po leidžiamo laiko, tačiau tam neturite privilegijų';
		header("Location: logout.php");
		exit;
	}

    echo "<table width=100% border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"meniu\">";
	echo "<tr><td>";
	echo "</td></tr><tr><td>";
	echo "<form method='post' action='".$previous_page.".php' style='display:inline'><input type='submit' value='Grįžti' class='btn btn-danger' name='btn1'></form> &nbsp;&nbsp;";
    echo "</td></tr></table>";

	echo "<center><div class='container mt-5'>";
	echo "<h1 style='text-aling:left'>Užsakymo ID: ".$id." informacijos redagavimas</h1><br>";
	
	$sql = "SELECT p.id, p.data, p.kaina, p.prekiu_kiekis, p.fk_pristatymo_id, budai.budas FROM pirkimai AS p INNER JOIN apmokejimas AS a ON p.fk_apmokejimo_budo_id = a.id INNER JOIN apmokejimo_budai AS budai ON a.apmokejimo_budas = budai.id WHERE p.id = $id ORDER BY p.data DESC";
	$result = mysqli_query($dbc, $sql);
	
	while($row = mysqli_fetch_assoc($result))
	{
		$sql_for_time = "SELECT data FROM pristatymai WHERE id = ".$row['fk_pristatymo_id']."";
		$time_result = mysqli_query($dbc, $sql_for_time);
		$delivery_time = mysqli_fetch_assoc($time_result);
		echo "<form method='post'><div><label>Pristatymo norimas laikas</label><input type='datetime-local' class='form-control' step='any' name='data' placeholder='Pristatymo normas laikas' required value='".$delivery_time['data']."'/></div>";

		$shippment_id = $row['fk_pristatymo_id'];
		$sql_for_shippment_information = "SELECT * FROM pristatymai INNER JOIN statusai ON pristatymai.statusas = statusai.id WHERE pristatymai.id = $shippment_id";
    	$array_result_shippment = mysqli_query($dbc, $sql_for_shippment_information);
		$shippment_information = mysqli_fetch_assoc($array_result_shippment);
		echo "<div class='form-group'><label>Pristatymo adresas</label><input required type='text' class='form-control' name='adresas' placeholder='Pristatymo adresas' value='".$shippment_information['adresas']."' /></div>";		
	} 

	echo "<div class='form-group'><input type='submit' value='Atnaujinti' name='btn' class='btn btn-danger'></div></form>";

	if(isset($_POST['btn']))
    {
		$_SESSION['prev'] = 'uzsakymo_info_keitimas-2';
        $datetime = $_POST['data'];
		$shippment_address = $_POST['adresas'];

		$sql_for_shippment = "UPDATE pristatymai SET data = '$datetime', adresas = '$shippment_address' WHERE id = $shipmment_id";
        $query=mysqli_query($dbc, $sql_for_shippment);

		$_SESSION['message'] = 'Sėkmingai atnaujinta';
		$_SESSION['header'] = 'yes';

        header("location:".$previous_page.".php");
    } 
?>