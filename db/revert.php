#!/usr/bin/env php
<?php
print "Reverting the database.\n";
$root_dir = dirname(dirname(__FILE__));
require_once("$root_dir/lib/_global_auto_prepend.php");

print "Connecting to database.\n";
$db = DB::connect();

chdir("$root_dir/db");
print "Running downgrades.\n";
foreach (glob('./downgrade/*.sql') as $filename) {
    print "Running \"$filename\":\n";
    $sql = file_get_contents($filename);
    print "$sql\n";
    $result = $db->exec($sql);
    print "Result: $result\n\n";
}
print "Done.\n";
