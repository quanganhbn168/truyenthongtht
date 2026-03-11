<?php

$file = 'd:\laragon\www\refactorthtmedia\codeigniter\truyenthongt.sql';
$handle = fopen($file, "r");
if ($handle) {
    echo "Parsing $file...\n";
    $tables = [];
    $mediaFound = false;
    while (($line = fgets($handle)) !== false) {
        if (preg_match('/^INSERT INTO `([^`]+)`/', $line, $matches) || preg_match('/^CREATE TABLE `([^`]+)`/', $line, $matches)) {
            $tableName = $matches[1];
            $tables[$tableName] = true;
            if (strtolower($tableName) === 'media') {
                $mediaFound = true;
            }
        }
    }
    fclose($handle);
    echo "Tables found:\n";
    foreach (array_keys($tables) as $t) {
        echo "- $t\n";
    }
    if ($mediaFound) {
        echo "\n=> YES, 'media' table exists in the SQL file.\n";
    } else {
        echo "\n=> NO, 'media' table DOES NOT exist.\n";
    }
} else {
    echo "Error opening file.\n";
}
