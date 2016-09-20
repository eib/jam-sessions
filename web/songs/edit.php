<?php
require_once('dal/song.php');

$should_update = array_get($_POST, 'delete') || array_get($_POST, 'add') || array_get($_POST, 'save');
$fields = ['song_title', 'artist_name', 'genre', 'key', 'year', 'creator_id', 'created_dt', 'modified_dt'];
$user_id = Auth::getUserID();
$db = DB::connect();

//Delete
if ($song_id = array_get($_POST, 'delete')) {
    DAL_Song::deleteSong($song_id, $db);
}
//Add
$error_message = NULL;
$new = array_get($_POST, 'new', []);
if ($should_update) {
    $should_add = FALSE;
    foreach ($new as $value) {
        $should_add = $should_add || $value;
    }
    if ($should_add) {
        if (array_get($new, 'song_title')) {
            DAL_Song::addSong($new, $db);
            $new = [];
        } else {
            $error_message = '* Song Title is required.';
        }
    }
}
$new = array_funnel_keys($new, $fields, '');
//Update
if ($should_update) {
    $rows = array_get($_POST, 'songs', []);
    $modified_rows = [];
    foreach ($rows as $row) {
        $is_modified = FALSE;
        foreach ($fields as $field) {
            $is_modified = $is_modified || (array_get($row, $field) != array_get($row, "{$field}_old"));
        }
        if ($is_modified) {
            $modified_rows[] = $row;
        }
    }
    if (count($modified_rows)) {
        DAL_Song::updateSongs($modified_rows, $db);
    }
}

$songs = DAL_Song::listAll($db);

Templates::display('songs/edit.html', compact('songs', 'new', 'error_message'));
