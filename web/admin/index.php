<?php
Auth::requireAdmin();

$db = DB::connect();
$users = $db->query('SELECT * FROM users')->fetchAll();
$current_user = Auth::getUser();

Templates::display('admin/index.html', compact('users', 'current_user'));
