<?php
require_once('fb.php');

$fb = FB::getApp();
$helper = $fb->getRedirectLoginHelper();

$callback_url = 'https://jam-sessions.herokuapp.com/fb-callback.php';
if ($redirect_url = array_get($_GET, 'r')) {
    $callback_url = $callback_url . '?r=' . urlencode($redirect_url);
}
$permissions = ['email', 'user_friends']; // Optional permissions

$login_url = $helper->getLoginUrl($callback_url, $permissions);
Server::redirect($login_url);
