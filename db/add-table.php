#!/usr/bin/env php
<?php
$db_dir = dirname(__FILE__);
chdir($db_dir);

if (!function_exists('readline')) {
    function readline($prompt) {
        echo $prompt;
        return stream_get_line(STDIN, 1024, PHP_EOL);
    }
}

$table_name = trim(readline('Table Name: '));
if (!$table_name) {
    print "No table name.";
    exit();
}
$basename = "$table_name.sql";

print "Writing upgrade script (TODO: add columns).\n";
$upgrade_sql = "CREATE TABLE IF NOT EXISTS $table_name (\n-- TODO: implement\n);\n";
file_put_contents("upgrade/$basename", $upgrade_sql);

print "Writing downgrade script.\n";
$downgrade_sql = "DROP TABLE IF EXISTS $table_name;\n";
file_put_contents("downgrade/$basename", $downgrade_sql);

print "Writing verify script.\n";
$verify_sql = "SELECT 1/COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$table_name';\n";
file_put_contents("verify/$basename", $verify_sql);

print "Done.";
