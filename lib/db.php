<?php

class DB {
    public static function connect() {
        $pieces = parse_url($_ENV['DATABASE_URL']);
        $db_host = $pieces['host'];
        $db_port = $pieces['port'];
        $db_name = ltrim($pieces['path'], '/');
        $db_user = $pieces['user'];
        $db_password = $pieces['pass'];

        $db = new PDO("pgsql:host=$db_host;port=$db_port;dbname=$db_name;user=$db_user;password=$db_password");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $db;
    }
}
