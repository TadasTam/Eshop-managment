<?php
    include("prekes_db_connect.php");
    if(isset($_POST['btn']))
    {
		$item_name=$_POST['Pavadinimas'];
		$sell_price=$_POST['Pardavimo_kaina'];
		$price=$_POST['savikaina'];
		$discount=$_POST['Nuolaida'];
		$from=$_POST['Vieta'];
		$shipping=$_POST['SiuntimoKaina'];
		$info=$_POST['Informacija'];
		$kiekis =$_POST['Kiekis'];
        $id = $_GET['id'];
        $q= "update prekes set pavadinimas='$item_name', Pardavimo_kaina='$sell_price', 
        Savikaina='$price', Nuolaida='$discount', Kilmes_vieta='$from', Siuntimo_kaina='$shipping', Papildoma_informacija='$info' where id=$id";
		$qq = "update inventorius set kiekis='$kiekis' where id=$id";
	    $qquery=mysqli_query($con,$qq);
        $query=mysqli_query($con,$q);
        header('location:operacija1.php');
    } 
    else if(isset($_GET['id'])) 
    {
        $q = "SELECT * FROM prekes WHERE Id='".$_GET['id']."'";
		$qq = "SELECT * FROM inventorius WHERE Id='".$_GET['id']."'";
        $query=mysqli_query($con,$q);
        $qquery=mysqli_query($con,$qq);
        $res= mysqli_fetch_array($query);
		$rres= mysqli_fetch_array($qquery);
    }
	         if(isset($_POST["btn1"])) {
			 header("location:operacija1.php");
		 }
?>
<html>
  
<head>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
      
    <title>Update List</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
  
<body>
    <div class="container mt-5">
        <h1>Atnaujinti prekę</h1>
        <form method="post">
            <div class="form-group">
                <label>Pavadinimas</label>
                <input type="text" 
                    class="form-control" 
                    name="Pavadinimas" 
                    placeholder="Pavadinimas" 
                    value=
        "<?php echo $res['pavadinimas'];?>" />
            </div>
  
            <div class="form-group">
                <label>Pardavimo_kaina</label>
                <input type="text" 
                    class="form-control" 
                    name="Pardavimo_kaina" 
                    placeholder="Pardavimo_kaina" 
value="<?php echo $res['Pardavimo_kaina'];?>" />
            </div>
			
	        <div class="form-group">
                <label>Savikaina</label>
                <input type="text" 
                    class="form-control" 
                    name="savikaina" 
                    placeholder="savikaina" 
value="<?php echo $res['Savikaina'];?>" />
            </div>
			
			<div class="form-group">
                <label>Nuolaida</label>
                <input type="text" 
                    class="form-control" 
                    name="Nuolaida" 
                    placeholder="Nuolaida" 
value="<?php echo $res['Nuolaida'];?>" />
            </div>
			
			<div class="form-group">
                <label>Kilmės vieta</label>
                <input type="text" 
                    class="form-control" 
                    name="Vieta" 
                    placeholder="Vieta" 
value="<?php echo $res['Kilmes_vieta'];?>" />
            </div>
			
			<div class="form-group">
                <label>Siuntimo Kaina</label>
                <input type="text" 
                    class="form-control" 
                    name="SiuntimoKaina" 
                    placeholder="SiuntimoKaina" 
value="<?php echo $res['Siuntimo_kaina'];?>" />
            </div>
			
			<div class="form-group">
                <label>Kiekis</label>
                <input type="text" 
                    class="form-control" 
                    name="Kiekis" 
                    placeholder="Kiekis" 
value="<?php echo $rres['Kiekis'];?>" />
            </div>

			<div class="form-group">
                <label>Papildoma informacija</label>
                <input type="text" 
                    class="form-control" 
                    name="Informacija" 
                    placeholder="Informacija" 
value="<?php echo $res['Papildoma_informacija'];?>" />
            </div>
			
 
            <div class="form-group">
                <input type="submit" value="Atnaujinti" 
                    name="btn" class="btn btn-danger">
            </div>
		<div class="form-group">
                <input type="submit" 
                    value="Grįžti" 
                    class="btn btn-danger" 
                    name="btn1">
            </div>  
        </form>
    </div>
</body>
  
</html>