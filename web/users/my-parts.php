<?php
require_once('dal/song.php');
require_once('dal/part.php');
require_once('dal/user_part.php');

$user_id = Auth::getUserID();
$song_id = (int)array_get($_GET, 'song_id');
if (!$song_id) {
    echo "No Song ID. <a href='javascript:history.back()'>Back</a>";
    exit();
}
$db = DB::connect();
$song = DAL_Song::fetch($song_id, $db);
if (!$song) {
    echo "Invalid Song ID. <a href='javascript:history.back()'>Back</a>";
    exit();
}

//PK fields: ['user_id', 'part_id']
$new = [];
$fields = ['skill_level', 'song_preference'];
$should_update = array_get($_POST, 'save');

$error_message = NULL;

if ($should_update) {
    $rows = array_get($_POST, 'user_parts', []);
    $new = [];
    $modified = [];
    $deleted = [];

    foreach ($rows as $row) {
        //Add
        if (array_get($row, 'part_id') && !array_get($row, 'part_id_old')) {
            $new[] = $row;
        }
        //Delete
        else if (!array_get($row, 'part_id') && array_get($row, 'part_id_old')) {
            $deleted[] = $row;
        }
        //Update
        else if (array_get($row, 'part_id')) {
            $is_modified = FALSE;
            foreach ($fields as $field) {
                $is_modified = $is_modified || array_get($row, $field) != array_get($row, "{$field}_old");
            }
            if ($is_modified) {
                $modified[] = $row;
            }
        }
    }

    //pre_print_r(compact('new', 'modified', 'deleted'));
    if (count($new) + count($modified) + count($deleted) > 0) {
        DAL_UserPart::batchUpdate($new, $modified, $deleted, $song_id, $user_id, $db);
    }
}

$parts = DAL_Part::listPartsForSong($song_id, $db);
$user_parts_by_part = array_reduce(DAL_UserPart::listUserPartsForSong($song_id, $user_id, $db),
    function ($temp, $user_part) {
        $part_id = $user_part['part_id'];
        $temp[$part_id] = $user_part;
        return $temp;
    }, []);
$skill_levels = [
    '0' => '-- Choose',
    '1' => 'Beginner',
    '5' => 'Intermediate',
    '10' => 'Expert',
];
$preferences = [
    '0' => '-- Choose',
    '1' => 'Meh',
    '5' => 'Like it',
    '10' => 'Love it!',
];

Templates::display('users/my-parts.html', compact('song', 'parts', 'user_parts_by_part', 'skill_levels', 'preferences', 'error_message'));
