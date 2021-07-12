<?php
$host = 'Хост';
$database = 'ДБ';
$user = 'Юзер';
$password = 'Пароль';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
     error_reporting(0);
    $token = htmlspecialchars($_COOKIE["token"]);
    $link->set_charset('utf8');
    $sql = "SELECT * FROM session WHERE token = '$token'"; 
    $result = mysqli_query($link, $sql);
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
            $tk = $row["token"];
            $acc = $row["acc"];
        } 
    }
    $sql = "SELECT * FROM accounts WHERE id = $acc"; 
    $result = mysqli_query($link, $sql);
    if ($result->num_rows > 0) { 
        while($row = $result->fetch_assoc()) { 
            $role = $row["role"];
        } 
    }
    if($tk != "") {
        $auth = 1;
        $user_id = $acc;
        $user_role = $role;
    } else {
        $auth = 0;
    }
    function getNick($idss) {
        $links = $GLOBALS["link"];
        $sql = "SELECT nick FROM accounts WHERE id = $idss"; 
        $result = $links->query($sql); 
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $nickss = $row["nick"]; 
            }
        }
        return $nickss;
    }
    function getRl($idss) {
        $links = $GLOBALS["link"];
        $sql = "SELECT realname FROM accounts WHERE id = $idss"; 
        $result = $links->query($sql); 
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $nickss = $row["realname"]; 
            }
        }
        return $nickss;
    }
    function getAbout($idss) {
        $links = $GLOBALS["link"];
        $sql = "SELECT about FROM accounts WHERE id = $idss"; 
        $result = $links->query($sql); 
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $nickss = $row["about"]; 
            }
        }
        return $nickss;
    }
?>
