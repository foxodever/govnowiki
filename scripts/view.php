<style>
    .ib {
        float: right;
        max-width: 40%;
    }
    .imgl {
        float: left;
        max-width: 20%;
        border: 1px solid black;
    }
</style>
<?php
$st = $_POST["nesw"];
if($st == "") {
    exit("1");
}
include "wiki.php";
$wiki = new wiki;
$st = strip_tags($st, "<sub><sup><del><table><tr><th><td><code>");
$st = nl2br($st);
$st = $wiki->replace($st, "**", "b");
$st = $wiki->replace($st, "__", "u");
$st = $wiki->replace($st, "====", "h3");
$st = $wiki->replace($st, "===", "h4");
$st = $wiki->replace($st, "==", "h5");
$st = $wiki->replace($st, "''", "tt");
$a = substr_count($st, "[[");
$a = $a + 1;
for ($i = 0; $i != $a; $i++) {
    $link = $wiki->betw($st, '[[', ']]');
    $check = $wiki->check_link("$link");
    if($check == 0) {
        if(filter_var($string, FILTER_VALIDATE_URL)) {
            $st = preg_replace("/\[\[/", "<a class='a dsadasdg sdgsdf' href='$link'>", $st, 1);
        } else {
            $st = preg_replace("/\[\[/", "<a class='a dsadasdg sdgsdf' href='/view?id=$link'>", $st, 1);
        }
        $st = preg_replace("/\]\]/", "</a>", $st, 1);
    } else {
        $asd = $wiki->betw($st, '[[', ']]');
        $lk = $wiki->get_link("$link");
        $txt = $wiki->get_text("$link");
        if(filter_var($lk, FILTER_VALIDATE_URL)) {
            $st = preg_replace('|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i', "", $st, 1);
            $st = preg_replace("/\[\[/", "<a class='a dsadasdg sdgsdf' href='https://$lk'>$txt", $st, 1);
        } else {
            $st = preg_replace("/$lk\|$txt/", "", $st, 1);
            $st = preg_replace("/\[\[/", "<a class='a dsadasdg sdgsdf' href='/view?id=$lk'>$txt", $st, 1);
        }
        $st = preg_replace("/\]\]/", "</a>", $st, 1);
    }
}
$a = substr_count($st, "//");
$a = $a + 1;
$st = str_replace("http://", "time11111", $st);
$st = str_replace("https://", "time22222", $st);
for ($i = 0; $i != $a; $i++) {
    $st = $wiki->replace($st, "//", "i");
    
}
$st = str_replace("time11111time11111", "http://", $st);
$st = str_replace("time22222time22222", "https://", $st);
$st = str_replace("[ibimg]", "<img style='max-width:50%' src='", $st);
$st = str_replace("[/ibimg]", "' />", $st);
$st = str_replace("time11111", "http://", $st);
$st = str_replace("time22222", "https://", $st);

$img1 = $wiki->betw($st, '[imgl]', '[/imgl]');
$img = $wiki->get_link("$img1");
$descr = $wiki->get_text("$img1");
$st = str_replace("$descr", "", $st);
$st = str_replace("[/imgl]", "", $st);
$st = str_replace("[imgl]", "<div class='imgl'><p align='center'><img style='width:99%' src='$img'></p><p>$descr</p></div>", $st);
$st = str_replace("$img|", "", $st);


$st = str_replace("><br />", ">", $st);
$st = str_replace("[ib]", "<div class='ib'>", $st);
$st = str_replace("[/ib]", "</div>", $st);
echo $st;
?>