<html>  
      <head>  
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		   <title>Darbuotojo sąsaja</title>
  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		   <link rel="stylesheet" href="css/style.css">  

           <style>
                #myInput {
                    background-position: 10px 10px;
                    background-repeat: no-repeat;
                    width: 50%;
                    font-size: 16px;
                    padding: 12px 20px 12px 40px;
                    border: 1px solid #ddd;
                    margin-bottom: 12px;
                }
            </style>
      </head>  
 </html> 


 <script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
<?php
	session_start();
	include "include/nustatymai.php";

	$userlevel=$_SESSION['ulevel'];
	if (($userlevel != $user_roles["Darbuotojas"]) && ($userlevel != $user_roles[ADMIN_LEVEL]))
 	{ 	
		$_SESSION['kicked'] = 'yes';
		$_SESSION['message'] = 'Bandėte patekti į uzsakymu_redagavimas.php puslapį, tačiau tam neturite privilegijų';
		header("Location: logout.php");
		exit;
	}

	
	$_SESSION['prev'] = 'uzsakymu_redagavimas';

    echo "<table width=100% border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"meniu\">";
	echo "<tr><td>";
	echo "</td></tr><tr><td>";
	echo "<form method='post' action='pristatymas.php' style='display:inline'><input type='submit' value='Grįžti' class='btn btn-danger' name='btn1'></form> &nbsp;&nbsp;";
	
	echo "<center><h1>Visi klientų užsakymai</h1></center>";

    echo "</td></tr></table>";

	$dbc= new mysqli("localhost", "root", "", "vartvald");
	$userid = $_SESSION['userid'];
	$sql = "SELECT p.id, p.data, p.kaina, p.prekiu_kiekis, p.fk_pristatymo_id, budai.budas FROM pirkimai AS p LEFT JOIN apmokejimas AS a ON p.fk_apmokejimo_budo_id = a.id LEFT JOIN apmokejimo_budai AS budai ON a.apmokejimo_budas = budai.id ORDER BY p.id";
    
	$result = mysqli_query($dbc, $sql);
	if(mysqli_num_rows($result) <= 0) {
		echo "<center><h1>Nėra nei vieno kliento užsakymo</h1></center>";
		return;
	}

    echo "<center><input type='text' id='myInput' onkeyup='myFunction()' placeholder='Ieškok pagal ID' title='Type in a name'></center>";
	echo "<table style='width:50%' align='center' class='table table-bordered table-dark' id='myTable'>";
	echo "<tr>
    <th>ID</th>
	<th>Užsakymo data</th>
	<th>Bendra kaina</th>
	<th>Prekių kiekis</th>
	<th>Mokėjimo būdas</th>
	<th>Užsakymo statusas</th>
	<th>Pristatymo adresas</th>
	</tr>";
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<tr><td>".$row['id']."</td>";
        echo "<td>".$row['data']."</td>";
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
		echo "<td><a href='uzsakymo_info_keitimas.php?id=".$row['id']."'>Užsakymo informacijos keitimas</a></td></tr>";
		
	} 
	echo "</table>";

    if(isset($_SESSION['message']) && isset($_SESSION['header']) && $_SESSION['header'] == "yes") {
		echo "<center><h3 style='color: green'>".$_SESSION['message']."</h3></center>";
		$_SESSION['message'] = '';
		$_SESSION['header'] = 'no';
	}
?>