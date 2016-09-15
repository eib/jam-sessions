<?php
require_once('dal/equipment.php');

$user_id = Auth::getUser()['user_id'];
$db = DB::connect();
$equipment = DAL_Equipment::listByUserID($user_id, $db);

pre_print_r($equipment);

Templates::display('equipment/index.html', compact('equipment'));
