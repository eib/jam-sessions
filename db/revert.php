#!/usr/bin/env php
<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

chdir("$root_dir/db");
print "Running database downgrades.\n";

$db = DB::connect();
list($versions, $patterns) = parse_args(array_slice($argv, 1), get_current_version());

$verbose = FALSE;

foreach ($versions as $version) {
    foreach ($patterns as $pattern) {
        run_scripts($db, glob("./$version/constraints/$pattern.downgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/data/$pattern.downgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/columns/$pattern.downgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/tables/$pattern.downgrade.sql"), $verbose);
    }
}

print "Done.\n";
