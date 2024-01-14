<?php
    include("prekes_db_connect.php");
    if(isset($_POST['btn']))
    {

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

        <form method="post">
            <div class="form-group">
                <label>Pavadinimas</label>
        <h1><?php echo $res['pavadinimas'];?></h1>
            </div>
  
            <div class="form-group">
                <label>Kaina</label>
        <h1><?php echo $res['Pardavimo_kaina'];?></h1>
            </div>
			
		<div class="form-group">
                <label>Kiekis</label>
        <h1><?php echo $rres['Kiekis'];?></h1>
            </div>
			
  			<div class="form-group">
                <label>Nuolaida</label>
				<h1><?php 
				if (isset($res['Nuolaida']))
					echo $res['Nuolaida'];
				else
					echo "Prekė neturi nuolaidų";
			?></h1>
            </div>
			
			<div class="form-group">
                <label>Papildoma informacija</label>
				<h1><?php echo $res['Papildoma_informacija'];?></h1>
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