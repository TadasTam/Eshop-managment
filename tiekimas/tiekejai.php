<?php
    include("tiekeju_valdiklis.php");
?>
  
<html>
  
<head>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
  
    <title>Tiekėjai</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  
    <link rel="stylesheet" 
        href="css/style.css">
</head>
  
<body>
    <div class="container mt-5">
          
        <!-- top -->
        <div class="row">
            <div class="col-lg-8">
                <h1>Tiekėjai</h1>
                <a href="prideti_tiekeja.php">Pridėti tiekėją</a>
            </div>
        </div>
  
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th scope="col">#</th>
					<th scope="col">Pavadinimas</th>
					<th scope="col">Adresas</th>
					<th scope="col">Miestas</th>
					<th scope="col">E. paštas</th>
					<th scope="col">Redaguoti</th>
					<th scope="col">Pašalinti</th>
				</tr>
			</thead>
			<tbody>
			<?php
                $tiekejai = tiekeju_sarasas(); 
                foreach ($tiekejai as $tiekejas)
                {
            ?>
			
			<tr>
				<td><?php echo $tiekejas['id']; ?></td>
				<td><?php echo $tiekejas['pavadinimas']; ?></td>
				<td><?php echo $tiekejas['adresas']; ?></td>
				<td><?php echo $tiekejas['miestas']; ?></td>
				<td><?php echo $tiekejas['epastas']; ?></td>
				<td><a href=
                        "redaguoti_tiekeja.php?id=<?php echo $tiekejas['id']; ?>" 
                            class="btn btn-outline-success">
                            Redaguoti
                     </a>
				</td>
				<td>
                    <form method="post" action="tiekeju_valdiklis.php?id=<?php echo $tiekejas['id']; ?>" onsubmit="return confirm('Ar tikrai norite šalinti šį tiekėją?');">
                        <input type="submit" value="Pašalinti" name="salinti_tiekeja" class="btn btn-outline-danger">
                    </form>
				</td>
			</tr>
			
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
