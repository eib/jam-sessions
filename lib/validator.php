<?php

class Validator {
    public static function requireTruthy($expression, $error_message) {
        if (!$expression) {
            throw new Exception($error_message);
        }
    }

    public static function requireNonEmpty($arrayOrString, $error_message) {
        if (is_array($arrayOrString)) {
            self::requireTruthy(count($arrayOrString) > 0, $error_message);
        } else {
            self::requireTruthy(strlen($arrayOrString) > 0, $error_message);
        }
    }

    public static function requirePositiveInt($field, $error_message) {
        self::requireTruthy($field > 0, $error_message);
    }
}