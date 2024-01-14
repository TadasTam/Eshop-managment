<?php
    session_start();
    $con=mysqli_connect("localhost","root","","vartvald");
    if(!$con) {
        die("cannot connect to server");
    }
    $userid = $_SESSION['userid'];

    if ($_SESSION['user'] == "guest") {
        $_SESSION['kicked'] = 'yes';
        $_SESSION['message'] = 'Bandėte patekti į payment.php puslapį, tačiau tam neturite privilegijų';
        header("Location: ../logout.php");
        exit;
    }
    if (($_SESSION['prev'] != "krepselis") && ($_SESSION['prev'] != "payment") && ($_SESSION['prev'] != "payment_card") && ($_SESSION['prev'] != "payment_bank")) {
        $_SESSION['kicked'] = 'yes';
        $_SESSION['message'] = 'Bandėte patekti į payment.php puslapį, tačiau taip negalima';
        header("Location: ../logout.php");
        exit;
    }
    $_SESSION['prev'] = 'payment';
//    $q = "
//            INSERT INTO preke_pirkimai_tarpinis (fk_preke_id, kiekis) VALUES ((SELECT id from prekes where Id = $id), 1)
//    ";
//    mysqli_query($con,$q);
//	header('location:operacija1.php');
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
<div class="container mt-5">
<?php
if (!isset($_POST["payment_type"])) {
    ?>
<h3>Apmokėjimas</h3>
<div class="container">
    <form method='post'>
        <label for="p_type">Pasirinkite apmokėjimo būdą:</label>
        <select name="p_type" id="p_type">
        <option value="kortele">Kortele</option>
        <option value="grynais">Grynais</option>
        <option value="bankopavedimu">Banko pavedimu</option>
        </select>
        <input type='submit' name='payment_type' value='patvirtinti' class="btnbtn-default" required >
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
<?php
}
?>

<?php
if (isset($_POST["payment_type"])) {
    if ($_POST['p_type']=="kortele") {
        header("location:payment_card.php");
    }
    
    if ($_POST['p_type']=="grynais") {
        $get_delivery_sql = "SELECT * FROM pristatymai_pagalbinis WHERE fk_vartotojo_id='$userid' LIMIT 1";
        $delivery_query=mysqli_query($con,$get_delivery_sql);
        $delivery_qq=mysqli_fetch_array($delivery_query);
        $adresas = $delivery_qq['adresas'];
        $mokestis = $delivery_qq['mokestis'];
        $budas = $delivery_qq['budas'];
        $atsiimantis_asmuo = $delivery_qq['atsiimantis_asmuo'];
        $komentaras = $delivery_qq['komentaras'];
        $pristatymai_sql = "INSERT INTO pristatymai
                        (adresas, statusas, fk_vartotojo_id, mokestis, budas, atsiimantis_asmuo, komentaras)
                        VALUES ('$adresas', 1, '$userid', '$mokestis', '$budas', '$atsiimantis_asmuo', '$komentaras')";
        if (mysqli_query($con, $pristatymai_sql)) {
            $pristatymai_last_id = mysqli_insert_id($con);
        } else {
            die ("Klaida įrašant:" .mysqli_error($con));
        }

        $apmokejimas_sql = "INSERT INTO apmokejimas
                        (apmokejimo_budas)
                        VALUES (2)";
        if (mysqli_query($con, $apmokejimas_sql)) {
            $apmokejimas_last_id = mysqli_insert_id($con);
        } else {
            die ("Klaida įrašant:" .mysqli_error($con));
        }

        $get_krepselis_sql = "SELECT * FROM krepselis_pagalbinis WHERE userid='$userid' LIMIT 1";
        $krepselis_query=mysqli_query($con,$get_krepselis_sql);
        $krepselis_qq=mysqli_fetch_array($krepselis_query);
        $visaskiekis = $krepselis_qq['visas_kiekis'];
        // $visa_kaina = round($krepselis_qq['visa_kaina'], 2);
        $galutine_kaina = $_SESSION['galutine_kaina'];
        $nuolaida = $krepselis_qq['fk_nuolaidos_id'];
        if (is_null($nuolaida)) {
            $pirkimai_sql = "INSERT INTO pirkimai
                        (kaina, prekiu_kiekis, fk_vartotojas_id, fk_pristatymo_id, fk_apmokejimo_budo_id)
                        VALUES ('$galutine_kaina', '$visaskiekis', '$userid', '$pristatymai_last_id', '$apmokejimas_last_id')";
        } else {
            $pirkimai_sql = "INSERT INTO pirkimai
                        (kaina, prekiu_kiekis, fk_vartotojas_id, fk_pristatymo_id, fk_apmokejimo_budo_id, fk_nuolaidos_id)
                        VALUES ('$galutine_kaina', '$visaskiekis', '$userid', '$pristatymai_last_id', '$apmokejimas_last_id', '$nuolaida')";
        }
        if (mysqli_query($con, $pirkimai_sql)) {
            $pirkimai_last_id = mysqli_insert_id($con);
        } else {
            die ("Klaida įrašant:" .mysqli_error($con));
        }

        $get_preke_krepselis_sql = "SELECT * FROM preke_krepselis_pagalbinis WHERE fk_krepselis_id='$userid'";
        $preke_krepselis_query=mysqli_query($con,$get_preke_krepselis_sql);
        while ($preke_krepselis_qq=mysqli_fetch_array($preke_krepselis_query)) {
            $prekes_id = $preke_krepselis_qq['fk_preke_id'];
            $kiekis = $preke_krepselis_qq['kiekis'];
            $preke_krepselis_sql = "INSERT INTO preke_pirkimai_tarpinis
                        (fk_preke_id, fk_pirkimas_id, pirktas_kiekis)
                        VALUES ('$prekes_id', '$pirkimai_last_id', '$kiekis')";
            if (!mysqli_query($con, $preke_krepselis_sql)) die ("Klaida įrašant:" .mysqli_error($con));
        }

        $delete_preke_krepselis_pagalbinis_sql = "DELETE FROM preke_krepselis_pagalbinis WHERE fk_krepselis_id='$userid'";
        $delete_krepselis_pagalbinis_sql = "DELETE FROM krepselis_pagalbinis WHERE userid='$userid'";
        if (!mysqli_query($con, $delete_preke_krepselis_pagalbinis_sql)) die ("Klaida įrašant:" .mysqli_error($con));
        if (!mysqli_query($con, $delete_krepselis_pagalbinis_sql)) die ("Klaida įrašant:" .mysqli_error($con));

        $coupon_id = $_SESSION['coupon_id'];
        $sql_update_coupon = "
                                UPDATE nuolaidos
                                SET panaudojimai = panaudojimai - 1
                                WHERE id = '$coupon_id'";
        if (!mysqli_query($con, $sql_update_coupon)) die ("Klaida įrašant:" .mysqli_error($con));
        header("location:payment_confirmation.php");
    }
    
    if ($_POST['p_type']=="bankopavedimu") {
        header("location:payment_bank.php");
    }
}
?>
</div>
</body>
</html>
