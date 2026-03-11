<?php

$dbs = ['thtmedia', 'truyenthongthtmedia', 'truyenthongtht'];
$mysqli = new mysqli('127.0.0.1', 'root', '', '', 3306);
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

foreach ($dbs as $db) {
    echo "===== DB: $db =====\n";
    if ($mysqli->select_db($db)) {
        $result = $mysqli->query("SHOW TABLES");
        if ($result) {
            while ($row = $result->fetch_row()) {
                echo $row[0] . "\n";
            }
        }
    } else {
        echo "DB not found or access denied.\n";
    }
}
