
<?php
require_once "connection.php";
if($auth != 0) {
    exit("<script>location.href='/'</script>");
}
?>
<script src="https://code.jquery.com/jquery-latest.js"></script>
<script>
    function log() {
        $("#msg").html("Загрузка...");
        var nick = $("#nick").val();
        var pass = $("#pass").val();
        $.ajax({
            type: "POST",
            url: "scripts/login.php",
            data: { nick:nick, pass:pass }
        }).done(function(result) {
            if(result == 1) {
                $("#msg").html("Заполните поля");
            } else if(result == 2) {
                $("#msg").html("Аккаунт не найден");
            } else if(result == 3) {
                $("#msg").html("Пароль не верный");
                $("#pass").val("");
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
<input id="nick" type="text" placeholder="Ник или почта"/><br />
<input id="pass" type="password" placeholder="Пароль"/><br />
<button onclick="log()">Вход</button>
<p><a href='/reset.php'>Сброс пароля</a> <a href='/register.php'>Регистрация</a></p>
</body>
