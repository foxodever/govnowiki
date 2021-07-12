<?php
include "wiki.php";
require_once "connection.php";
$wiki = new wiki;
$id = $_GET["id"];
$sql = "SELECT * FROM history WHERE id = $id"; 
$result = $link->query($sql); 
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $nick = getNick($row["acc"]);
        $date = $row["date"];
        $old = $row["old"];
        $new = $row["new"];
    }
}
$newc = count_chars($new);
$oldc = count_chars($old);
if($oldc > $newc) {
    $aaa = "Статься стала меньше";
} else if($oldc < $newc) {
    $aaa = "Статься стала больше";
} else if($olc == $newc) {
    $aaa = "Статься не поменяла размер";
}
echo '<div>Ник: '.$nick.' <br/> Дата: '.$date.' </div><hr>Старое:';
$st = $old;
echo "<textarea style='width:100%;height:30%' readonly=1 id='new'>$st</textarea><br />";
echo "Новое:";
$st = $new;
echo "<textarea style='width:100%;height:30%' readonly=1 id='new'>$st</textarea><br />$aaa";
?>