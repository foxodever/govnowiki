<?php
require_once "connection.php";
$token = $_GET["token"];
if($token != "") {
    $sql = "SELECT * FROM reg WHERE token = '$token'"; 
    $result = mysqli_query($link, $sql);
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
            $nick = $row["nick"]; 
            $pass = $row["pass"]; 
            $email = $row["email"]; 
            $rl = $row["realname"];
        } 
    }
    if($nick != "") {
        date_default_timezone_set('Europe/Moscow');
        $date = date("d-m-Y");
        $sql = "INSERT INTO accounts (nick, pass, email, realname, date) VALUES ('$nick', '$pass', '$email', '$rl', '$date')";
        if(mysqli_query($link, $sql)) {
            $sql = "DELETE FROM reg WHERE token = '$token'";
            if(mysqli_query($link, $sql)) {
                echo "<script>location.href='/thanks.php'</script>";
            } else {
                echo "Ошибка";
            }
        } else {
            echo "Ошибка";
        }
    } else {
        include "404.php";
    }
} else {
    include "404.php";
}
?>