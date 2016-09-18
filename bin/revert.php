#!/usr/bin/env php
<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

chdir("$root_dir/db");
print "Running database downgrades.\n";

$db = DB::connect();
$current_version = get_current_version();
list($versions, $patterns) = parse_args(array_slice($argv, 1), $current_version);

$verbose = FALSE;

#Revert
foreach (array_reverse($versions) as $version) {
    foreach ($patterns as $pattern) {
        run_scripts($db, glob("./$version/constraints/$pattern.downgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/data/$pattern.downgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/columns/$pattern.downgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/tables/$pattern.downgrade.sql"), $verbose);
    }
}

if ($patterns == ['*'] && $versions == [$current_version]) { //Was a full rollback of the current version
    $previous_versions = get_schema_versions();
    if (array_pop($previous_versions) == $current_version) { //TODO: all versions up until current_version
        $all_tests = 0;
        $all_passed = 0;
        foreach ($previous_versions as $version) {
            list($num_tests, $num_passed) = run_tests($db, glob("./$version/*/*.test.sql"));
            $all_tests += $num_tests;
            $all_passed += $num_passed;
        }
        print "Testing done. ($all_passed/$all_tests Passed)\n\n";
    }
    if ($previous_version = array_pop($previous_versions)) { //There is a previous version to fall back to
        $sep = DIRECTORY_SEPARATOR;
        $schema_file = "$root_dir{$sep}db{$sep}$previous_version{$sep}schema.sql";
        dump_schema($schema_file);
    }
}

print "Done.\n";
