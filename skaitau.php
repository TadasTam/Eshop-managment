<?php
// prisijungimas
$server="localhost";
$user="stud";
$password="stud";
$dbname="stud";
$lentele="pratyboms";

$conn = new mysqli($server, $user, $password, $dbname);
   if ($conn->connect_error) die("Negaliu prisijungti: " . $conn->connect_error);
mysqli_set_charset($conn,"utf8");// dėl lietuviškų raidžių

// nuskaitymas
$sql =  "SELECT * FROM $lentele";
if (!$result = $conn->query($sql)) die("Negaliu nuskaityti: " . $conn->error);


// isvedimas
echo "<table border=\"1\">";
    echo "<tr><td>".'Siuntejas'."</td><td>".'Gavejas'."</td><td>".'Zinute'."</td></tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr><td>".$row['siuntejas']."</td><td>".$row['kam']."</td><td>".$row['zinute']."</td></tr>";
}
echo "</table>";
echo "<a href=\"ivedimas.php\">Dar kartą</a>";

echo "<br><br><a href=\"index.php\"><b>Grįžti į meniu<b></a>";
?>