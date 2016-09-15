<?php
require_once('dal/user.php');

if ($user_id = array_get($_GET, 'id')) {
    $access_token = uniqid();
    $user = DAL_User::fetch($user_id, DB::connect());
    Auth::login($access_token, $user, FALSE);
    Server::redirect('../index.php');
} else {
    print 'User ID required. <a href="window.history.back()">Go Back</a>';
}
