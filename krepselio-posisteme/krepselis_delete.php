<?php
    session_start();
    $con=mysqli_connect("localhost","root","","vartvald");
    if(!$con)
    {
        die("cannot connect to server");
    }
    $userid = $_SESSION['userid'];
    $id = $_GET['id'];

    $amount_to_readd_to_inventorius = "SELECT kiekis FROM preke_krepselis_pagalbinis WHERE fk_preke_id = '$id' AND fk_krepselis_id = '$userid'";
    $amount_to_readd=mysqli_query($con,$amount_to_readd_to_inventorius);
    $amount=mysqli_fetch_array($amount_to_readd);
    $kiekis = $amount['kiekis'];

    $update_krepselis = "
                UPDATE krepselis_pagalbinis 
                SET visas_kiekis = visas_kiekis-(SELECT kiekis FROM preke_krepselis_pagalbinis WHERE fk_preke_id = '$id' AND fk_krepselis_id = '$userid'),
                visa_kaina = visa_kaina-((SELECT Pardavimo_kaina FROM prekes WHERE id = '$id')*(SELECT kiekis FROM preke_krepselis_pagalbinis WHERE fk_preke_id = '$id' AND fk_krepselis_id = '$userid'))
                WHERE userid = '$userid'
            ";
    $q = "delete from preke_krepselis_pagalbinis where fk_preke_id = '$id' AND fk_krepselis_id = '$userid'";
    mysqli_query($con,$update_krepselis);
    mysqli_query($con,$q);

    $update_inventorius = "UPDATE inventorius SET Kiekis = Kiekis + '$kiekis' WHERE id = '$id'";
    mysqli_query($con,$update_inventorius);

    $checkIfNoItemsLeftSQL= "SELECT visas_kiekis FROM krepselis_pagalbinis WHERE userid='$userid' LIMIT 1";
    $checkIfNoItemsLeft_query=mysqli_query($con,$checkIfNoItemsLeftSQL);
    $checkIfNoItemsLeft_queryquery=mysqli_fetch_array($checkIfNoItemsLeft_query);
    $itemCount = $checkIfNoItemsLeft_queryquery['visas_kiekis'];
    if ($itemCount == 0) {
        $update_krepselis2 = "
                UPDATE krepselis_pagalbinis 
                SET visas_kiekis = 0,
                visa_kaina = 0,
                fk_nuolaidos_id = NULL
                WHERE userid = '$userid'
            ";
        mysqli_query($con,$update_krepselis2);
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

<div class="container" style="margin-top: 50px;">
    <h4>
        Prekė pašalinta iš krepšelio!
    </h4>

    <form method="post" action="krepselis.php">
        <div class="col-lg-4">
            <input type="submit"
                   value="Mano krepšelis"
                   class="btn btn-danger"
                   name="btnback">
        </div>
</div>
</form>

</body>
</html>
