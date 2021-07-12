<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
function create() {
    $("#msg").html("Загрузка...");
    var content = $("#content").val();
    var title = $("#title").val();
    $.ajax({
        type: "POST",
        url: "scripts/create.php",
        data: { title:title, content:content }
    }).done(function(result) {
        if(result == 1) {
            $("#msg").html("Заполните поля");
        } else if(result == 2) {
            $("#msg").html("Статься с таким заголовком уже существует");
        } else if(result == -1) {
            $("#msg").html("Ошибка");
        } else {
            $("#msg").html(result);
        }
    });
}
function view() {
    $("#msg").html("Загрузка...");
    var nesw = $("#content").val();
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
<p id="msg"></p> <input id="title" placeholder='заголовок'/><br /><br /><textarea style='width:100%;height:50%' id='content'>
==== Привет! Добро пожаловать в редактор ====
Удачи в создании статьи
</textarea><br />
<button onclick='create()'>Создать</button> <button onclick='view()'>Просмотр</button>
<p><a onclick="test('**Текст**')">Жир</a> <a onclick="test('==== Заголовок 1 ====')">Заголовок</a>
<a onclick="test('__Подчёркнутый текст__')">Подчёркивание</a> <a onclick="test('<del>Зачёркнутый</del>')">зачёркнутость</a> </p>
<script>
function test(str){  
    var tc = document.getElementById("content");  
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