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
    print "Missing table name.";
}
$basename = "$table_name.data.sql";

print "Writing upgrade script. (TODO: add content)\n";
$upgrade_sql = <<<EOD
INSERT INTO $table_name (columns) -- TODO: columns
VALUES
(...), -- TODO: values
(...),
(...)
ON CONFLICT DO NOTHING;
EOD;
file_put_contents("upgrade/zz_$basename", $upgrade_sql);

print "Writing downgrade script. (TODO: add WHERE clause?)\n";
$downgrade_sql = <<<EOD
DELETE FROM $table_name
-- TODO: WHERE?
;
EOD;
file_put_contents("downgrade/__$basename", $downgrade_sql);

print "Writing verify script. (TODO: add WHERE clause?)\n";
$verify_sql = <<<EOD
SELECT 1/COUNT(*) FROM $table_name
-- TODO: WHERE?
;
EOD;
file_put_contents("verify/$basename", $verify_sql);

print "Done.";
