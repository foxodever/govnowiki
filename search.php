<?php
require_once "connection.php";
$q = $_GET["q"];
if($q == "") {
    echo '
    <input id="q" placeholder="Введите запрос" /><br />
    <button onclick="search()">Найти</button>
    <script>
        function search() {
            var q = document.getElementById("q");
            if(q.value === "") {
                alert("Введите запрос");
            } else {
                location.href="/search.php?q=" + q.value;
            }
        }
    </script>
    ';
    exit();
}
$sql = "SELECT * FROM pages WHERE title LIKE '$q'"; 
$result = mysqli_query($link, $sql);
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $title = $row["title"]; 
        $id = $row["num"];
    } 
}
if($title != "") {
    echo "Заголовки - <a href='/view.php?id=$id'>$title</a><br />";
} else {
    echo "Заголовки - не найдено<br />";
}
echo "Содержимое:";
$sql = "SELECT *
FROM `pages`
WHERE INSTR(`content`, '$q') > 0"; 
$result = mysqli_query($link, $sql);
if ($result->num_rows > 0) { 
    while($row = $result->fetch_assoc()) { 
        $content = $row["content"]; 
        $id = $row["num"];
        if($content != "") {
            echo "<br /><a href='/view.php?id=$id'><div style='border:0.5px solid black;display:inline-block'>$content</div></a>";
        } else {
            echo "Не найдено";
        }
    } 
}
if($content == "") {
    echo " Не найдено";
    echo "<br />Но вы можете <a href='/create.php'>создать статью</a>";
}
?>