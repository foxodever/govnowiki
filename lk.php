<?php
require_once "connection.php";
if($auth != 1) {
    exit("<script>location.href='/login.php'</script>");
}
?>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
    function pass() {
        $("#msg").html("Загрузка...");
        var ne = $("#new").val();
        var old = $("#old").val();
        $.ajax({
            type: "POST",
            url: "scripts/pass.php",
            data: { ne:ne, old:old }
        }).done(function(result) {
            if(result == 1) {
                $("#msg").html("Заполните поля");
            } else if(result == 2) {
                $("#msg").html("Пароль не верный");
            } else if(result == 3) {
                $("#msg").html("Успех");
                $("#new").val("");
                $("#old").val("");
            } else if(result == -1) {
                $("#msg").html("Ошибка сервера");
            } else {
                $("#msg").html(result);
            }
        });
    }
</script>
<body>
<p id="msg"></p>
<input id="old" type="password" placeholder="Старый пароль"/><br />
<input id="new" type="password" placeholder="Новый пароль"/><br />
<button onclick="pass()">Изменить</button>
</body>