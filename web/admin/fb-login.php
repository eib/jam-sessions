<?php
require_once('dal/user.php');

$id = array_get($_POST, 'id', '10101010101');
$name = array_get($_POST, 'name', 'Rock-Stud');
$first_name = array_get($_POST, 'first_name', 'Rock');
$middle_name = array_get($_POST, 'middle_name', 'D');
$last_name = array_get($_POST, 'last_name', 'Stud');
$email = array_get($_POST, 'email', 'Rock.Stud@example.org');

$user = compact('id', 'name', 'first_name', 'middle_name', 'last_name', 'email');
if (array_get($_POST, 'submit')) {
    //TODO: Validate $user
    $access_token = uniqid();
    list($user, $is_first_login) = DAL_User::lookupOrCreate($user);
    Auth::login($access_token, $user, $is_first_login);

    Server::redirect('index.php');
} else {
    Templates::display('admin/fb-login.html', ['user' => $user]);
}
