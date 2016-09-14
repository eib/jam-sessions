<?php
require_once('server.php');

class DB {
    public static function connect() {
        $url = Server::get('DATABASE_URL');
        if (!$url) {
            throw new Exception('No Database URL');
        }
        $pieces = parse_url($url);
        $db_host = $pieces['host'];
        $db_port = $pieces['port'];
        $db_name = ltrim($pieces['path'], '/');
        $db_user = $pieces['user'];
        $db_password = $pieces['pass'];

        $dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name";
        $db = new PDO($dsn, $db_user, $db_password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    }
}
