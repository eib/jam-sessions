<?php
require_once('dal/equipment.php');

$user_id = Auth::getUserID();
$db = DB::connect();
$equipment = DAL_Equipment::listByUserID($user_id, $db);

Templates::display('equipment/index.html', compact('equipment'));
