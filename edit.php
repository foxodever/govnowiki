<?php
$id = $_GET["id"];
include "wiki.php";
$wiki = new wiki;
$check = $wiki->check_ex($id);
if($check == 0) {
    exit("Статья не найдена");
}
$check = $wiki->check_s($id);
if($check != 1) {
    exit("Статью нельзя редактировать");
}
$st = $wiki->get_content($id);
echo '<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
function edit() {
    $("#msg").html("Загрузка...");
    var id = "'.$id.'";
    var nesw = $("#new").val();
    $.ajax({
        type: "POST",
        url: "scripts/edit.php",
        data: { id:id, nesw:nesw }
    }).done(function(result) {
        if(result == 1) {
            $("#msg").html("Заполните поля");
        } else if(result == 2) {
            $("#msg").html("Успех");
        } else if(result == -1) {
            $("#msg").html("Ошибка");
        } else {
            $("#msg").html(result);
        }
    });
}
function view() {
    $("#msg").html("Загрузка...");
    var nesw = $("#new").val();
    $.ajax({
        type: "POST",
        url: "scripts/view.php",
        data: { nesw:nesw }
    }).done(function(result) {
        if(result == 1) {
            $("#msg").html("Заполните поля");
        } else if(result == -1) {
            $("#msg").html("Ошибка");
        } else {
            $("#view").html(result);
            $("#msg").html("Просмотр");
        }
    });
}
</script>
<p id="msg"></p>';
echo "<textarea style='width:100%;height:50%' id='new'>$st</textarea><br />
<button onclick='edit()'>Изменить</button> <button onclick='view()'>Просмотр</button>";
?>
<p><a onclick="test('**Текст**')">Жир</a> <a onclick="test('==== Заголовок 1 ====')">Заголовок</a>
<a onclick="test('__Подчёркнутый текст__')">Подчёркивание</a> <a onclick="test('<del>Зачёркнутый</del>')">зачёркнутость</a> </p>
<script>
function test(str){  
    var tc = document.getElementById("new");  
    var tclen = tc.value.length;  
    tc.focus();  
    if(typeof document.selection != "undefined")  
    {  
      document.selection.createRange().text = str;   
      tc.focus(); 
    }  
    else  
    {  
      tc.value = 
      tc.value.substr(0, tc.selectionStart) +
      str +
      tc.value.substring(tc.selectionStart, tclen);
    }  
}  
</script>
<div id="view">

</div>