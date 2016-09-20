<?php
require_once('dal/user.php');

$user = Auth::getUser();

if (array_get($_POST, 'submit')) {
    $user['user_name'] = array_get($_POST, 'user_name');
    $user['full_name'] = array_get($_POST, 'full_name');
    $user['first_name'] = array_get($_POST, 'first_name');
    $user['middle_name'] = array_get($_POST, 'middle_name');
    $user['last_name'] = array_get($_POST, 'last_name');
}

if (array_get($_POST, 'submit')) {
    //TODO: Validate $user (and display errors)
    DAL_User::update($user);
    Auth::setUser($user);
    Server::redirect('../index.php');
} else {
    Templates::display('users/my-info.html', ['user' => $user]);
}
