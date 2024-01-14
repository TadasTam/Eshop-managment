<html>
    <head>
        <meta http-equiv="Content-Type" 
            content="text/html; charset=UTF-8">
   
        <title>Iš viso išleista suma</title>
   
        <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

        <link rel="stylesheet" 
            href="css/style.css">
    </head>
   
    <body>   
        <div class="container mt-5">
            <a class='btn btn-danger' href="./client-menu.php">Atgal</a>

            <form action="client-spent-amount.php" method="post">
                <?php
                if (isset($_POST['myInput']) && isset($_POST['myInput2']) && $_POST['myInput'] != "" && $_POST['myInput2'] != ""){
                    ?>
                    <input type="date" id="myInput" name="myInput" placeholder="start date" value="<?php echo $_POST['myInput']; ?>">
                    <input type="date" id="myInput2" name="myInput2" placeholder="end date" value="<?php echo $_POST['myInput2']; ?>">
                    <?php
                }
                else{
                    ?>
                    <input type="date" id="myInput" name="myInput" placeholder="start date">
                    <input type="date" id="myInput2" name="myInput2" placeholder="end date">
                    <?php
                }
                ?>
            <input class="btn btn-success" type="submit" value="Atnaujinti">
            </form>

            <!-- top -->
        <?php
            include("client-connect.php");
            session_start();

            if (isset($_POST['myInput']) && isset($_POST['myInput2']) && $_POST['myInput'] != "" && $_POST['myInput2'] != ""){
                if ($_POST['myInput'] > $_POST['myInput2']){
                    echo "Neteisingai įvestos datos";
                    exit();
                }
                $start_date = $_POST['myInput'];
                $end_date = $_POST['myInput2'];
                $userid=$_SESSION['userid'];
                $sql = "SELECT SUM(kaina) suma FROM pirkimai WHERE fk_vartotojas_id = '$userid' AND data BETWEEN '$start_date' AND '$end_date'";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    //echo "<h1>Iš viso išleista suma laiko</h1>";
                    echo "<h1>Išleista suma laikotarpyje nuo $start_date iki $end_date</h1>";
                    $row = $result->fetch_assoc();
                    echo "Suma: " . round($row["suma"], 2). " €";
                    //echo "<h1>Iš viso išleista suma laikotarpyje  </h1>"
                    // echo "<table class='table table-hover'>";
                    // echo "<tr><td><b>Suma</b></td></tr>";
                    // while($row = $result->fetch_assoc()) {
                    //     echo "<tr><td>" . $row["suma"]. "</td></tr>";
                    // }
                    // echo "</table>";
                } else {
                    echo "Nėra duomenų";
                }
                $con->close();
            }
            else{
                $userid=$_SESSION['userid'];
                $sql = "SELECT SUM(kaina) suma FROM pirkimai WHERE fk_vartotojas_id = '$userid'";
                $result = $con->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    echo "<h1>Iš viso išleista suma</h1>";
                    $row = $result->fetch_assoc();
                    echo "Suma: " . round($row["suma"], 2). " €";
                    $suma = $row["suma"];
                    $sql = "SELECT * FROM isleista_suma WHERE userid = '$userid'";
                    $result = $con->query($sql);
                    $date = date("Y-m-d-h-m-s");


                    if ($result->num_rows > 0) {
                        $sql = "UPDATE isleista_suma SET suma = '$suma', data = '$date' WHERE userid = '$userid'";
                        $result = $con->query($sql);
                    }
                    else{
                        $sql = "INSERT INTO isleista_suma (userid, suma, data) VALUES ('$userid', '$suma', '$date')";
                        $result = $con->query($sql);
                    }
                } else {
                    echo "Nėra duomenų";
                }
                $con->close();
            }

            // $userid=$_SESSION['userid'];
            // $sql = "SELECT SUM(kaina) suma FROM pirkimai WHERE fk_vartotojas_id = '$userid'";
            // $result = $con->query($sql);
            // if ($result->num_rows > 0) {
            //     // output data of each row
            //     echo "<h1>Iš viso išleista suma</h1>";
            //     echo "<table class='table table-hover'>";
            //     echo "<tr><td><b>Suma</b></td></tr>";
            //     while($row = $result->fetch_assoc()) {
            //         echo "<tr><td>" . $row["suma"]. "</td></tr>";
            //     }
            //     echo "</table>";
            // } else {
            //     echo "0 results";
            // }
            // $con->close();

            ?>

        </div>
    </body>
</html>
</div>