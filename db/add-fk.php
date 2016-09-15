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

while (!($table_name = trim(readline('Table Name: ')))) {
    print "Need a table name.";
}
while (!($column_name = trim(readline('Column Name: ')))) {
    print "Need a column name.";
}
while (!($foreign_table_name = trim(readline("Foreign Table Name: ")))) {
    print "Need a foreign table name.";
}
if (!($foreign_column = trim(readline("Foreign Column Name: [$column_name] ")))) {
    $foreign_column = $column_name;
}
$constraint_name = "fk_{$table_name}__{$column_name}";
$basename = "$constraint_name.sql";

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
            -- TODO: ON DELETE ???
            -- TODO: ON UPDATE ???
        ;
END IF;

END;
$$;
EOD;
file_put_contents("upgrade/z_$basename", $upgrade_sql);

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
file_put_contents("downgrade/_$basename", $downgrade_sql);

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
file_put_contents("verify/$basename", $verify_sql);

print "Done.";
