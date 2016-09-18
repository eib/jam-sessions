<?php
$root_dir = dirname(__DIR__);
require_once("$root_dir/lib/_global_auto_prepend.php");
require_once('db_helpers.php');

$dest_file = $root_dir . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'schema.sql';
dump_schema($dest_file);
