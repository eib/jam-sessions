#!/usr/bin/env php
<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

chdir("$root_dir/db");
$version = get_current_version();

while (!($table_name = trim(readline('Table Name: ')))) {
    print "Need a table name.\n";
}
while (!($column_name = trim(readline('Column Name: ')))) {
    print "Need a column name.\n";
}
while (!($foreign_table_name = trim(readline("Foreign Table Name: ")))) {
    print "Need a foreign table name.\n";
}
if (!($foreign_column = trim(readline("Foreign Column Name: [$column_name] ")))) {
    $foreign_column = $column_name;
}
$constraint_name = "fk_{$table_name}__{$column_name}";
$root_name = "$version/constraints/$constraint_name";

print "Writing upgrade script. (TODO: on delete/on update clauses)\n";
$upgrade_sql = <<<EOD
DO
$$
BEGIN

IF NOT EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = 'fk_{$table_name}__{$column_name}') THEN
    ALTER TABLE $table_name
        ADD CONSTRAINT $constraint_name
        FOREIGN KEY ($column_name)
        REFERENCES $foreign_table_name ($foreign_column)
            -- TODO: ON DELETE CASCADE
            -- TODO: ON UPDATE CASCADE;
        ;
END IF;

END;
$$;
EOD;
file_put_contents("$root_name.upgrade.sql", $upgrade_sql);

print "Writing downgrade script.\n";
$downgrade_sql = <<<EOD
DO
$$
BEGIN

IF EXISTS (SELECT 1 FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
               WHERE CONSTRAINT_NAME = '$constraint_name') THEN
    ALTER TABLE $table_name DROP CONSTRAINT $constraint_name;
END IF;

END;
$$;
EOD;
file_put_contents("$root_name.downgrade.sql", $downgrade_sql);

print "Writing verify script.\n";
$verify_sql = <<<EOD
SELECT
    1/COUNT(*)
FROM
    INFORMATION_SCHEMA.TABLE_CONSTRAINTS
WHERE
   TABLE_NAME = '$table_name'
   AND CONSTRAINT_NAME = '$constraint_name';

EOD;
file_put_contents("$root_name.test.sql", $verify_sql);

print "Done.";
