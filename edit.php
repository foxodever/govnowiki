<?php
require_once "connection.php";

if($auth != 1) {
    exit("-1");
}
$isd = $_POST["id"];
$new = $_POST["nesw"];
$sql = "SELECT * FROM pages WHERE num = '$isd'"; 
$result = $link->query($sql); 
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $check = $row["access"]; 
    }
}
if($check != 1) {
    exit("Статью нельзя редактировать");
}
if($isd != "" && $new != "") {
    $sql = "SELECT * FROM pages WHERE num = '$isd'"; 
    $result = $link->query($sql); 
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
            $content = $row["content"]; 
        }
    }
    if($content == $new) {
        exit("Сделайте изменения");
    }
    if($content == "") {
        exit("-1");
    }
    date_default_timezone_set('Europe/Moscow');
    $date = date("d-m-Y H:m:s");
    $sql = "INSERT INTO history (acc, old, new, date, attach) VALUES ($user_id, '$content', '$new', '$date', '$isd')";
    if(mysqli_query($link, $sql)) {
        $sql = "UPDATE pages SET content = '$new' WHERE num = '$isd'";
        if(mysqli_query($link, $sql)) {
            echo "2";
        } else {
            echo "-1";
        }
    } else {
        exit("-1");
    }
} else {
    exit("1");
}
?>