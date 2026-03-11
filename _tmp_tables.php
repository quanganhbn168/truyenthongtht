<?php

// List all tables and their row counts
$tables = DB::select('SHOW TABLES');
foreach ($tables as $t) {
    $name = array_values((array)$t)[0];
    $count = DB::table($name)->count();
    echo "{$name}: {$count} rows\n";
}
