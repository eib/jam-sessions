<?php
require_once('dal/song.php');
$db = DB::connect();
$user_id = Auth::getUserID();
$songs = DAL_Song::listAll($db);

Templates::display('songs/index.html', compact('songs'));
