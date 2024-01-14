
<html>
  
<head>

    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
  
    <title>Add List</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
  
<body>
    <div class="container mt-5">
        <h1>Pridėti prekę</h1>
        <form action="prideti_preke.php" method="POST">
            <div class="form-group">
                <label>Pavadinimas</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Pavadinimas" 
                    name="Pavadinimas" />
            </div>
  
            <div class="form-group">
                <label>Pardavimo_kaina</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Pardavimo_kaina" 
                    name="Pardavimo_kaina" />
            </div>
			<div class="form-group">
                <label>Savikaina</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="savikaina" 
                    name="savikaina" />
            </div>
			<div class="form-group">
                <label>Nuolaida</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Nuolaida" 
                    name="Nuolaida" />
            </div>
			<div class="form-group">
                <label>Kilmės vieta</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Vieta" 
                    name="Vieta" />
            </div>
			<div class="form-group">
                <label>Siuntimo kaina</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="SiuntimoKaina" 
                    name="SiuntimoKaina" />
            </div>
			<div class="form-group">
                <label>Kiekis</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Kiekis" 
                    name="Kiekis" />
            </div>
			<div class="form-group">
                <label>Papildoma informacija</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Informacija" 
                    name="Informacija" />
            </div>
            <div class="form-group">
                <input type="submit" 
                    value="Pridėti" 
                    class="btn btn-danger" 
                    name="btn">
            </div>
			<div class="form-group">
                <input type="submit" 
                    value="Grįžti" 
                    class="btn btn-danger" 
                    name="btn1">
            </div>
        </form>
    </div>
  
    <?php
        if(isset($_POST["btn"])) {
            include("prekes_db_connect.php");
            $item_name=$_POST['Pavadinimas'];
			$sell_price=$_POST['Pardavimo_kaina'];
			$price=$_POST['savikaina'];
			$discount=$_POST['Nuolaida'];
            $from=$_POST['Vieta'];
            $shipping=$_POST['SiuntimoKaina'];
            $info=$_POST['Informacija'];
			$kiekis=$_POST['Kiekis'];
  
            $q="insert into prekes (pavadinimas, Pardavimo_kaina, Savikaina, Nuolaida, Kilmes_vieta, Siuntimo_kaina, Papildoma_informacija)
            values('$item_name','$sell_price','$price','$discount','$from','$shipping','$info')";
            mysqli_query($con,$q);
			$get_id = "SELECT CONVERT(INT, id) FROM `prekes` WHERE prekes.pavadinimas = $item_name";
			$qq="insert into inventorius (id, kiekis) values ('$get_id', '$kiekis')";
			mysqli_query($con,$qq);
            header("location:operacija1.php");
        }
         if(isset($_POST["btn1"])) {
			 header("location:operacija1.php");
		 }
        // if(!mysqli_query($con,$q))
        // {
            // echo "Value Not Inserted";
        // }
        // else
        // {
            // echo "Value Inserted";
        // }
    ?>
</body>
  
</html>