<?php
include "connection.php";
if($auth != 0) {
    exit("-1");
}
$nick = $_POST["nick"];
$pass = $_POST["pass"];
$email = $_POST["email"];
$rl = $_POST["rl"];
if($nick != "" && $pass != "" && $email != "" && $rl != "") {

} else {
    exit("1");
}
$sql = "SELECT * FROM accounts WHERE nick = '$nick'"; 
$result = mysqli_query($link, $sql);
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $check = $row["nick"]; 
        $em = $row["email"];
    } 
}
$sql = "SELECT * FROM reg WHERE nick = '$nick'"; 
$result = mysqli_query($link, $sql);
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $check1 = $row["nick"]; 
        $em1 = $row["email"];
    } 
}
if($check != "") {
    exit("3");
}
if($check1 != "") {
    exit("3");
}
if($em != "" or $em1 != "") {
    exit("4");
}
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("2");
}
function generate($how_long) {
    $length = $how_long;
    $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
    $numChars = strlen($chars);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($chars, rand(1, $numChars) - 1, 1);
    }
    return $string;
}
$code = generate(10);
$hashpass = password_hash($pass, PASSWORD_DEFAULT);
$sql = "INSERT INTO reg (nick, pass, email, realname, token) VALUES ('$nick', '$hashpass', '$email', '$rl', '$code')";
if(mysqli_query($link, $sql)) {
    require("mail/PHPMailerAutoload.php");
    $mail = new PHPMailer;
    $mail->CharSet = 'utf-8';
    
    $mail->isSMTP();
    $mail->Host = 'SMTP сервер';
    $mail->SMTPAuth = true;
    $mail->Username = 'почта';
    $mail->Password = 'пароль'; 
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    
    $mail->setFrom('от кого');
    $mail->addAddress("$email"); 
    $mail->isHTML(true);
    
    $mail->Subject = 'Активация аккаунта';
    $mail->Body    = "<h1 align=center>Здравствуйте $userName</h1><p align=center>Чтобы активировать аккаунт вам потребуется перейти по ссылке:</p>
    <p align=center><a href='https://wiki.aptkop.ru/activate?token=$code' style='color:blue;text-decoration:none'>Нажмите для завершения регистрации</a></p>
    <p align=center>Не можете открыть ссылку? https://wiki.aptkop.ru/activate?token=$code</p>";
    $mail->AltBody = '';
    if($mail->send()) {
        echo "5";
    } else {
        echo "-1";
    }
} else {
    echo "-1";
}
?>