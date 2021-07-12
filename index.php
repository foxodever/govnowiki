<?php
require_once "connection.php";
include "wiki.php";
$wiki = new wiki;
if($auth == 1) {
    echo "Залогинен";
} else {
    echo "Не залогинен";
}
if($auth == 1) {
    $rl = getRl($user_id);
    echo "<br />Привет, $rl";
    $nick = getNick($user_id);
    echo "<br />Ваш ник ";
    echo $nick;
    echo "<br /><button onclick='location.href=`/create.php`'>Создать статью</button>";
} 
echo " <button onclick='location.href=`/search.php`'>Найти статью</button> <button onclick='location.href=`/lk.php`'>Личный кабинет</button>";
?>