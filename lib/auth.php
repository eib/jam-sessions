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

    public static function login($accessToken, $user) {
        Session::autoStart();
        $_SESSION['access_token'] = (string)$accessToken;
        $_SESSION['current_user'] = $user;
    }

    public static function getUser() {
        Session::autoStart();
        return array_get($_SESSION, 'current_user');
    }
}