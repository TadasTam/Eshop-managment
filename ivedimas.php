<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<?php
include("include/nustatymai.php");
	echo "Gavejas ";
	$db=mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT username"." FROM ".TBL_USERS;
 $result = mysqli_query($db, $sql);
 if (!$result || (mysqli_num_rows($result) < 1))  	{echo "Klaida skaitant lentelę users"; exit;};
	
	echo "<select name=\"Gavejas\" id=\"Gavejas\">";
while ($row = mysqli_fetch_assoc($result)) 
 {$user= $row['username'];
      echo "<option selected=\"Gavejas\" value=".$user.">".$user."</option>";
     }
	
echo "</select>";


?>
	
<body>
	
	<form method='post' action='irasau.php'>
     Zinutes tekstas: <textarea name='Zinute'> </textarea><br><br>
    <input type='submit' name='siusti' value='Siųsti'>
</form>
</body>


</html>