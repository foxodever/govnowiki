<?php
require_once "connection.php";
if($auth != 1) {
    exit("-1");
}
$title = $_POST["title"];
$content = $_POST["content"];
if($title == "" or $content == "") {
    exit("1");
}
$content = str_replace("'", "\'", $content);
$content = str_replace('"', '\"', $content);
$title1 = str_replace(" ", "_", $title);
$sql = "SELECT * FROM pages WHERE title = '$title'"; 
$result = mysqli_query($link, $sql);
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $ct = $row["content"]; 
    } 
}
if($ct != "") {
    exit("2");
}
date_default_timezone_set('Europe/Moscow');
$date = date("d-m-Y H:m");
$sql = "INSERT INTO pages (title, num, content, acc, date) VALUES ('$title', '$title1', '$content', $user_id, '$date')";
if(mysqli_query($link, $sql)) {
    echo "Успех! <a href='/view.php?id=$title1'>Просмотр</a>";
} else {
    echo "-1";
}
?>