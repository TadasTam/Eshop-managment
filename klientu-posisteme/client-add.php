<link rel="stylesheet" href=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" href="css/style.css">
<div style="margin: auto;width: 60%;padding: 10px;">

<a class="btn btn-danger" href="./client-menu.php">Atgal</a>
<h1>Pridėti klientą</h1>
<form action="client-add.php" method="POST">
    <table class="table table-hover">
<tr><td>Kliento vardas:</td><td><input type="text" name="name" value=""></td></tr>
<tr><td>Kliento pavardė:</td><td><input type="text" name="surname" value=""></td></tr>
<tr><td>Kliento slapyvardis:</td><td><input type="text" name="username" value=""></td></tr>
<tr><td>Kliento paštas:</td><td><input type="text" name="email" value=""></td></tr>
<tr><td>Kliento telefonas:</td><td><input type="text" name="phone" value=""></td></tr>
</table>
<button type="submit">Pridėti klientą</button>
</form>
<?php
include("client-connect.php");
if (!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['phone'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = substr(hash('sha256', $surname),5,32);
    $userid = substr(hash('sha256', $username),5,32);
    $sql = "INSERT INTO users (name, surname, username, password, userid, userlevel, email, phone, type) VALUES
                    ('$name', '$surname', '$username', '$password', '$userid', 4, '$email', '$phone', 'klientas')";
    if ($con->query($sql) === TRUE) {
        echo "Naujas klientas pridėtas";
        send_request_to_server($name, $email);
        goback();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $con->close();
}
else {
    if (!empty($_POST))
        echo "Neįvesti visi duomenys";
}

function goback() {
    header("Location: client-list.php");
    exit;
}

function send_request_to_server($name, $email) {
    $to = $email;
    $subject = "Registracija";
    $message = "Sveiki, $name! Jūsų registracija sėkminga. Jūsų prisijungimo vardas: $email. Jūsų slaptažodis: $password";
    $headers = "From: $email";
    mail($to,$subject,$message,$headers);
}
?>
</div>