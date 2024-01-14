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

	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';
	require 'phpmailer/src/SMTP.php';

	$userlevel=$_SESSION['ulevel'];
	$previous_page = $_SESSION['prev'];

	if(($userlevel != $user_roles["Darbuotojas"]) && ($userlevel != $user_roles[ADMIN_LEVEL])) {
		$_SESSION['kicked'] = 'yes';
		$_SESSION['message'] = 'Bandėte patekti į uzsakymo_info_keitimas.php puslapį, tačiau tam neturite privilegijų';
		header("Location: logout.php");
		exit;
	}

	$id = $_GET['id'];

    echo "<table width=100% border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"meniu\">";
	echo "<tr><td>";
	echo "</td></tr><tr><td>";
	echo "<form method='post' action='".$previous_page.".php' style='display:inline'><input type='submit' value='Grįžti' class='btn btn-danger' name='btn1'></form> &nbsp;&nbsp;";
    echo "</td></tr></table>";

	echo "<center><div class='container mt-3'>";
	echo "<h1 style='text-aling:left'>Užsakymo ID: ".$id." informacijos redagavimas</h1><br>";
	$dbc= new mysqli("localhost", "root", "", "vartvald");
	$userid = $_SESSION['userid'];
	$sql = "SELECT p.id, p.data, p.kaina, p.prekiu_kiekis, p.fk_pristatymo_id, p.fk_apmokejimo_budo_id, budai.budas FROM pirkimai AS p INNER JOIN apmokejimas AS a ON p.fk_apmokejimo_budo_id = a.id INNER JOIN apmokejimo_budai AS budai ON a.apmokejimo_budas = budai.id WHERE p.id = $id ORDER BY p.data DESC";
	$result = mysqli_query($dbc, $sql);
	$shippment_id = -1;
	$payment_type_table_id = -1;
	
	while($row = mysqli_fetch_assoc($result))
	{
		$shippment_id = $row['fk_pristatymo_id'];
		$payment_type_table_id = $row['fk_apmokejimo_budo_id'];
		$sql_for_shippment_information = "SELECT * FROM pristatymai INNER JOIN statusai ON pristatymai.statusas = statusai.id WHERE pristatymai.id = $shippment_id";
    	$array_result_shippment = mysqli_query($dbc, $sql_for_shippment_information);
		$shippment_information = mysqli_fetch_assoc($array_result_shippment);

		echo "<form method='post'><div><label>Pristatymo norimas laikas</label><input required type='datetime-local' class='form-control' step='any' name='data' placeholder='Pristatymo norimas laikas' value='".$shippment_information['data']."'/></div>";
		echo "<div class='form-group'><label>Bendra užsakymo kaina</label><input required min='0' step='0.01' type='number' class='form-control' name='price' placeholder='Bendra užsakymo kaina' value='".$row['kaina']."' /></div>";
		echo "<div class='form-group'><label>Bendras prekių kiekis</label><input required min='1' step='1' type='number' class='form-control' name='count' placeholder='Bendras prekių kiekis' value='".$row['prekiu_kiekis']."' /></div>";

		echo "<div class='form-group'><label>Mokėjimo būdas</label><select class='form-control' name='budas' id='budas' multiple>";
		$sql_for_selection_options = "SELECT * FROM apmokejimo_budai";
		$select_options = mysqli_query($dbc, $sql_for_selection_options);
		$number = 1;
		while($options = mysqli_fetch_assoc($select_options)) {
			if($row['budas'] != $options['budas']) {
				echo "<option value='".$number."'>".$options['budas']."</option>";
			}
			else {
				echo "<option value=".$number." selected>".$options['budas']."</option>";
			}

			$number++;
		}
		echo "</select></div>";

		echo "<div class='form-group'><label>Užsakymo statusas</label><select class='form-control' name='statusas' id='statusas' multiple>";
		$sql_for_selection_options = "SELECT * FROM statusai";
		$select_options = mysqli_query($dbc, $sql_for_selection_options);
		$number = 1;
		while($options = mysqli_fetch_assoc($select_options)) {
			if($shippment_information['statusas'] != $options['statusas']) {
				echo "<option value='".$number."'>".$options['statusas']."</option>";
			}
			else {
				echo "<option value='".$number."' selected>".$options['statusas']."</option>";
			}

			$number++;
		}
		echo "</select></div>";
		
		echo "<div class='form-group'><label>Pristatymo adresas</label><input required type='text' class='form-control' name='adresas' placeholder='Pristatymo adresas' value='".$shippment_information['adresas']."' /></div>";	
		echo "<div class='form-group' style='align:left'><input type='hidden' value='false' name='checkboxas'><input class='form-check-input' type='checkbox' value='true' name='checkboxas' id='checkboxas'/><label class='form-check-label' for='checkboxas'>Išsiųsti žinutę į paštą apie nauja siuntos statusą? (Veikia keičiant tik iš užsakyta į pakeliui ir iš pakeliui į atlikta)</label></div>";	
	} 

	echo "<div class='form-group'><input type='submit' value='Atnaujinti' name='btn' class='btn btn-danger'></div></form>";

	if(isset($_POST['btn']))
    {
		$_SESSION['prev'] = 'uzsakymo_info_keitimas';
        $datetime = $_POST['data'];
        $total_price = $_POST['price'];
        $count_of_items = $_POST['count'];
        $payment_type = $_POST['budas'];
        $shippment_status = $_POST['statusas'];
		$shippment_address = $_POST['adresas'];
		$checkbox_status = $_POST['checkboxas'];

		$sql_for_purchases = "UPDATE pirkimai SET kaina = '$total_price', prekiu_kiekis = '$count_of_items' WHERE id = $id";
		$query = mysqli_query($dbc, $sql_for_purchases);

		$sql_for_shippment = "UPDATE pristatymai SET data = '$datetime', statusas = '$shippment_status', adresas = '$shippment_address' WHERE id = $shippment_id";
        $query=mysqli_query($dbc, $sql_for_shippment);

		$sql_for_payment_type = "UPDATE apmokejimas SET apmokejimo_budas = '$payment_type' WHERE id = $payment_type_table_id";
		$query=mysqli_query($dbc, $sql_for_payment_type);

		$sql_owner_of_order = "SELECT * FROM pristatymai WHERE id = $shippment_id";
		$result = mysqli_query($dbc, $sql_owner_of_order);
		$owner_userid = mysqli_fetch_assoc($result)['fk_vartotojo_id'];
		$user_qualifies_for_order_was_shipped_mail = $checkbox_status == "true" && $shippment_information['statusas'] == "Užsakyta" && $shippment_status == 2;
		if($user_qualifies_for_order_was_shipped_mail) {

			$sql_for_user_email = "SELECT email FROM users WHERE userid = '$owner_userid'";
			$query_for_email = mysqli_query($dbc, $sql_for_user_email);
			$email = mysqli_fetch_assoc($query_for_email)['email'];
			$subject = "Jūsų užsakymo nr. ".$id." siunta buvo išsiųsta";
			$message = "<center><h1>Užsakymas išsiųstas</h1></center><br><h2>Užsakymo nr. ".$id." buvo išsiųstas į ".$shippment_address." adresą
			<h2>Dėkojame, kad pasirinkote Atominis Reaktorius internetinę parduotuvę</h2>";

			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
			$mail->Username = 'vytas.sa1@gmail.com';
			$mail->Password = 'ruuvicogpbumtksk';
			$mail->Port = 587;
			$mail->CharSet = 'UTF-8';
			$mail->isHTML(true);

			$mail->setFrom('vytas.sa1@gmail.com');
			$mail->addAddress($email);
			$mail->Subject = $subject;
			$mail->Body = $message;

			$mail->send();
		}

		$user_qualifies_for_order_was_finished_mail = $checkbox_status == "true" && $shippment_information['statusas'] == "Pakeliui" && $shippment_status == 3;
		if($user_qualifies_for_order_was_finished_mail) {
			$sql_for_user_email = "SELECT email FROM users WHERE userid = '$owner_userid'";
			$query_for_email = mysqli_query($dbc, $sql_for_user_email);
			$email = mysqli_fetch_assoc($query_for_email)['email'];

			$subject = "Užsakymo nr. ".$id." įvykdytas";
			$message = "<div class='container mt-5' style='text-align:left; width:50%; display: table-header-group;'><h1>Užsakymas įvykdytas</h1><br>
			<p>Ačiū, kad pirkote Atominis Reaktorius internetinėje parduotuvėjė.<br>
			Jeigu turite pastebėjimų, nusiskundimų ar pasiūlymų, susisiekite su mumis šiuo paštu: vytas.sa1@gmail.com</p><br></div><br>
			<h1>Užsakymo ataskaita</h1>
			<table style='width:20%; border: 1px solid black; border-collapse: collapse'><tr style='text-align:left; border: 1px solid black; border-collapse: collapse'>
			<th style='text-align:left; border: 1px solid black; border-collapse: collapse'>Prekė</th><th style='text-align:left; border: 1px solid black; border-collapse: collapse'>Kiekis</th><th style='text-align:left; border: 1px solid black; border-collapse: collapse'>Iš viso</th></tr>";

			$sql = "SELECT prekes.pavadinimas, prekes.Pardavimo_kaina, ppt.pirktas_kiekis FROM prekes INNER JOIN preke_pirkimai_tarpinis AS ppt ON prekes.id = ppt.fk_preke_id WHERE ppt.fk_pirkimas_id = $id";
			$result = mysqli_query($dbc, $sql);

			while($row = mysqli_fetch_assoc($result)) {
				$total_price_for_one_row = $row['pirktas_kiekis'] * $row['Pardavimo_kaina'];
				$message .= "<tr style='text-align:left; border: 1px solid black; border-collapse: collapse'><td style='text-align:left; border: 1px solid black; border-collapse: collapse'>".$row['pavadinimas']."</td><td style='text-align:left; border: 1px solid black; border-collapse: collapse'>".$row['pirktas_kiekis']."</td><td style='text-align:left; border: 1px solid black; border-collapse: collapse'>".$total_price_for_one_row."</td></tr>";
			}
			
			$sql_for_shippments = "SELECT * FROM pristatymai WHERE pristatymai.id = ".$shippment_id."";
			$result = mysqli_query($dbc, $sql_for_shippments);
			$shippment_info = mysqli_fetch_assoc($result);

			$sql_for_discounts = "SELECT * FROM pirkimai INNER JOIN nuolaidos ON pirkimai.fk_nuolaidos_id = nuolaidos.id WHERE pirkimai.id = ".$id."";
			$result = mysqli_query($dbc, $sql_for_discounts);
			$discount_info = mysqli_fetch_assoc($result);

			$sql_for_payment_type_in_words = "SELECT apmokejimo_budai.budas FROM apmokejimas INNER JOIN apmokejimo_budai ON apmokejimo_budai.id = apmokejimas.apmokejimo_budas WHERE apmokejimas.id = ".$payment_type_table_id."";
			$result = mysqli_query($dbc, $sql_for_payment_type_in_words);
			$payment_type = mysqli_fetch_assoc($result);

			$message .= "</table><br><br><table style='width: 50%; text-align:left; border: 1px solid black; border-collapse: collapse'><tr style='text-align:left; border: 1px solid black; border-collapse: collapse'><th style='text-align:left; border: 1px solid black; border-collapse: collapse'>Pristatymo būdas</th><th style='text-align:left; border: 1px solid black; border-collapse: collapse'>Mokėjimo būdas</th><th style='text-align:left; border: 1px solid black; border-collapse: collapse'>Nuolaida</th><th style='text-align:left; border: 1px solid black; border-collapse: collapse'>Pristatymo mokestis</th><th style='text-align:left; border: 1px solid black; border-collapse: collapse'>Viso krepšelio mokestis</th></tr><tr><td style='text-align:left; border: 1px solid black; border-collapse: collapse'><b>".$shippment_info['budas']."</b><br>".$shippment_address."</td><td style='text-align:left; border: 1px solid black; border-collapse: collapse'>".$payment_type['budas']."</td><td style='text-align:left; border: 1px solid black; border-collapse: collapse'>".$discount_info['nuolaida']."%</td><td style='text-align:left; border: 1px solid black; border-collapse: collapse'>".$shippment_info['mokestis']."</td><td style='text-align:left; border: 1px solid black; border-collapse: collapse'>".$total_price."</td></tr></table>";
			$mail = new PHPMailer(true);
			$mail->IsSMTP();
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
			$mail->Username = 'vytas.sa1@gmail.com';
			$mail->Password = 'ruuvicogpbumtksk';
			$mail->Port = 587;
			$mail->CharSet = 'UTF-8';
			$mail->isHTML(true);

			$mail->setFrom('vytas.sa1@gmail.com');
			$mail->addAddress($email);
			$mail->Subject = $subject;
			$mail->Body = $message;
			$mail->send();
		}

		$_SESSION['message'] = 'Sėkmingai atnaujinta';
		$_SESSION['header'] = 'yes';

        header("location:".$previous_page.".php");
    } 
?>