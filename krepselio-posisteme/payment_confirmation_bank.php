<?php
session_start();
if ($_SESSION['user'] == "guest") {
    $_SESSION['kicked'] = 'yes';
    $_SESSION['message'] = 'Bandėte patekti į payment_confirmation_bank.php puslapį, tačiau tam neturite privilegijų';
    header("Location: ../logout.php");
    exit;
}
if (($_SESSION['prev'] != "payment_bank") && ($_SESSION['prev'] != "payment")) {
    $_SESSION['kicked'] = 'yes';
    $_SESSION['message'] = 'Bandėte patekti į payment_confirmation_bank.php puslapį, tačiau taip negalima';
    header("Location: ../logout.php");
    exit;
}
$_SESSION['prev'] = 'payment_confirmation_bank';
$galutine_kaina = $_SESSION['galutine_kaina'];
$pirkimai_last_id = $_SESSION['pirkimai_last_id'];
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
    <h4> Mokėjimo duomenys: </h4>
        <p> Bankas: KtuBankas </p>
        <p> Banko sąskaita: 121212121212KTU </p>
        <p> Suma: <?php echo $galutine_kaina; echo " €"; ?> </p>
        <p> Paskirtis: Užsakymas nr. <?php echo $pirkimai_last_id; ?> </p>
    Užsakymas priimtas, bus pradėtas vykdyti gavus apmokėjimą.
    </h4>
    <form method="post" action="../index.php">
    <div class="col-lg-4">
        <input type="submit"
            value="Grįžti"
            class="btn btn-danger"
            name="btnback">
    </div>
    </form>
</div>

</body>
</html>
