<?php
session_start();
$con=mysqli_connect("localhost","root","","vartvald");
if(!$con) {
    die("cannot connect to server");
}

if ($_SESSION['user'] == "guest") {
    $_SESSION['kicked'] = 'yes';
    $_SESSION['message'] = 'Bandėte patekti į payment_card.php puslapį, tačiau tam neturite privilegijų';
    header("Location: ../logout.php");
    exit;
}
if (($_SESSION['prev'] != "payment") && ($_SESSION['prev'] != "payment_card")) {
    $_SESSION['kicked'] = 'yes';
    $_SESSION['message'] = 'Bandėte patekti į payment_card.php puslapį, tačiau taip negalima';
    header("Location: ../logout.php");
    exit;
}
$_SESSION['prev'] = 'payment_card';

$userid = $_SESSION['userid'];
if (isset($_POST["card_info"])) {
    $card = $_POST['kortele'];
    if ($card == "5555 5555 5555 0000") {
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
                KLAIDA! Apmokėjimas neįvykdytas!
            </h4>

        </div>

        </body>
        </html>
        <?php
    } else {
    $month = $_POST['month'];
    $year = $_POST['year'];
    $current_month =date('m');
    $current_year =date('Y');
    if (($year >= $current_year)) {
        $get_delivery_sql = "SELECT * FROM pristatymai_pagalbinis WHERE fk_vartotojo_id='$userid' LIMIT 1";
        $delivery_query = mysqli_query($con, $get_delivery_sql);
        $delivery_qq = mysqli_fetch_array($delivery_query);
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
            die ("Klaida įrašant:" . mysqli_error($con));
        }

        $apmokejimas_sql = "INSERT INTO apmokejimas
                            (apmokejimo_budas)
                            VALUES (1)";
        if (mysqli_query($con, $apmokejimas_sql)) {
            $apmokejimas_last_id = mysqli_insert_id($con);
        } else {
            die ("Klaida įrašant:" . mysqli_error($con));
        }

        $get_krepselis_sql = "SELECT * FROM krepselis_pagalbinis WHERE userid='$userid' LIMIT 1";
        $krepselis_query = mysqli_query($con, $get_krepselis_sql);
        $krepselis_qq = mysqli_fetch_array($krepselis_query);
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
            die ("Klaida įrašant:" . mysqli_error($con));
        }

        $get_preke_krepselis_sql = "SELECT * FROM preke_krepselis_pagalbinis WHERE fk_krepselis_id='$userid'";
        $preke_krepselis_query = mysqli_query($con, $get_preke_krepselis_sql);
        while ($preke_krepselis_qq = mysqli_fetch_array($preke_krepselis_query)) {
            $prekes_id = $preke_krepselis_qq['fk_preke_id'];
            $kiekis = $preke_krepselis_qq['kiekis'];
            $preke_krepselis_sql = "INSERT INTO preke_pirkimai_tarpinis
                            (fk_preke_id, fk_pirkimas_id, pirktas_kiekis)
                            VALUES ('$prekes_id', '$pirkimai_last_id', '$kiekis')";
            if (!mysqli_query($con, $preke_krepselis_sql)) die ("Klaida įrašant:" . mysqli_error($con));
        }

        $delete_preke_krepselis_pagalbinis_sql = "DELETE FROM preke_krepselis_pagalbinis WHERE fk_krepselis_id='$userid'";
        $delete_krepselis_pagalbinis_sql = "DELETE FROM krepselis_pagalbinis WHERE userid='$userid'";
        if (!mysqli_query($con, $delete_preke_krepselis_pagalbinis_sql)) die ("Klaida įrašant:" . mysqli_error($con));
        if (!mysqli_query($con, $delete_krepselis_pagalbinis_sql)) die ("Klaida įrašant:" . mysqli_error($con));

        $coupon_id = $_SESSION['coupon_id'];
        $sql_update_coupon = "
                                    UPDATE nuolaidos
                                    SET panaudojimai = panaudojimai - 1
                                    WHERE id = '$coupon_id'";
        if (!mysqli_query($con, $sql_update_coupon)) die ("Klaida įrašant:" . mysqli_error($con));
        header("location:payment_confirmation.php");
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
                Įvestas blogas kortelės galiojimo laikas.
            </h4>

        </div>

        </body>
        </html>
        <?php
    }
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

<div class="container" style="margin-top: 50px;">
    <form method='post'>
        <div class="form-group col-lg-4">
            <label for="kortele" class="control-label">Kortelės nr:</label>
            <input name='kortele' type='text' class="form-control input-sm" required pattern="(?:\d{4} ){3}\d{4}"
                   oninput="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas kortelės numeris);"
                   oninvalid="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas kortelės numeris');"/>
            <br>
            <label for="varpav" class="control-label">Vardas Pavardė:</label>
            <input name='varpav' type='text' class="form-control input-sm" required pattern="^[A-ZĄČĘĖĮŠŲŪ][a-ząčęėįšųū]+\s[A-ZĄČĘĖĮŠŲŪ][a-ząčęėįšųū]+$"
                   oninput="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas vardas ir pavardė);"
                   oninvalid="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas vardas ir pavardė');"/>
            <br>
            <label for="cvc" class="control-label">CVC:</label>
            <input name='cvc' type='text' class="form-control input-sm" required pattern="^[0-9]{3}$"
                   oninput="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas kortelės CVC);"
                   oninvalid="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas kortelės CVC');"/>
            <br>
            <label for="adresas" class="control-label">Galioja iki:</label>
            <br>
            <label for="adresas" class="control-label">Mėnesis:</label>
            <select name="month" size='1'>
                <?php
                for ($i = 1; $i < 13; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <label for="adresas" class="control-label">Metai:</label>
            <select name="year" size='1'>
                <?php
                for ($i = (int)date('Y')+1; $i < (int)date('Y')+7; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <br>
            <input type='submit' name='card_info' value='patvirtinti kortelės duomenis ir apmokėti' class="btnbtn-default" required >
        </div>
    </form>
    <form method="post" action="payment.php">
        <div class="col-lg-4">
            <input type="submit"
                   value="Pasirinkti kitą mokėjimo būdą"
                   class="btn btn-danger"
                   name="btnkrepselis">
        </div>
    </form>
    <form method="post" action="krepselis.php">
        <div class="col-lg-4">
            <input type="submit"
                   value="Grįžti į krepšelį"
                   class="btn btn-danger"
                   name="btnkrepselis">
        </div>
    </form>

</div>

</body>
</html>
