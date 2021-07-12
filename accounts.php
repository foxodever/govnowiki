<?php
require_once "connection.php";
class accounts {
    public function check_nick($nick) {
        $link = $GLOBALS["link"];
        $sql = "SELECT * FROM accounts WHERE nick = '$nick'"; 
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $check = $row["nick"]; 
            } 
        }
        $sql = "SELECT * FROM reg WHERE nick = '$nick'"; 
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $check1 = $row["nick"]; 
            } 
        }
        if($check1 == "" && $check == "") {
            return 1;
        } else {
            return 0;
        }
    }
?>