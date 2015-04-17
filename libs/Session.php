<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Session {

    public static function createSession() {
        @session_start();
    }

    public static function set($name, $value) {
        $now = date('Y-m-d H:i:s');
        $_SESSION[$name] = $value;
        if(!isset($_SESSION['created'])) {
            $_SESSION['created'] = $now;
            $_SESSION['updated'] = $now;
        }
    }

    public static function sessionUpdated(){
        $now = date('Y-m-d H:i:s');
        if(isset($_SESSION['updated'])) $_SESSION['updated'] = $now;
    }

    public static function get($name) {
        if (isset($_SESSION[$name]))
            return $_SESSION[$name];
    }

    public static function destroySession() {
        @session_destroy();
    }

    public static function unsetAll() {
        unset($_SESSION);
    }

    public static function unsetKey($key) {
        unset($_SESSION[$key]);
    }

}