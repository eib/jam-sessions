<?php
# Commonly-used functions/helpers.
# Nobody should have to `require_once` this file.
# Should not have dependencies on other files.

function mkdirp($dirname, $mode = 0777) {
    if (!is_dir($dirname)) {
        mkdir($dirname, $mode, true);
    }
}

function array_get($array, $key, $default = NULL) {
    if (array_key_exists($key, $array)) {
        return $array[$key];
    }
    return $default;
}

function pre_print_r($varargs) {
    echo '<pre>';
    print_r($varargs);
    echo '</pre>';
}

/**
 * Returns a new array with all and only the keys in $keys.
 * Returned values are from corresponding values in $array (if the key exists).
 * Otherwise values are $default.
 */
function array_funnel_keys($array, $keys, $default = NULL) {
    $defaults = array_fill_keys($keys, $default);
    return array_merge($defaults, array_intersect_key($array, $defaults));
}
