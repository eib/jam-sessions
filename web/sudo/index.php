<?php

$db = DB::connect();
$users = $db->query('SELECT * FROM users')->fetchAll();

Templates::display('sudo/index.html', ['users' => $users, 'current_user' => Auth::getUser()]);
