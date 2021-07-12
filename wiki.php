<?php
require_once "connection.php";
class wiki {
    public function check_ex($id) {
        $link = $GLOBALS["link"];
        $sql = "SELECT * FROM pages WHERE num = '$id'"; 
        $result = $link->query($sql); 
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $check = $row["title"]; 
            } 
        }
        if($check == "") {
            return 0;
        } else {
            return 1;
        }
    }
    public function check_s($id) {
        $link = $GLOBALS["link"];
        $sql = "SELECT * FROM pages WHERE num = '$id'"; 
        $result = $link->query($sql); 
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $check = $row["access"]; 
            } 
        }
        return $check;
    }
    public function get_content($id) {
        $link = $GLOBALS["link"];
        $sql = "SELECT * FROM pages WHERE num = '$id'"; 
        $result = $link->query($sql); 
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $content = $row["content"]; 
                return $content;
            } 
        }
    }
    public function get_author($id) {
        $link = $GLOBALS["link"];
        $sql = "SELECT * FROM pages WHERE num = '$id'"; 
        $result = $link->query($sql); 
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $content = $row["content"]; 
            } 
        }
        return $content;
    }
    public function get_nick($token) {
        $link = $GLOBALS["link"];
        $sql = "SELECT * FROM session WHERE num = '$id'"; 
        $result = mysqli_query($link, $sql);
        if ($result->num_rows > 0) { 
            while($row = $result->fetch_assoc()) { 
                $content = $row["content"]; 
            } 
        }
        return $content;
    }
    public function replace($string, $symb, $what) {
        $st = $string;
        $a = substr_count($st, $symb);
        $a = $a + 1;
        $symb = str_replace("/", "\/", $symb);
        $symb = str_replace("*", "\*", $symb);
        $symb = str_replace("'", "\'", $symb);
        $symb = str_replace("|", "\|", $symb);
        $symb = str_replace(":", "\:", $symb);
        if($a != 0) {
            for ($i = 0; $i != $a; $i++) {
                $r = $i;
                if($r % 2 == 0) {
                    $st = preg_replace("/$symb/", "<$what>", $st, 1);
                } else if($r % 2 != 0) {
                    $st = preg_replace("/$symb/", "</$what>", $st, 1);
                }
            }
            return $st;
        } else {
            return -1;
        }
    }
    public function str_r($string, $symb, $what) {
        $st = $string;
        $a = substr_count($st, $symb);
        if($a != 0) {
            $st = str_replace("$symb", "<$what>", $st);
            return $st;
        } else {
            return $st;
        }
    }
    public function betw($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    public function get_link($string) {
        $s = $string;
        $s = str_replace("[[", "", $s);
        $s = str_replace("]]", "", $s);
        $s1 = str_replace("[[", "", $s);
        $s1 = str_replace("]]", "", $s);
        if(strpos($s, "|") !== false) {
            $s = substr($s, 0, strpos($s, '|'));
            return $s;
        } else {
            return "$s1";
        }
    }
    public function get_text($string) {
        $s = $string;
        $s = str_replace("[[", "", $s);
        $s = str_replace("]]", "", $s);
        $st = $string;
        $st = str_replace("[[", "", $st);
        $st = str_replace("]]", "", $st);
        if(strpos($s, "|") !== false) {
            $s = substr($s, 0, strpos($s, '|'));
            $s1 = str_replace("$s|", "", $st);
            return $s1;
        } else {
            return "$s1";
        }
    }
    public function check_link($string) {
        $s = $string;
        $s = str_replace("[[", "", $s);
        $s = str_replace("]]", "", $s);
        if(strpos($s, "|") !== false) {
            return 1;
        } else {
            return 0;
        }
    }
}
?>