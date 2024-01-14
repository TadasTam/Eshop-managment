<?php
    session_start();
    $con=mysqli_connect("localhost","root","","vartvald");
    if(!$con) {
        die("cannot connect to server");
    }

    $userid = $_SESSION['userid'];
?>
<html>

<head>
    <meta http-equiv="Content-Type"
        content="text/html; charset=UTF-8">
  
    <title>View List</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  
    <link rel="stylesheet"
        href="css/style.css">
</head>

<body>

<div class="container" style="margin-top: 50px;">
    <h4>
    Užsakymas įvykdytas sėkmingai.
    </h4>

<form method="post" action="index.php">
<div class="col-lg-4">
    <input type="submit"
        value="Grįžti"
        class="btn btn-danger"
        name="btnback">
</div>
</div>
</form>

</body>
</html>
