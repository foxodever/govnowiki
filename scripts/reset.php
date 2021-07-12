<?php
require_once "connection.php";
if($auth != 0) {
    exit("-1");
}
$email = $_POST["email"];
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("1");
}
$sql = "SELECT * FROM accounts WHERE email = '$email'"; 
$result = $link->query($sql); 
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $nick = $row["nick"]; 
        $id = $row["id"]; 
    }
}
if($nick == "") {
    exit("2");
}
$sql = "SELECT * FROM reset WHERE acc = $id"; 
$result = $link->query($sql); 
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $acc = $row["acc"]; 
    }
}
if($acc != "") {
    exit("3");
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
$new = generate(5);
$code = generate(10);
$sql = "INSERT INTO reset (acc, new, token) VALUES ($id, '$new', '$code')";
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
    
    $mail->Subject = 'Сброс пароля';
    $mail->Body    = "<h1 align=center>Здравствуйте $nick</h1><p align=center>Был запрошен сброс пароля. Если это были не вы, просто игнорируйте это письмо:</p>
    <p align=center><a href='https://wiki.aptkop.ru/reset.php?token=$code' style='color:blue;text-decoration:none'>Нажмите для изменения пароля на $new</a></p>
    <p align=center>Не можете открыть ссылку? https://wiki.aptkop.ru/reset.php?token=$code</p>";
    $mail->AltBody = '';
    if($mail->send()) {
        echo "2";
    } else {
        echo "-1";
    }
} else {
    echo "-1";
}
?>