<?php
include "wiki.php";
require_once "connection.php";
$wiki = new wiki;
$id = $_GET["id"];
$check = $wiki->check_ex($id);
if($check == 0) {
    exit("Статья не найдена");
} 
$sql = "SELECT * FROM history WHERE attach = '$id'"; 
$result = $link->query($sql); 
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $nick = getNick($row["acc"]);
        echo '<div>Ник: '.$nick.' | Дата: '.$row["date"].' | <button onclick="location.href=\'/view_c.php?id='.$row["id"].'\'">Просмотр</button></div><hr>';
    }
}
?>