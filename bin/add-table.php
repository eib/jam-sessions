#!/usr/bin/env php
<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

chdir("$root_dir/db");
$version = get_current_version();

while (!($table_name = trim(readline('Table Name: ')))) {
    print 'Missing table name.';
}
$root_name = "$version/tables/$table_name";

print "Writing upgrade script (TODO: add columns).\n";
$upgrade_sql = <<<EOD
CREATE TABLE IF NOT EXISTS $table_name (
    {$table_name}_id bigserial PRIMARY KEY,
    -- TODO: implement
    created_dt timestamp with time zone DEFAULT now(),
    modified_dt timestamp with time zone DEFAULT now()
);
EOD;
file_put_contents("$root_name.upgrade.sql", $upgrade_sql);

print "Writing downgrade script.\n";
$downgrade_sql = "DROP TABLE IF EXISTS $table_name;\n";
file_put_contents("$root_name.downgrade.sql", $downgrade_sql);

print "Writing verify script.\n";
$verify_sql = "SELECT 1/COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$table_name';\n";
file_put_contents("$root_name.test.sql", $verify_sql);

print "Done.";
