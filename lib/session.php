<?php

class Session {
    public static function autoStart() {
        if (!session_id()) {
            session_start();
        }
    }
}
