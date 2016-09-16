#!/usr/bin/env php
<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

$version = get_current_version();
$pieces = explode('.', $version);
$pieces[count($pieces) - 1]++;
$bump_version = implode('.', $pieces);

echo "Current Version: $version\n";
do {
    if (!($next_version = trim(readline("Next Version #: [$bump_version] ")))) {
        $next_version = $bump_version;
    }
} while (!version_compare($next_version, $version, 'gt'));

echo "Scaffolding version $next_version";
chdir("$root_dir/db");

mkdirp("$next_version/constraints");
mkdirp("$next_version/data");
mkdirp("$next_version/tables");
mkdirp("$next_version/columns");
set_current_version($next_version);
