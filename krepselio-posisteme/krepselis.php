
<?php
    session_start();
    include "../include/nustatymai.php";
    $userlevel=$_SESSION['ulevel'];
    $con=mysqli_connect("localhost","root","","vartvald");
    if(!$con) {
        die("cannot connect to server");
    }
    $userid = $_SESSION['userid'];

    if ($_SESSION['user'] == "guest") {
        $_SESSION['kicked'] = 'yes';
        $_SESSION['message'] = 'Bandėte patekti į krepselis.php puslapį, tačiau tam neturite privilegijų';
        header("Location: ../logout.php");
        exit;
    }
    $_SESSION['prev'] = 'krepselis';

    $q = "SELECT t.fk_preke_id, t.kiekis, u.pavadinimas AS pavadinimas, ROUND(u.Pardavimo_kaina*t.kiekis, 2) AS prekes_kaina FROM preke_krepselis_pagalbinis t LEFT JOIN prekes u ON t.fk_preke_id = u.id WHERE fk_krepselis_id = '$userid'";
    //$q= "SELECT prekes.*, preke_krepselis_pagalbinis.* FROM prekes JOIN preke_krepselis_pagalbinis ON id = fk_preke_id WHERE fk_krepselis_id ='$userid'";
    $query=mysqli_query($con,$q);

    if(isset($_POST["btn1"])) {
			 header("location:../index.php");
	 }
    if(isset($_POST["coupon"])) {
        $kodas = $_POST['kodas'];
        $check = mysqli_query($con, "SELECT * from nuolaidos WHERE id = '$kodas'");

        if (!$check)
        {
            die('Error: ' . mysqli_error($con));
        }

        if(mysqli_num_rows($check) > 0) {

            $check=mysqli_fetch_array($check);
            $discount = $check['nuolaida'];
            $start_date = $check['galiojimo_pradzia'];
            $end_date = $check['galiojimo_pabaiga'];
            $uses = $check['panaudojimai'];
            $coupon_id = $kodas;
            $_SESSION['coupon_id'] = $coupon_id;
            $current_time = $date = date('Y-m-d h:i:s a');
            if (($current_time >= $start_date) && ($current_time <= $end_date) && ($uses != 0)) {
                $sqlpritaikyti = "
                                UPDATE krepselis_pagalbinis 
                                SET fk_nuolaidos_id = '$kodas', visa_kaina = visa_kaina*( 1- ('$discount'/100))
                                WHERE userid = '$userid'";
                if (!mysqli_query($con, $sqlpritaikyti)) die ("Klaida įrašant:" .mysqli_error($con));
                $wholesum= "SELECT round(visa_kaina, 2) AS visa_kaina FROM krepselis_pagalbinis WHERE userid='$userid' LIMIT 1";
                $wholesum_query=mysqli_query($con,$wholesum);
                $wholesum_queryquery=mysqli_fetch_array($wholesum_query);
                $visakaina = $wholesum_queryquery['visa_kaina'];
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
                        Nuolaidos kodas pritaikytas!
                        Nauja užsakymo suma: <?php echo $visakaina; echo " €"; ?>
                    </h4>

                    <form method="post" action="krepselis.php">
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
                        Nuolaidos kodas nebegalioja arba neegzistuoja!
                    </h4>

                    <form method="post" action="krepselis.php">
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
                    Nuolaidos kodas nebegalioja arba neegzistuoja!
                </h4>

                <form method="post" action="krepselis.php">
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

    $wholesum= "SELECT round(visa_kaina, 2) as visa_kaina FROM krepselis_pagalbinis WHERE userid='$userid' LIMIT 1";
    $wholesum_query=mysqli_query($con,$wholesum);
    $wholesum_queryquery=mysqli_fetch_array($wholesum_query);

    if(isset($wholesum_queryquery)) {
        $visakaina = $wholesum_queryquery['visa_kaina'];
    }

    if(isset($_POST["submit_delivery"])) {
        if (!empty($_POST['address'])) {
            $address = $_POST['address'];
        }
        if (!empty($_POST['person_responsible'])) {
            $person_responsible = $_POST['person_responsible'];
        } else {
            $user_name_sql = "SELECT name, surname FROM users where userid = '$userid'";
            $user_name_query=mysqli_query($con,$user_name_sql);
            $user_name_queryquery=mysqli_fetch_array($user_name_query);
            $user_name = $user_name_queryquery['name'];
            $user_surname = $user_name_queryquery['surname'];
            $person_responsible = $user_name . ' ' . $user_surname;
        }
        if (!empty($_POST['comment'])) {
            $comment = $_POST['comment'];
        } else {
            $comment = "-";
        }
        if (!empty($_POST['delivery_type'])) {
            $delivery_type = $_POST['delivery_type'];
            if ($delivery_type == "LPASTAS") {
                $mokestis = 1.8;
            } else if ($delivery_type == "LP EXPRESS") {
                $mokestis = 1.45;
            } else {
                $mokestis = 1.6;
            }
        }
        $delivery_sql = "INSERT INTO pristatymai_pagalbinis (adresas, fk_vartotojo_id, mokestis, budas, atsiimantis_asmuo, komentaras) VALUES ('$address', '$userid', '$mokestis', '$delivery_type', '$person_responsible', '$comment')";
        if (!mysqli_query($con, $delivery_sql)) die ("Klaida įrašant:" .mysqli_error($con));
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
                Pristatymo duomenys priimti!
            </h4>

            <form method="post" action="krepselis.php">
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

    if(isset($_POST["delete_delivery"])) {
        $delete_delivery_sql = "DELETE FROM pristatymai_pagalbinis WHERE fk_vartotojo_id = '$userid'";
        if (!mysqli_query($con, $delete_delivery_sql)) die ("Klaida ištrinant:" .mysqli_error($con));
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
                Pristatymo duomenys ištrinti!
            </h4>

            <form method="post" action="krepselis.php">
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

    if(isset($_POST["payup"])) {
        $delivery_applied = "SELECT fk_vartotojo_id FROM pristatymai_pagalbinis WHERE fk_vartotojo_id='$userid' LIMIT 1";
        $delivery_applied_query=mysqli_query($con,$delivery_applied);
        $delivery_applied_queryquery=mysqli_fetch_array($delivery_applied_query);
        $doesDeliveryExist = $delivery_applied_queryquery['fk_vartotojo_id'];
        if (is_null($doesDeliveryExist)) {
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
                    Neužpildyti pristatymo duomenys! <br>
                    Pirmiausia užpildykite pristatymo duomenis, tuomet galėsite apmokėti!
                </h4>

                <form method="post" action="krepselis.php">
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
            header("location:payment.php");
        }
    }
?>

<html>
  
<head>
    <meta http-equiv="Content-Type" 
        content="text/html; charset=UTF-8">
  
    <title>Mano krepšelis</title>
  
    <link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  
    <link rel="stylesheet" 
        href="css/style.css">
</head>
  
<body>
    <div style="width: 100%;" class="container mt-5">

        <!-- top -->
        <div class="row">
            <div class="col-lg-8">
                <h1>Mano krepšelis</h1>
            </div>
        </div>

        <!-- Grocery Cards -->
        <div class="row mt-4">
<?php
if (mysqli_num_rows($query)!=0) {
?>
            <?php
                while ($qq=mysqli_fetch_array($query))
                {
            ?>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo $qq['pavadinimas']; ?>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <p class="text-info">Kiekis:
                                <?php echo $qq['kiekis']; ?>
                            </p>
                        </h6>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <p class="text-info">Kaina:
                                <?php echo $qq['prekes_kaina']; echo " €"; ?>
                            </p>
                        </h6>

                        <a href=
                        "krepselis_change_amount.php?id=<?php echo $qq['fk_preke_id']; ?>"
                            class="card-link">
                            Keisti kiekį
                        </a>
                        <a href=
                        "krepselis_delete.php?id=<?php echo $qq['fk_preke_id']; ?>"
                            class="card-link">
                            Pašalinti
                        </a>
                    </div>
                </div><br>
            </div>

            <?php
            }
            ?>
			            <?php
	         if(isset($_POST["btn1"])) {
			 header("location:operacija1.php");
		 }
            ?>
        </div>
            <h6 class="card-subtitle mb-2 text-muted">
                <p style="color: black;">Prekių bendra kaina:
                    <?php echo $visakaina; echo " €"; ?>
                </p>
            </h6>

        <?php
            $couponapplied= "SELECT fk_nuolaidos_id FROM krepselis_pagalbinis WHERE userid='$userid' LIMIT 1";
            $couponapplied_query=mysqli_query($con,$couponapplied);
            $couponapplied_queryquery=mysqli_fetch_array($couponapplied_query);
            $isCouponApplied = $couponapplied_queryquery['fk_nuolaidos_id'];
            if (is_null($isCouponApplied)) {
                ?>
            <form method='post'>
                <div class="form-group col-lg-4" style="margin-left: auto; margin-right: 0;">
                <label for="kodas" class="control-label">Pritaikyti nuolaidos kodą:</label>
                    <input name='kodas' type='text' class="form-control input-sm" required pattern="(([1-9]{1})|([1-9]{1}[0-9]{1,}))"
                           oninput="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas nuolaidos kodas);"
                           oninvalid="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas nuolaidos kodas');"/>
                    <input type='submit' name='coupon' value='pritaikyti' class="btnbtn-default" required >
                    <p style="font-size: 10px">PERSPĖJIMAS: nuolaidos kodas bus pritaikytas tik krepšelyje šiuo metu esančioms prekėms ir jų pasirinktais kiekiais</p>
                </div>
            </form>
                <?php
            } else {
                ?>
                <h6 class="card-subtitle mb-2 text-muted" style="text-align: right;">
                    <p style="color: black;">Panaudotas nuolaidos kodas:
                        <?php echo $isCouponApplied; ?>
                    </p>
                    <p style="font-size: 10px">PERSPĖJIMAS: nuolaidos kodas nebebus pritaikomas naujoms prekėms ar pakeitus esamų kiekius</p>
                </h6>
        <?php
            }
        ?>

            <h5>Pristatymas</h5>
            <?php
            $galutine_kaina = $visakaina;
            $delivery_applied = "SELECT * FROM pristatymai_pagalbinis WHERE fk_vartotojo_id='$userid' LIMIT 1";
            $delivery_applied_query=mysqli_query($con,$delivery_applied);
            $delivery_applied_queryquery=mysqli_fetch_array($delivery_applied_query);
            $doesDeliveryExist = $delivery_applied_queryquery['fk_vartotojo_id'];
            if (is_null($doesDeliveryExist)) {
                ?>
            <form method='post'>
                <div class="form-group col-lg-4">
                    <label for="address" class="control-label">Adresas:</label>
                    <input name='address' type='textarea' class="form-control input-sm" required placeholder="pvz: Kaunas, Vilniaus g. 9" pattern="^[A-ZĄČĘĖĮŠŲŪ][a-ząčęėįšųū]+,\s[A-ZĄČĘĖĮŠŲŪ][a-ząčęėįšųū]+\s[g][.]\s[0-9]+$"
                           oninput="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas adresas');"
                           oninvalid="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas adresas');"/>
                    <label for="delivery_type">Pasirinkite pristatymo būdą:</label>
                    <select name="delivery_type" id="delivery_type">
                        <option value="LPASTAS">LPASTAS +1.8€</option>
                        <option value="LP EXPRESS">LPEXPRESS +1.45€</option>
                        <option value="DPD">DPD +1.6€</option>
                    </select>
                    <label for="person_responsible" class="control-label">Prekę atsiimančio asmens vardas ir pavardė:</label>
                    <input name='person_responsible' type='textarea' class="form-control input-sm" placeholder="Neprivaloma" pattern="^[A-ZĄČĘĖĮŠŲŪ][a-ząčęėįšųū]+\s[A-ZĄČĘĖĮŠŲŪ][a-ząčęėįšųū]+$"
                           oninput="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas vardas ir pavardė');"
                           oninvalid="setCustomValidity(''); checkValidity(); setCustomValidity(validity.valid ? '' :'Neįvestas arba neteisingai įvestas vardas ir pavardė');"/>
                    <label for="comment" class="control-label">Komentaras:</label>
                    <input name='comment' type='textarea' class="form-control input-sm" placeholder="Neprivaloma">
                    <input type='submit' name='submit_delivery' value='patvirtinti pristatymo duomenis' class="btnbtn-default" required >
                </div>
            </form>
                <?php
            } else {
                ?>
                <h6" style="text-align: left;">
                    <p style="color: black;">Turimi pristatymo duomenys:
                        <br>
                        <br>
                        <?php
                        $existing_address = $delivery_applied_queryquery['adresas'];
                        $existing_person_responsible = $delivery_applied_queryquery['atsiimantis_asmuo'];
                        $existing_comment = $delivery_applied_queryquery['komentaras'];
                        $existing_delivery_type = $delivery_applied_queryquery['budas'];
                        $existing_delivery_cost = $delivery_applied_queryquery['mokestis'];
                        echo nl2br ("Adresas: $existing_address\n");
                        echo nl2br ("Pristatymo būdas: $existing_delivery_type\n");
                        echo nl2br ("Pristatymo mokestis: $existing_delivery_cost €\n");
                        echo nl2br ("Atsiimantis asmuo: $existing_person_responsible\n");
                        echo nl2br ("Komentaras: $existing_comment\n");
                        $galutine_kaina = $visakaina + $existing_delivery_cost;
                        $_SESSION['galutine_kaina'] = $galutine_kaina;
                        ?>
                    </p>
                </h6>
                <form method="post">
                    <div style="text-align: left;">
                        <input type="submit"
                               value="pašalinti duomenis"
                               class="btnbtn-default"
                               name="delete_delivery" required>
                    </div>
                </form>
                <?php
            }
            ?>
            <h6 class="card-subtitle mb-2 text-muted">
                <p style="color: black; text-align: right;">Galutinė kaina:
                    <?php echo $galutine_kaina; echo " €"; ?>
                </p>
            </h6>
            <form method="post">
            <div style="text-align: right;">
                <input type="submit"
                    value="Apmokėti"
                    class="btn btn-danger"
                    name="payup" required>
            </div>
            </form>

        <form method="post" action="../index.php">
            <div class="col-lg-4">
                <input type="submit"
                       value="Grįžti"
                       class="btn btn-danger"
                       name="btn1">
            </div>
        </form>
    </div>
<?php
} else {
    ?>
    <div class="col-lg-12">
    <h6>
        Krepšelyje nėra prekių.
    </h6>
        <form method="post" action="../index.php">
            <div class="col-lg-4">
                <input type="submit"
                       value="Grįžti"
                       class="btn btn-danger"
                       name="btn1">
            </div>
        </form>
    </div>
<?php
}
?>

</body>
  
</html>
