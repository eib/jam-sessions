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
while (!($old_column_name = trim(readline('Old Column Name: ')))) {
    print 'Missing column name.';
}
while (!($new_column_name = trim(readline('New Column Name: ')))) {
    print 'Missing column name.';
}
$root_name = "./$version/columns/{$table_name}__{$old_column_name}__{$new_column_name}";

print "Writing upgrade script.\n";
$upgrade_sql = <<<EOD
DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = '$table_name' and COLUMN_NAME = '$old_column_name') THEN
    ALTER TABLE $table_name
        RENAME COLUMN $old_column_name TO $new_column_name;
END IF;

END;
$$
EOD;
file_put_contents("$root_name.upgrade.sql", $upgrade_sql);

print "Writing downgrade script.\n";
$downgrade_sql = <<<EOD
DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS
               WHERE TABLE_NAME = '$table_name' and COLUMN_NAME = '$new_column_name') THEN
    ALTER TABLE $table_name
        RENAME COLUMN $new_column_name TO $old_column_name;
END IF;

END;
$$
EOD;
file_put_contents("$root_name.downgrade.sql", $downgrade_sql);

print "Writing verify script.\n";
$verify_sql = <<<EOD
SELECT 1/COUNT(*)
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_NAME = '$table_name' and COLUMN_NAME = '$new_column_name';
EOD;
file_put_contents("$root_name.test.sql", $verify_sql);

print "Done.";
