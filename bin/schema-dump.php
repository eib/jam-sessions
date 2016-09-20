<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

$sep = DIRECTORY_SEPARATOR;
$current_version = get_current_version();

#Because we can't tell the upgrade status,
#we don't know which version to put this in,
#so we'll leave it in the top-level DB folder.
$dest_file = "$root_dir{$sep}db{$sep}schema-tmp.sql";
dump_schema($dest_file);
