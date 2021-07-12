<?php
require_once "connection.php";
if($auth != 0) {
    exit("-1");
}
$nick = $_POST["nick"];
$pass = $_POST["pass"];
$ip = $_SERVER['REMOTE_ADDR'];
if($nick != "" && $pass != "") {

} else {
    exit("1");
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
if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $sql = "SELECT * FROM accounts WHERE nick = '$nick'"; 
    $result = mysqli_query($link, $sql);
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
            $hash = $row["pass"]; 
            $id = $row["id"];
        } 
    }
    if($hash == "") {
        exit("2");
    }
    if(password_verify($pass, $hash)) {
        $sql = "SELECT * FROM session WHERE ip = '$ip' AND acc = $id"; 
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $token = $row["token"];
            } 
        }
        if($token != "") {
            echo "<script>document.cookie = 'token=$token; expires=Thu, 01 Jan 3000 00:00:01 GMT';location.href='/';</script>";
        } else {
            $token = generate(15);
            $sql = "INSERT INTO session (acc, token, ip) VALUES ($id, '$token', '$ip')";
            if(mysqli_query($link, $sql)) {
                echo "<script>document.cookie = 'token=$token; expires=Thu, 01 Jan 3000 00:00:01 GMT';location.href='/';</script>";
            } else {
                echo "-1";
            }
        }
    } else {
        echo "3";
    }
} else {
    $sql = "SELECT * FROM accounts WHERE email = '$email'"; 
    $result = mysqli_query($link, $sql);
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
            $hash = $row["pass"]; 
            $id = $row["id"];
        } 
    }
    if($hash == "") {
        exit("2");
    }
    if(password_verify($pass, $hash)) {
        $sql = "SELECT * FROM session WHERE ip = '$ip' AND acc = $id"; 
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $token = $row["token"];
            } 
        }
        if($token != "") {
            echo "<script>document.cookie = 'token=$token; expires=Thu, 01 Jan 3000 00:00:01 GMT';location.href='/';</script>";
        } else {
            $token = generate(15);
            $sql = "INSERT INTO session (acc, token, ip) VALUES ($id, '$token', '$ip')";
            if(mysqli_query($link, $sql)) {
                echo "<script>document.cookie = 'token=$token; expires=Thu, 01 Jan 3000 00:00:01 GMT';location.href='/';</script>";
            } else {
                echo "-1";
            }
        }
    } else {
        echo "3";
    }
}
?>