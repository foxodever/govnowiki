<?php
require_once "connection.php";
if($auth != 0) {
    exit("<script>location.href='/'</script>");
}
?>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
    function reg() {
        $("#msg").html("Загрузка...");
        var nick = $("#nick").val();
        var pass = $("#pass").val();
        var email = $("#email").val();
        var rl = $("#rl").val();
        $.ajax({
            type: "POST",
            url: "scripts/register.php",
            data: { nick:nick, pass:pass, rl:rl, email:email }
        }).done(function(result) {
            if(result == 1) {
                $("#msg").html("Заполните поля");
            } else if(result == 2) {
                $("#msg").html("Почта неправильная");
            } else if(result == 3) {
                $("#msg").html("Ник занят");
                $("#nick").val("");
            } else if(result == 5) {
                $("#msg").html("На вашу почту отправленно письмо с подтверждением аккаунта");
                $("#nick").val("");
                $("#pass").val("");
                $("#email").val("");
            } else if(result == -1) {
                $("#msg").html("Ошибка сервера");
            }
        });
    }
</script>
<body>
<p id="msg"></p>
<input id="nick" type="text" placeholder="Ник"/><br />
<input id="pass" type="password" placeholder="Пароль"/><br />
<input id="email" type="text" placeholder="Почта"/><br />
<input id="rl" type="text" placeholder="Реальное имя"/><br />
<button onclick="reg()">Регистрация</button>
</body>
