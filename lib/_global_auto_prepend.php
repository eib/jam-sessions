<?php
$root_dir = dirname(dirname(__FILE__));
$include_path = join(PATH_SEPARATOR, ['.', "$root_dir/lib", "$root_dir/vendor"]);
set_include_path($include_path);


require_once('common.php');

#When these files have dependencies among one another, they should be `require_once` (because order sort-of matters).
require_once('session.php');
require_once('server.php');
require_once('templates.php');
require_once('db.php');
require_once('auth.php');
