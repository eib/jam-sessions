<?php

function parse_args($args, $default_version = '*') {
    $versions = [];
    $patterns = [];
    foreach ($args as $arg) {
        if (starts_with($arg, '-') || string_contains($arg, '..')) { //skip directory hacks
            continue;
        }
        $arg = preg_replace('[^0-9.*-_]', '', $arg);
        if ($arg) {
            if (preg_match('/[0-9][0-9.*]+/', $arg)) {
                # echo "Version: $arg\n";
                $versions[] = $arg;
            } else {
                # echo "Pattern: $arg\n";
                $patterns[] = "*$arg*";
            }
        }
    }
    if (empty($versions)) {
        $versions[] = $default_version;
    }
    if (empty($patterns)) {
        $patterns[] = '*';
    }
    sort($versions);
    return array($versions, $patterns);
}

function run_scripts(PDO $db, $files, $log_sql = TRUE) {
    if ($files) {
        foreach ($files as $filename) {
            echo "Running \"$filename\"";
            $sql = file_get_contents($filename);
            if ($log_sql) {
                echo ":\n", $sql, "\n";
            }
            $result = $db->exec($sql);
            echo ($log_sql) ? "Result: $result\n\n" : " => $result\n";
        }
        if ($log_sql) {
            echo "\n";
        }
    }
}

function run_tests(PDO $db, $files) {
    $num_tests = 0;
    $num_passed = 0;
    foreach ($files as $filename) {
        $num_tests++;
        echo "Testing \"$filename\"...\t";
        $sql = file_get_contents($filename);
        try {
            $db->exec($sql);
            echo "Pass.\n";
            $num_passed++;
        } catch (Exception $e) {
            echo "FAIL!!!\n";
        }
    }
    return array($num_tests, $num_passed);
}

if (!function_exists('readline')) {
    function readline($prompt) {
        echo $prompt;
        return stream_get_line(STDIN, 1024, PHP_EOL);
    }
}

function get_current_version() {
    return trim(file_get_contents(dirname(__DIR__) . '/db/version.txt'));
}

function set_current_version($version) {
    file_put_contents(dirname(__DIR__) . '/db/version.txt', $version);
}

function get_schema_versions() {
    $root_dir = Server::getRootDir();
    chdir("$root_dir/db");
    return glob("*.*.*", GLOB_ONLYDIR);
}

function dump_schema($dest_file) {
    $url = Server::get('DATABASE_URL');
    if (!$url) {
        throw new Exception('No Database URL');
    }
    $pieces = parse_url($url);
    $db_host = $pieces['host'];
    $db_port = $pieces['port'];
    $db_name = ltrim($pieces['path'], '/');
    $db_user = $pieces['user'];

    $command = "pg_dump --schema-only --host=$db_host --port=$db_port --username=$db_user $db_name > \"$dest_file\"";
    echo "Dumping schema to \"$dest_file\"\n";
    system($command);
}
