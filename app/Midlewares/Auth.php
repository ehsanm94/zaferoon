<?php
require_once 'app/Models/User.php';
class Auth
{
    public static function loginWithTokenAndRedirect($token, $redirect_url_in_success = null, $remember_me = true)
    {
        if (isset($_SESSION[SESSION_KEY_LOGIN]) && $_SESSION[SESSION_KEY_LOGIN]) {
            header('location:' . URL . $redirect_url_in_success);
        }
        elseif (!isset($_SESSION[SESSION_KEY_LOGIN]) || !$_SESSION[SESSION_KEY_LOGIN]) {
            if (isset($token)) {
                $user = User::getUserByToken($token);
                if ($user) {
                    self::initSession($user);
                    if($remember_me) {
                        self::RememberMe($user->getId());
                    }
                    header('location:' . URL . $redirect_url_in_success);
                }
                else
                    header('location:' . URL . 'notification/invalidToken');
            }
        }
        else
            header('location:' . URL . 'notification/invalidToken');
    }

    public static function login($username, $password, $remember_me = false)
    {
        //todo login with username and password
    }

    public static function redirectIfNotLogin()
    {
        if (
            (isset($_SESSION[SESSION_KEY_LOGIN]) && $_SESSION[SESSION_KEY_LOGIN]) ||
            (!isset($_SESSION[SESSION_KEY_LOGIN]) && Auth::loginIfRemember())
        ) //user is logged in
        {
            return true;
        }
        else
            header('location:' . URL . 'notification/notLogin');

        return false;
    }

    public static function loginIfRemember()
    {
        if (isset($_COOKIE[COOKIE_KEY_REMEMBER_ME])) {
            $user = User::getUserByCookie($_COOKIE[COOKIE_KEY_REMEMBER_ME]);
            if ($user) {
                Auth::initSession($user);
                return true;
            }
        }
        return false;
    }

    private static function rememberMe($user_id)
    {
        $cookie = Auth::generateToken(64);
        setcookie(COOKIE_KEY_REMEMBER_ME, $cookie, time() + 60*60*24*30, '/');
        User::updateCookie($user_id, $cookie);
    }

    public static function generateToken($length)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $token;
    }

    /**
     * @param $user Record
     */
    private static function initSession($user)
    {
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['student_id'] = $user->getStudent_id();
        $_SESSION['firstname'] = $user->getFirstname();
        $_SESSION['lastname'] = $user->getLastname();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION[SESSION_KEY_LOGIN] = true;
    }

    public static function logout()
    {
        if (isset($_SESSION[SESSION_KEY_LOGIN]) && $_SESSION[SESSION_KEY_LOGIN]) {
            session_unset();
            setcookie(COOKIE_KEY_REMEMBER_ME,'', -1, '/');
            header('location:' . URL . 'notification/logout');
        }
        else {
            header('location:' . URL . 'notification/notLogin');
        }
    }
}
