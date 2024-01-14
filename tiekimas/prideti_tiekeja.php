<html> 
<head>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
  
    <title>Pridėti tiekėją</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
  
<body>
    <div class="container mt-5">
        <h1>Pridėti tiekėją</h1>
        <form action="tiekeju_valdiklis.php" method="POST">
            <div class="form-group">
                <label>Pavadinimas</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Pavadinimas" 
                    name="pavadinimas" required/>
            </div>
			<div class="form-group">
                <label>Adresas</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Adresas" 
                    name="adresas" required/>
            </div>
			<div class="form-group">
                <label>Miestas</label>
                <input type="text" 
                    class="form-control" 
                    placeholder="Miestas" 
                    name="miestas" required/>
            </div>
			<div class="form-group">
                <label>E. paštas</label>
                <input type="email" 
                    class="form-control" 
                    placeholder="E. paštas" 
                    name="epastas" required/>
            </div>
            <div class="form-group">
                <input type="submit" 
                    value="Pridėti" 
                    class="btn btn-success" 
                    name="prideti_tiekeja">
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