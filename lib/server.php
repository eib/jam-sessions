<?php

class Server {
    public static function getRootDir() {
        return dirname(dirname(__FILE__));
    }

    public static function get($key) {
        return array_get($_ENV, $key, array_get($_SERVER, $key));
    }

    public static function sendStatus($status_code, $headers = []) {
        if (!headers_sent()) {
            $status_description = self::$statusDescriptions[$status_code];
            header("HTTP/1.0 $status_code, $status_description");
            if (headers) {
                foreach ($headers as $key => $value) {
                    echo "$key: $value\n";
                }
            }
        }
    }

    public static function redirect($url) {
        if (!headers_sent()) {
            header('Location: ' . $url); //TODO: prepend path up to document root?
        } //TODO: else, throw an error or print a link???
        exit();
    }

    public static $statusDescriptions = [
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        415 => 'Unsupported Media Type',
        426 => 'Upgrade Required',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable'
    ];
}
