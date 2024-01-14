<?php
    session_start();
    $con=mysqli_connect("localhost","root","","vartvald");
    if(!$con)
    {
        die("cannot connect to server");
    }
    if ($_SESSION['user'] == "guest") {
        $_SESSION['kicked'] = 'yes';
        $_SESSION['message'] = 'Bandėte patekti į krepselis_change_amount.php puslapį, tačiau tam neturite privilegijų';
        header("Location: ../logout.php");
        exit;
    }
    if (($_SESSION['prev'] != "krepselis") && ($_SESSION['prev'] != "krepselis_change_amount")) {
        $_SESSION['kicked'] = 'yes';
        $_SESSION['message'] = 'Bandėte patekti į krepselis_change_amount.php puslapį, tačiau taip negalima';
        header("Location: ../logout.php");
        exit;
    }
    $_SESSION['prev'] = 'krepselis_change_amount';

    $userid = $_SESSION['userid'];
    $id = $_GET['id'];

//    $q = "SELECT pavadinimas FROM prekes WHERE id='$id'";
    $q = "SELECT t.fk_preke_id, t.kiekis AS kiekis, u.pavadinimas AS pavadinimas, ROUND(u.Pardavimo_kaina*t.kiekis, 2) AS prekes_kaina, u.Pardavimo_kaina AS pard_kaina FROM preke_krepselis_pagalbinis t LEFT JOIN prekes u ON t.fk_preke_id = u.id WHERE fk_krepselis_id = '$userid' AND fk_preke_id = '$id'";

    $query=mysqli_query($con,$q);
    $result=mysqli_fetch_array($query);
    $name = $result['pavadinimas'];
    $amount = $result['kiekis'];
    $price = $result['prekes_kaina'];
    $price2= $result['pard_kaina'];

    $check_if_available = "SELECT t.Kiekis AS kiekis FROM inventorius t LEFT JOIN prekes u ON t.id = u.id WHERE t.id = '$id' LIMIT 1";
    $check_if_available=mysqli_query($con,$check_if_available);
    $kiekis_available=mysqli_fetch_array($check_if_available);
    $kiekis = $kiekis_available['kiekis'];

    if(isset($_POST["change_button"])) {
        $change_amount = $_POST['change'];
        if ($change_amount <= $kiekis+$amount) {
            $update_preke_krepselis_pagalbinis = "UPDATE preke_krepselis_pagalbinis SET kiekis = '$change_amount' WHERE fk_preke_id = '$id' AND fk_krepselis_id = '$userid'";
            $update_inventorius = "UPDATE inventorius SET Kiekis = Kiekis + '$amount' - $change_amount WHERE id = '$id'";
            $update_krepselis_pagalbinis = "UPDATE krepselis_pagalbinis
                                            SET visas_kiekis = visas_kiekis - $amount + '$change_amount',
                                                visa_kaina = visa_kaina - '$price' + ('$change_amount'*'$price2')
                                            WHERE userid = '$userid'";
            mysqli_query($con,$update_preke_krepselis_pagalbinis);
            mysqli_query($con,$update_krepselis_pagalbinis);
            mysqli_query($con,$update_inventorius);
            $amount = $change_amount;

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
                    Prekės kiekis pakeistas!
                </h4>

                <form method="post" action="
                        "krepselis_change_amount.php?id=<?php echo $id; ?>"
                    <div class="col-lg-4">
                <input type="submit"
                       value="Supratau"
                       class="btn btn-danger"
                       name="btnback">
            </div>
            </div>
            </form>

            </body>
            </html>
            <?php
        } else {
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
                    Tokio kiekio neturime sandelyje!
                </h4>

                <form method="post" action="
                        "krepselis_change_amount.php?id=<?php echo $id; ?>"
                    <div class="col-lg-4">
                        <input type="submit"
                               value="Supratau"
                               class="btn btn-danger"
                               name="btnback">
                    </div>
            </div>
            </form>

            </body>
            </html>
            <?php
        }
    }
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
<div class="container">
<form method='post'>
    <div class="form-group col-lg-4" style="padding-top: 20px">
        <h4>Prekė: <?php echo $name; ?> </h4>
        <p>Kiekis krepšelyje: <?php echo $amount; ?></p>
        <label for="change" class="control-label">Įveskite norimą prekės kiekį:</label>
        <input name='change' type='text' class="form-control input-sm" required pattern="(([1-9]{1})|([1-9]{1}[0-9]{1,}))"
               oninput="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas kiekis);"
               oninvalid="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas kiekis');"/>
        <input type='submit' name='change_button' value='pritaikyti' class="btnbtn-default" required >
    </div>
</form>
    <form method="post" action="krepselis.php">
        <div class="col-lg-4">
            <input type="submit"
                   value="Grįžti"
                   class="btn btn-danger"
                   ame="btnkrepselis">
        </div>
    </form>
</div>
</body>
</html>