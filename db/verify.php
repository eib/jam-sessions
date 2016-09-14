#!/usr/bin/env php
<?php
$root_dir = dirname(dirname(__FILE__));
require_once("$root_dir/lib/_global_auto_prepend.php");

print "Connecting to database.\n";
$db = DB::connect();

chdir("$root_dir/db");

print "Running tests.\n";
$num_tests = 0;
$num_passed = 0;
foreach (glob('./verify/*.sql') as $filename) {
    $num_tests++;
    print "Testing \"$filename\"...\t";
    $sql = file_get_contents($filename);
    try {
        $db->exec($sql);
        print "Pass.\n";
        $num_passed++;
    } catch (Exception $e) {
        print "FAIL!!!\n";
    }
}
print "Done. ($num_passed/$num_tests Passed)\n";
