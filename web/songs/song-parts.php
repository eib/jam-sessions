<?php
require_once('dal/song.php');
require_once('dal/part.php');

//TODO: "quick edit" buttons like "Power-Trio", "4-part", etc.

$song_id = array_get($_GET, 'song_id');
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

$new = [];
$fields = ['instrument_id', 'description', 'tuning', 'key'];
$should_update = array_get($_POST, 'add') || array_get($_POST, 'save') || array_get($_POST, 'delete');

//Delete
if ($part_id = array_get($_POST, 'delete')) {
    DAL_Part::deletePart($part_id, $song_id, $db);
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
        if ($instrument_id = array_get($new, 'instrument_id')) {
            DAL_Part::addPart($new, $song_id, $db);
            $new = [];
        } else {
            $error_message = '* Instrument is required.';
        }
    }
}
$new = array_funnel_keys($new, $fields, '');

//Update
if ($should_update) {
    $rows = array_get($_POST, 'parts', []);
    $modified_rows = [];
    foreach ($rows as $row) {
        $is_modified = FALSE;
        foreach ($fields as $field) {
            $is_modified = $is_modified || array_get($row, $field) != array_get($row, "{$field}_old");
        }
        if ($is_modified) {
            $modified_rows[] = $row;
        }
    }
    if (count($modified_rows)) {
        DAL_Part::updateParts($modified_rows, $song_id, $db);
    }
}

$new = array_funnel_keys($new, $fields);
$parts = DAL_Part::listPartsForSong($song['song_id'], $db);
$instruments = DAL_Part::listInstruments($db);

Templates::display('songs/song-parts.html', compact('song', 'parts', 'new', 'instruments', 'error_message'));
