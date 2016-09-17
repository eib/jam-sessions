<?php
require_once('dal/equipment.php');

$should_update = array_get($_POST, 'delete') || array_get($_POST, 'add') || array_get($_POST, 'save');
$fields = ['equipment_id', 'description', 'manufacturer', 'model', 'product_year', 'color'];
$user_id = Auth::getUserID();
$db = DB::connect();

//Delete
if ($user_equipment_id = array_get($_POST, 'delete')) {
    DAL_Equipment::deleteUserEquipment($user_equipment_id, $user_id, $db); //TODO: if FALSE, then somebody's hacking on user_equipment_id?
}
//Add
$new = array_get($_POST, 'new', []);
if ($should_update) {
    $should_add = FALSE;
    foreach ($new as $value) {
        $should_add = $should_add || $value;
    }
    if ($should_add) {
        $new['equipment_id'] = array_get($new, 'equipment_id') ? $new['equipment_id'] : DEFAULT_EQUIPMENT_ID;
        DAL_Equipment::addUserEquipment($new, $user_id, $db);
        $new = [];
    }
}
$new = array_funnel_keys($new, $fields, '');
//Update
if ($should_update) {
    $rows = array_get($_POST, 'equipment', []);
    $modified_rows = [];
    foreach ($rows as $row) {
        $is_modified = FALSE;
        foreach ($fields as $field) {
            $is_modified = $is_modified || array_get($row, $field) != array_get($row, "{$field}_orig");
        }
        if ($is_modified) {
            $modified_rows[] = $row;
        }
    }
    if (count($modified_rows)) {
        DAL_Equipment::updateEquipment($modified_rows, $user_id, $db);
    }
}

$equipment = DAL_Equipment::listByUserID($user_id, $db);
$equipment_types = DAL_Equipment::fetchEquipmentTypes($db);

Templates::display('equipment/edit.html', compact('equipment', 'equipment_types', 'new'));
