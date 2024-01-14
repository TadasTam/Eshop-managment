<link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<div style="margin: auto;width: 60%;padding: 10px;">
<a class="btn btn-danger" href="./client-menu.php">Atgal</a>
<h1>Mano pirkimai</h1>

<?php
include("client-connect.php");

session_start();
$userid=$_SESSION['userid'];
$sql = "SELECT pirk.id, pirk.data, pavadinimas, pirktas_kiekis FROM pirkimai pirk
RIGHT JOIN preke_pirkimai_tarpinis ppt ON ppt.fk_pirkimas_id=pirk.id
LEFT JOIN prekes p ON p.id=ppt.fk_preke_id WHERE pirk.fk_vartotojas_id = '$userid' ORDER BY id";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    ?>
<div class="accordion" id="accordionExample">
    <?php
        $id = null;
        while($row = $result->fetch_assoc()) {
            if ($row["id"] != $id){
                if ($id != null){
                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                $id = $row["id"];
                echo "<div class='card'>";
                    echo "<div class='card-header' id='heading$id'>";
                        echo "<h2 class='mb-0'>";
                            echo "<button class='btn btn-link' type='button' data-toggle='collapse' data-target='#collapse$id' aria-expanded='true' aria-controls='collapseOne'>";
                                echo "Apsipirkimas: " . $row["id"] . " Data: " . $row["data"];
                            echo "</button>";
                        echo "</h2>";
                    echo "</div>";

                echo "<div id='collapse$id' class='collapse hide' aria-labelledby='heading$id' data-parent='#accordionExample'>";
                echo "<div class='card-body'>";
                echo "<table class='table table-striped'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th scope='col'>Prekės pavadinimas</th>";
                echo "<th scope='col'>Pirktas kiekis</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
            }

            echo "<tr>";
            echo "<td>" . $row["pavadinimas"] . "</td>";
            echo "<td>" . $row["pirktas_kiekis"] . "</td>";
            echo "</tr>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
} else {
    echo "<h2>Jūs dar nieko nesipirkote</h2>";
}
$con->close();
?>
</div>