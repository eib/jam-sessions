#!/usr/bin/env php
<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

chdir("$root_dir/db");
print "Running tests.\n";

$db = DB::connect();
list($versions, $patterns) = parse_args(array_slice($argv, 1));

$all_tests = 0;
$all_passed = 0;

foreach ($versions as $version) {
    list($num_tests, $num_passed) = run_tests($db, glob("./$version/*/*.test.sql"));
    $all_tests += $num_tests;
    $all_passed += $num_passed;
}
print "Testing done. ($all_passed/$all_tests Passed)\n\n";
