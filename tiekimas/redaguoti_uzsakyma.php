<?php    
    include("uzsakymu_valdiklis.php");
    $uzsakymas = grazinti_uzsakyma($_GET['id']);

    include("tiekeju_valdiklis.php");
    $tiekejai = tiekeju_sarasas($_GET['id']);


?>
<html>
  
<head>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
      
    <title>Redaguoti užsakymą</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
  
<body>
    <div class="container mt-5">
        <h1>Redaguoti užsakymą</h1>
        <form method="post" action="uzsakymu_valdiklis.php?id=<?php echo $uzsakymas['id']; ?>">
            <div class="form-group">
			<div class="form-group">
                <label>Sudarymo data</label>
                <input type="datetime-local" 
                    class="form-control" 
                    placeholder="Sudarymo data" 
                    name="sudaryta" 
					value="<?php echo $uzsakymas['sudaryta'];?>" />
            </div>
			<div class="form-group">
                <label>Pristatymo data</label>
                <input type="datetime-local" 
                    class="form-control" 
                    placeholder="Pristatymo data" 
                    name="pristatyta" 
					value="<?php echo $uzsakymas['pristatyta'];?>" />
            </div>
			<div class="form-group">
                <label>Pristatymo kaina</label>
                <input type="number" step="0.01" 
                    class="form-control" 
                    placeholder="Pristatymo kaina" 
                    name="kaina" 
					value="<?php echo $uzsakymas['pristatymo_kaina'];?>" />
            </div>
			
                <label>Tiekėjas</label>
                    <p><b><?php echo tiekejas($uzsakymas['fk_tiekejas']);?></b><p>
			
			<div class="form-group">
                <label>Dabartinis statusas</label>
				<select name="tiekejas">
                    <option value="1" <?php if($uzsakymas['fk_statusas']==1){echo "selected";} ?>>Užsakyta</option>
                    <option value="3" <?php if($uzsakymas['fk_statusas']==3){echo "selected";} ?>>Atlikta</option>
                </select>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Prekė</th>
                        <th scope="col">Kiekis</th>
                        <th scope="col">Vieneto kaina</th>
                    </tr>
                </thead>
                <tbody>
            <?php
				$prekes = uzsakymo_prekes($_GET['id']);
				foreach ($prekes as $preke)
                {
            ?>
                
                <tr>
                    <td><?php echo $preke['id']; ?></td>
                    <td><?php echo $preke['pavadinimas']; ?></td>
                    <td><?php echo $preke['kiekis']; ?></td>
                    <td><?php echo $preke['vieneto_kaina']; ?></td>
                </tr>

                <?php
                }
                ?>

                </tbody>
            </table>
			
            <div class="form-group">
                <input type="submit" value="Redaguoti" 
                    name="redaguoti_uzsakyma" class="btn btn-danger">
            </div> 
        </form>
		<a href=
			"uzsakymai.php" 
			class="btn btn-danger">
			Grįžti
        </a>
    </div>
</body>
  
</html>