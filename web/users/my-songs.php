<?php
require_once('dal/song.php');
$db = DB::connect();
$user_id = Auth::getUserID();
$songs = DAL_Song::listAllWithParts($db);

Templates::display('users/my-songs.html', compact('songs'));
