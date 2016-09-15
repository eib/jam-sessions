<?php
require_once('session.php');
require_once('server.php');

class Auth {
    public static function ensureLoggedIn() {
        Session::autoStart();
        if (!self::isLoggedIn()) {
            Server::redirect('login.php?r=' . urlencode($_SERVER['REQUEST_URI']));
        }
    }

    public static function isLoggedIn() {
        Session::autoStart();
        return array_get($_SESSION, 'access_token');
    }

    public static function login($access_token, $user, $is_first_login) {
        Session::autoStart();
        $_SESSION['access_token'] = (string)$access_token;
        $_SESSION['is_first_login'] = $is_first_login; #TODO: [Feature] keep an actual login counter (per user)
        self::setUser($user);
    }

    public static function setUser($user) {
        Session::autoStart();
        $_SESSION['current_user'] = $user;
    }

    public static function logout() {
        Session::autoStart();
        unset($_SESSION['access_token']);
        unset($_SESSION['current_user']);
        #TODO: [Feature] Force OAuth users to close their browser via additional "I want to stay logged out" $_SESSION stuffs
    }

    public static function getUser() {
        Session::autoStart();
        return array_get($_SESSION, 'current_user');
    }
}