<?php
require_once "connection.php";
$g = $_GET["token"];
if($g != "") {
    $sql = "SELECT * FROM reset WHERE token = '$g'"; 
    $result = $link->query($sql); 
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
            $acc = $row["acc"];
            $new = $row["new"];
        }
    }
    if($new == "") {
        exit("<script>location.href='/reset'</script>");
    }
    $new = password_hash($new, PASSWORD_DEFAULT);
    $sql = "UPDATE accounts SET pass = '$new' WHERE id = $acc";
    if(mysqli_query($link, $sql)) {
        $sql = "DELETE FROM reset WHERE token = '$g'";
        if(mysqli_query($link, $sql)) {
            echo "<script>location.href='/login.php'</script>";
        } else {
            echo "MySQL Error";
        }
    } else {
        echo "MySQL Error";
    }
} else {
    echo '
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    <script>
        function pass() {
            $("#msg").html("Загрузка...");
            var email = $("#email").val();
            $.ajax({
                type: "POST",
                url: "scripts/reset.php",
                data: { email:email }
            }).done(function(result) {
                if(result == 1) {
                    $("#msg").html("Почта неверная");
                } else if(result == 2) {
                    $("#msg").html("На почту было отправленно письмо с новым паролем и ссылкой для смены. Проверьте папку спама");
                    $("#email").val("");
                } else if(result == -1) {
                    $("#msg").html("Ошибка сервера");
                } else if(result == 3) {
                    $("#msg").html("Вы уже запросили сброс пароля");
                } else {
                    $("#msg").html(result);
                }
            });
        }
    </script>
    <body>
        <p id="msg"></p>
        <input id="email" placeholder="Почта"/>
        <br /><button onclick="pass()">Сброс пароля</button>
    </body>';
}
?>