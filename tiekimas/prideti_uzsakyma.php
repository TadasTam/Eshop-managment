  <?php
    session_start();

    include("uzsakymu_valdiklis.php");
    include("tiekeju_valdiklis.php");
    $tiekejai = tiekeju_sarasas();
    $suma = 0;
    
    if(isset($_POST['prideti_preke']))
    {
        $id = $_POST['id'];
        $kiekis = $_POST['kiekis'];
        $kaina = $_POST['kaina'];
        $pkaina = $_POST['pkaina'];

        $prekes = $_SESSION['prekes'];
        $kiekiai = $_SESSION['prekesK'];
        $kainos = $_SESSION['prekesKA'];

        if ($kiekis != ""){
            $new = true;
            $length = count($prekes);
            for ($i = 0; $i < $length; $i++) {
                if($prekes[$i]==$id)
                {
                    $kainos[$i] = ($kiekiai[$i]*$kainos[$i] + $kiekis*$kaina)/($kiekis+$kiekiai[$i]);
                    $kiekiai[$i] = $kiekiai[$i] + $kiekis;
                    $new = false;
                    break;
                }
            }

            if ($new == true)
            {
                array_push($prekes, $id);
                array_push($kiekiai, $kiekis);
                array_push($kainos, $kaina);
            }
            
        }

        $suma = (float)$pkaina;
        $length = count($prekes);
        for ($i = 0; $i < $length; $i++) {
            $suma = $suma + $kiekiai[$i]*$kainos[$i];
        }
        
        $_SESSION['prekes']=$prekes;
        $_SESSION['prekesK']=$kiekiai;
        $_SESSION['prekesKA']=$kainos;
        
        $_SESSION['sudarymas']=$_POST['sudaryta'];
        $_SESSION['pristatymas']=$_POST['pristatyta'];
        $_SESSION['pkaina']=$_POST['pkaina'];
        $_SESSION['tiekejas']=$_POST['tiekejas'];
    }
?>

<html> 
<head>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
  
    <title>Kurti užsakymą</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
  
<body>
    <form method="POST" id="prideti">
    <div class="container mt-5">
        <h1>Kurti užsakymą</h1>
        <!-- <form action="uzsakymu_valdiklis.php" method="POST"> -->
            <div class="form-group">
                <label>Sudarymo data</label>
                <input type="datetime-local" 
                    class="form-control" 
                    placeholder="Sudarymo data" 
                    name="sudaryta" 
                    value="<?php echo $_SESSION['sudarymas']; ?>"/>
            </div>
			<div class="form-group">
                <label>Pristatymo data</label>
                <input type="datetime-local" 
                    class="form-control" 
                    placeholder="Pristatymo data" 
                    name="pristatyta"
                    value="<?php echo $_SESSION['pristatymas']; ?>"/>
            </div>
			<div class="form-group">
                <label>Pristatymo kaina</label>
                <input type="number" step="0.01" min="0" 
                    class="form-control" 
                    placeholder="Pristatymo kaina" 
                    name="pkaina"
                    value="<?php echo $_SESSION['pkaina']; ?>"/>
            </div>
			
			<div class="form-group">
                <label>Tiekėjas</label>
				<select name="tiekejas">
                <?php 
                    foreach($tiekejai as $tiekejas) 
					{
                ?>
					<option value="<?php echo $tiekejas['id'];  ?>"
                    <?php if($tiekejas['id'] == $_SESSION['tiekejas']) {echo "selected";} ?>
                    ><?php echo $tiekejas['pavadinimas']; ?></option>
                <?php
					}
                ?>
				</select>
            </div>
           
                        
        
            <p><b>Visa suma:</b> <?php echo $suma; ?></p><br>
            <h1>Pridėti prekę</h1>
                <div class="form-group">
                    <label>Prekė</label>
                    <select name="id">
                    <?php 
                        $prekes = prekiu_sarasas();
                        foreach($prekes as $preke) 
                        {
                    ?>
                        <option value="<?php echo $preke['id']; ?>"><?php echo $preke['pavadinimas']; ?></option>
                    <?php
                        }
                    ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kiekis</label>
                    <input type="number" step="1" min="1" 
                        class="form-control" 
                        name="kiekis" />
                </div>
                <div class="form-group">
                    <label>Vieneto kaina</label>
                    <input type="number" step="0.01" min="0.01" 
                        class="form-control" 
                        name="kaina" />
                </div>
                <div class="form-group">
                    <input type="submit" 
                        value="Pridėti prekę(-es)" 
                        class="btn btn-success"
                        form="prideti" 
                        name="prideti_preke">
                </div>
            </form>
             
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
                    
                    $prekes = $_SESSION['prekes'];
                    $kiekiai = $_SESSION['prekesK'];
                    $kainos = $_SESSION['prekesKA'];

                    $length = count($prekes);
                    for ($i = 0; $i < $length; $i++) {
                        $id = $prekes[$i];
                        $kiekis = $kiekiai[$i];
                        $kaina = $kainos[$i];
                        if ($kiekis == 0) {continue;}
                ?>
                
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo pavadinimas($id); ?></td>
                    <td><?php echo $kiekis; ?></td>
                    <td><?php echo $kaina; ?></td>
                </tr>

                <?php
                }
                ?>

                </tbody>
            </table>

            <form action="uzsakymu_valdiklis.php" method="POST">
            <div class="form-group">
                <input type="submit" 
                    value="Kurti" 
                    class="btn btn-success" 
                    name="prideti_uzsakyma">
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