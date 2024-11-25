<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
body{
    margin: 0;
    background-color: bisque
}
*{
    font-family: "Open Sans", Arial
}
td{
    border: solid 1px darkslategray;
    cursor: pointer;
}
tr td:first-child {
    width: 70%
}
header{
    background: darkslategrey;
    color: white;
    font-size: xx-large;
    text-align: center
}
a{
    display: inline;
    color: darkslategray;
    font-weight: bold;
    cursor:pointer;
    margin:0 1%
}
:is(a,td):active{
    text-shadow: 0 0 1px
}
table{
    border-collapse: collapse;
    width: 98%;
    margin: 1%;
    border-bottom: solid 3px darkslategray
}
.h{
    color: darkslategray;
    font-size: large;
}
input[type=text]{
    outline: none;
    border: solid 1px darkslategray;
    width: 100%;
}
input[type=button]{
    outline: none;
    border: solid 1px darkslategray;
    width: 100%;
    color: white;
    font-weight: bold;
    background-color: darkslategray;
}
    </style>
    <?php
    if (isset($_GET["add"])) {
        $text = $_GET["add"];
        mkdir($text);
    }
    if (isset($_GET["old"])) {
        $old = $_GET["old"];
        $new = $_GET["new"];
        rename($old, $new);
    }
    if (isset($_GET["del"])) {
        $text = $_GET["del"];
        del($text);
    }
    function del($path) {
        if (is_file($path)) {
            unlink($path);
        } elseif (is_dir($path)) {
            $files = array_diff(scandir($path), ['.', '..']);
            foreach ($files as $file) {
                del($path . DIRECTORY_SEPARATOR . $file);
            }
            rmdir($path);
        }
    }
    ?>
</head>
<body>
    <header>
        ampManager
    </header>
    <table>
        <tr>
            <th class="h">files and folders</th>
            <th><input type="text" id="text"></th>
            <th><input type="button" onclick="add()" value="add folder"></th>
        </tr>
        <?php
        $items = scandir(".");
        sort($items);
        foreach ($items as $item) {
            if ($item != "." && $item != ".." && $item != "index.php") {
                echo "<tr><td><a href='$item' target='_blank\'>$item</a></td><td onclick='rename(\"$item\")'>rename</td><td onclick='del(\"$item\")'>delete</td></tr>";
            }
        }
        ?>
    </table>
    <a href="https://d0lmany.netlify.app/" target="_blank">dev: d0lmany</a><a href="https://phpmyadmin/">phpmyadmin</a target="_blank">
    <script>
        const that = window.location.href + "?";
        function add() {
            let name = document.getElementById("text").value
            name = name.replaceAll(" ","_")
            if (name) {
                fetch(that + "add=" + name)
                    .then((r) => {
                        if (r.ok)
                            location.reload(true);
                        else alert("adding error");
                    })
            }

        }
        function rename(a) {
            let b = prompt("enter a new name")
            b = b.replaceAll(" ","_")
            fetch(that + "old=" + a + "&new=" + b)
                .then((r) => {
                    if (r.ok)
                        location.reload(true);
                    else alert("rename error");
                })
        }

        function del(what) {
            fetch(that + "del=" + what)
                .then((r) => {
                    if (r.ok)
                        location.reload(true);
                    else alert("delete error");
                })
        }
    </script>
</body>
</html>