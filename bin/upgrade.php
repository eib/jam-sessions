#!/usr/bin/env php
<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

chdir("$root_dir/db");
print "Running database upgrades.\n";

$db = DB::connect();
list($versions, $patterns) = parse_args(array_slice($argv, 1), get_current_version());
$verbose = FALSE;

#Upgrade
foreach ($versions as $version) {
    foreach ($patterns as $pattern) {
        run_scripts($db, glob("./$version/tables/$pattern.upgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/columns/$pattern.upgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/constraints/$pattern.upgrade.sql"), $verbose);
        run_scripts($db, glob("./$version/data/$pattern.upgrade.sql"), $verbose);
    }
}
echo "\n";

#Test
require_once(__DIR__ . '/verify.php');

#Dump Schema
if ($versions = ['*'] && $patterns == ['*']) {
    $version = get_current_version();
    $sep = DIRECTORY_SEPARATOR;
    $schema_file = "$root_dir{$sep}db{$sep}$version{$sep}schema.sql";
    dump_schema($schema_file);
}

echo "Done.\n";
