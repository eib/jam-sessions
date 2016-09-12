<?php
require_once('facebook/graph-sdk/src/Facebook/autoload.php');
require_once('session.php');

class FB {
    public static function getApp() {
        Session::autoStart();
        return new Facebook\Facebook([
          'app_id' => self::getAppID(),
          'app_secret' => Server::get('FB_APP_SECRET'),
          'default_graph_version' => 'v2.7',
        ]);
    }

    public static function getAppID() {
        return Server::get('FB_APP_ID');
    }
}
