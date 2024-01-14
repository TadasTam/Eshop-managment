<?php
    include("tiekeju_valdiklis.php");
    $tiekejas = grazinti_tiekeja($_GET['id']);
?>

<html>
  
<head>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
      
    <title>Redaguoti tiekėją</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
  
<body>
    <div class="container mt-5">
        <h1>Redaguoti tiekėją</h1>
        <form method="post" action="tiekeju_valdiklis.php?id=<?php echo $tiekejas['id']; ?>">
            <div class="form-group">
                <label>Pavadinimas</label>
                <input type="text" 
                    class="form-control" 
                    name="pavadinimas" 
                    placeholder="Pavadinimas" 
                    value= "<?php echo $tiekejas['pavadinimas'];?>" required/>
            </div>
  
            <div class="form-group">
                <label>Adresas</label>
                <input type="text" 
                    class="form-control" 
                    name="adresas" 
                    placeholder="Adresas" 
                    value="<?php echo $tiekejas['adresas'];?>" required/>
            </div>
			
			<div class="form-group">
                <label>Miestas</label>
                <input type="text" 
                    class="form-control" 
                    name="miestas" 
                    placeholder="Miestas" 
                    value="<?php echo $tiekejas['miestas'];?>" required/>
            </div>
  
            <div class="form-group">
                <label>E. paštas</label>
                <input type="email" 
                    class="form-control" 
                    name="epastas" 
                    placeholder="E. paštas" 
                    value="<?php echo $tiekejas['epastas'];?>" required/>
            </div>
			
            <div class="form-group">
                <input type="submit" value="Atnaujinti" 
                    name="redaguoti_tiekeja" class="btn btn-danger">
            </div>
        </form>
            <a href=
			"tiekejai.php" 
			class="btn btn-danger">
			Grįžti
        </a>
    </div>
</body>
  
</html>