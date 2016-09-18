<?php

class Server {
    public static function getRootDir() {
        return dirname(__DIR__);
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
            header('Location: ' . $url); //TODO: prepend path up to document root? (Requires impact analysis)
        } else {
            print "<a href='$url'>Go</a>"; //This is an error
        }
        exit();
    }

    public static function getAbsolutePath($path) {
        $sep = DIRECTORY_SEPARATOR;
        $path = str_replace(array('/', '\\'), $sep, $path);
        $parts = array_filter(explode($sep, $path), 'strlen');
        $absolutes = array();
        foreach ($parts as $part) {
            if ('.' == $part) continue;
            if ('..' == $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }
        $is_root_dir = starts_with($path, $sep) || preg_match('/^[a-zA-Z]:\\\\/', $path);
        $parent = $is_root_dir ? '' : getcwd();
        return $parent . $sep . implode($sep, $absolutes);
    }

    /**
     * Calculate the relative path from $from to $to.
     * For example:
     *   Server::getRelativePath('C:\a\b\path', 'C:\a\x\y\file')
     * ... should be:
     *   '..\..\x\y\file'
     */
    public static function getRelativePath($from, $to, $sep = DIRECTORY_SEPARATOR) {
        $from_pieces = explode($sep, self::getAbsolutePath($from));
        $to_pieces = explode($sep, self::getAbsolutePath($to));
        print_r(compact('from_pieces', 'to_pieces'));
        while ($from_pieces && $to_pieces && ($from_pieces[0] == $to_pieces[0])) {
            array_shift($from_pieces);
            array_shift($to_pieces);
        }
        $leading = implode('', array_fill(0, count($from_pieces), "..$sep"));
        $trailing = implode($sep, $to_pieces);
        print_r(compact('leading', 'trailing'));
        return "$leading$trailing";
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
