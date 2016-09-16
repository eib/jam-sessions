#!/usr/bin/env php
<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

chdir("$root_dir/db");
$version = get_current_version();

while (!($table_name = trim(readline('Table Name: ')))) {
    print "Missing table name.";
}
$root_name = "$version/data/$table_name";

print "Writing upgrade script. (TODO: add content)\n";
$upgrade_sql = <<<EOD
INSERT INTO $table_name (columns) -- TODO: columns
VALUES
(...), -- TODO: values
(...),
(...)
ON CONFLICT DO NOTHING;
EOD;
file_put_contents("$root_name.upgrade.sql", $upgrade_sql);

print "Writing downgrade script. (TODO: add WHERE clause?)\n";
$downgrade_sql = <<<EOD
-- TODO: IF EXISTS(...a table...)
DELETE FROM $table_name
-- TODO: WHERE?
;
EOD;
file_put_contents("$root_name.downgrade.sql", $downgrade_sql);

print "Writing verify script. (TODO: add WHERE clause?)\n";
$verify_sql = <<<EOD
SELECT 1/COUNT(*) FROM $table_name
-- TODO: WHERE?
;
EOD;
file_put_contents("$root_name.test.sql", $verify_sql);

print "Done.";
