<?php

class Auth
{
    public static function login(array $user): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['username']  = $user['username'];
        $_SESSION['role']      = $user['role'];
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }


}