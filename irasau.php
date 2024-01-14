<?php
session_start();
// prisijungimas
$server="localhost";
$user="stud";
$password="stud";
$dbname="stud";
$lentele="pratyboms";

$conn = new mysqli($server, $user, $password, $dbname);
   if ($conn->connect_error) die("Negaliu prisijungti: " . $conn->connect_error);
mysqli_set_charset($conn,"utf8");// dėl lietuviškų raidžių

// Irasymas
if($_POST !=null){
       $LLLL = $_SESSION['user']; 
       $MMMM = $_POST['Gavejas'];
       $NNNN = $_POST['Zinute'];
	
      $sql = "INSERT INTO $lentele (siuntejas, kam, zinute) 
             VALUES ('$LLLL', '$MMMM','$NNNN')";
      if (!$result = $conn->query($sql)) die("Negaliu įrašyti: " . $conn->error);
      {header("Location:skaitau.php");exit;} ;	
}
?>