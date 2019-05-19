<?php

namespace app\services;


class Sessions
{
    public static function start()
    {
        session_start();
    }

    public static function get($key)
    {
        self::start();
        return $_SESSION[$key];
    }

    public static function set($key, $value)
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function getSessionInfo()
    {
        return $_SESSION;
    }
}