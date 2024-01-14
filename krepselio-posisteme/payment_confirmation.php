<?php
    session_start();

    if ($_SESSION['user'] == "guest") {
        $_SESSION['kicked'] = 'yes';
        $_SESSION['message'] = 'Bandėte patekti į payment_confirmation.php puslapį, tačiau tam neturite privilegijų';
        header("Location: ../logout.php");
        exit;
    }
    if (($_SESSION['prev'] != "payment") && ($_SESSION['prev'] != "payment_card")) {
        $_SESSION['kicked'] = 'yes';
        $_SESSION['message'] = 'Bandėte patekti į payment_confirmation.php puslapį, tačiau taip negalima';
        header("Location: ../logout.php");
        exit;
    }
    $_SESSION['prev'] = 'payment_confirmation';
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
    Užsakymas įvykdytas sėkmingai.
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
