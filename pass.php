<?php
require_once "connection.php";
if($auth != 1) {
    exit("-1");
}
$new = $_POST["ne"];
$old = $_POST["old"];
if($new == "" or $old == "") {
    exit("1");
}
$sql = "SELECT pass FROM accounts WHERE id = $user_id"; 
$result = $link->query($sql); 
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $pass = $row["pass"]; 
    }
}
if(!password_verify($old, $pass)) {
    exit("2");
}
$new = password_hash($new, PASSWORD_DEFAULT);
$sql = "UPDATE accounts SET pass = '$new' WHERE id = $user_id";
if(mysqli_query($link, $sql)) {
    echo "3";
} else {
    echo "-1";
}
?>