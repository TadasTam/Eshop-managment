
<?php
    session_start();
	include("uzsakymu_valdiklis.php");
	$uzsakymai = uzsakymu_sarasas();
	$_SESSION['prekes'] = array();
	$_SESSION['prekesK'] = array();
	$_SESSION['prekesKA']=array();
	$_SESSION['sudarymas']='';
	$_SESSION['pristatymas']='';
	$_SESSION['pkaina']='';
	$_SESSION['tiekejas']='';
?>
  
<html>
  
<head>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
  
    <title>Užsakymai</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  
    <link rel="stylesheet" 
        href="css/style.css">
</head>
  
<body>
    <div class="container mt-5">
          
        <div class="row">
            <div class="col-lg-8">
                <h1>Užsakymai</h1>
                <a href="prideti_uzsakyma.php">Kurti užsakymą</a>
            </div>
        </div>
  
		<h3>Užsakyti užsakymai</h3>
		<table class="table table-bordered table-striped">
			<thead>
				<tr  style="background-color:white;">
					<th scope="col">#</th>
					<th scope="col">Tiekėjas</th>
					<th scope="col">Būsena</th>
					<th scope="col">Sudarytas</th>
					<th scope="col">Pristatytas</th>
					<th scope="col">Suma</th>
					<th scope="col">Pristatymo kaina</th>
					<th scope="col">Darbuotojas</th>
					<th scope="col">Pakeisti būseną</th>
					<th scope="col">Redaguoti</th>
					<th scope="col">Pašalinti</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($uzsakymai as $uzsakymas)
                {
					if($uzsakymas['statusas']=="Atlikta") {continue;}
            ?>
			
			<tr style="background-color:white;">
				<td><?php echo $uzsakymas['id']; ?></td>
				<td><?php echo $uzsakymas['pavadinimas']; ?></td>
				<td><?php echo $uzsakymas['statusas']; ?></td>
				<td><?php echo $uzsakymas['sudaryta']; ?></td>
				<td><?php echo $uzsakymas['pristatyta']; ?></td>
				<td><?php echo $uzsakymas['suma']; ?></td>
				<td><?php echo $uzsakymas['pristatymo_kaina']; ?></td>
				<td><?php echo $uzsakymas['username']; ?></td>
				<td>
					 <form method="post" action="uzsakymu_valdiklis.php?id=<?php echo $uzsakymas['id']; ?>" onsubmit="return confirm('Ar tikrai norite pakeisti šio užsakymo būseną į <?php if($uzsakymas['statusas']=='Atlikta') { echo 'užsakyta';} else {echo 'atlikta';} ?>?');">
                        <input type="submit" value="Keisit būseną" name="pakeisti_busena" class="btn btn-outline-success">
                    </form>
				</td>
				<td>
					<a href=
                        "redaguoti_uzsakyma.php?id=<?php echo $uzsakymas['id']; ?>" 
                            class="btn btn-outline-danger">
                            Redaguoti
                        </a>
				</td>
				<td>
					<form method="post" action="uzsakymu_valdiklis.php?id=<?php echo $uzsakymas['id']; ?>" onsubmit="return confirm('Ar tikrai norite šalinti šį užsakymą?');">
                        <input type="submit" value="Pašalinti" name="salinti_uzsakyma" class="btn btn-outline-danger">
                    </form>
				</td>
			</tr>
			

			<?php
				$prekes = uzsakymo_prekes($uzsakymas['id']);
				foreach ($prekes as $preke)
                {
            ?>
			
			<tr style="background-color:#F5F5F5;">
				<td></td>
				<td></td>
				<td><?php echo $preke['pavadinimas']; ?></td>
				<td><?php echo $preke['kiekis']; ?></td>
				<td><?php echo $preke['vieneto_kaina']; ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			
			<?php
            }
            ?>
			
			<?php
            }
            ?>

			</tbody>
		</table>

		<h3>Atlikti užsakymai</h3>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Tiekėjas</th>
					<th scope="col">Būsena</th>
					<th scope="col">Sudarytas</th>
					<th scope="col">Pristatytas</th>
					<th scope="col">Suma</th>
					<th scope="col">Pristatymo kaina</th>
					<th scope="col">Darbuotojas</th>
					<th scope="col">Pakeisti būseną</th>
					<th scope="col">Redaguoti</th>
					<th scope="col">Pašalinti</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($uzsakymai as $uzsakymas)
                {
					if($uzsakymas['statusas']=="Užsakyta") {continue;}
            ?>
			
			<tr  style="background-color:white;">
				<td><?php echo $uzsakymas['id']; ?></td>
				<td><?php echo $uzsakymas['pavadinimas']; ?></td>
				<td><?php echo $uzsakymas['statusas']; ?></td>
				<td><?php echo $uzsakymas['sudaryta']; ?></td>
				<td><?php echo $uzsakymas['pristatyta']; ?></td>
				<td><?php echo $uzsakymas['suma']; ?></td>
				<td><?php echo $uzsakymas['pristatymo_kaina']; ?></td>
				<td><?php echo $uzsakymas['username']; ?></td>
				<td>
					 <form method="post" action="uzsakymu_valdiklis.php?id=<?php echo $uzsakymas['id']; ?>" onsubmit="return confirm('Ar tikrai norite pakeisti šio užsakymo būseną į <?php if($uzsakymas['statusas']=='Atlikta') { echo 'užsakyta';} else {echo 'atlikta';} ?>?');">
                        <input type="submit" value="Keisit būseną" name="pakeisti_busena" class="btn btn-outline-success">
                    </form>
				</td>
				<td>
					<a href=
                        "redaguoti_uzsakyma.php?id=<?php echo $uzsakymas['id']; ?>" 
                            class="btn btn-outline-danger">
                            Redaguoti
                        </a>
				</td>
				<td>
					<form method="post" action="uzsakymu_valdiklis.php?id=<?php echo $uzsakymas['id']; ?>" onsubmit="return confirm('Ar tikrai norite šalinti šį užsakymą?');">
                        <input type="submit" value="Pašalinti" name="salinti_uzsakyma" class="btn btn-outline-danger">
                    </form>
				</td>
			</tr>
			

			<?php
				$prekes = uzsakymo_prekes($uzsakymas['id']);
				foreach ($prekes as $preke)
                {
            ?>
			
			<tr  style="background-color:#F5F5F5;">
				<td></td>
				<td></td>
				<td><?php echo $preke['pavadinimas']; ?></td>
				<td><?php echo $preke['kiekis']; ?></td>
				<td><?php echo $preke['vieneto_kaina']; ?></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			
			<?php
            }
            ?>
			
			<?php
            }
            ?>

			</tbody>
		</table>

		<a href=
		"../index.php" 
			class="btn btn-danger">
			Grįžti
		</a>
    </div>

</body>
  
</html>
