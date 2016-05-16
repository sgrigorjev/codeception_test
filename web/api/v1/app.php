<?php

header('Content-Type: application/json');

$users = array(
    'admin' => array(
        'role' => User::ROLE_ADMIN,
        'password' => 'admin'
    ),
    'user1' => array(
        'role' => User::ROLE_USER,
        'password' => 'temp123'
    ),
    'user2' => array(
        'role' => User::ROLE_USER,
        'password' => 'temp123'
    )
);

class Response
{

    public $status;
    public $data;

    public function __construct($status, $data)
    {
        $this->status = $status;
        $this->data = $data;
    }

    static public function fire($status, $data)
    {
        switch ($status) {
            case 200:
                header('HTTP/1.0 200 OK');
                break;
            case 400:
                header('HTTP/1.0 400 Bad Request');
                break;
            case 403:
                header('HTTP/1.0 403 Forbidden');
                break;
            case 404:
                header('HTTP/1.0 404 Not Found');
                break;
            case 500:
                header('HTTP/1.0 500 Internal Server Error');
                break;
        }
        echo json_encode(new Response($status, $data));
        exit;
    }

}

class User
{

    const ROLE_USER = 1;
    const ROLE_ADMIN = 2;

    static protected $username;
    static protected $role;

    static public function login()
    {
        global $users;

        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']))
        {
            if (array_key_exists($_SERVER['PHP_AUTH_USER'], $users) && $users[$_SERVER['PHP_AUTH_USER']]['password'] === $_SERVER['PHP_AUTH_PW'])
            {
                self::$username = $_SERVER['PHP_AUTH_USER'];
                self::$role = $users[$_SERVER['PHP_AUTH_USER']]['role'];
                $token = json_encode(array(
                    'username' => self::$username,
                    'role' => self::$role
                ));
                self::setAuthCookie($token);
                header('HTTP/1.0 202 Accepted');
                echo $token;
                exit;
            }
            else
            {
                self::forbidden('Authorization failed');
            }
        }
        else
        {
            self::unauthorized();
        }
    }

    static public function logout()
    {
        self::clearAuthCookie();
        Response::fire('200', 'Logout');
    }

    static public function authenticate()
    {
        global $users;

        if (isset($_COOKIE['token']))
        {
            $data = json_decode($_COOKIE['token'], true);
            if (!$data || !array_key_exists($data['username'], $users))
            {
                self::clearAuthCookie();
                self::forbidden('Invalid cookie');
            }
            self::$username = $data['username'];
            self::$role = $data['role'];
        }
        else
        {
            self::forbidden('Authentication failed');
        }
    }

    static public function getUsername()
    {
        return self::$username;
    }

    static public function getRole()
    {
        return self::$role;
    }

    static protected function unauthorized($reason = 'Unauthorized')
    {
        header('WWW-Authenticate: Basic realm="My Realm"');
        header('HTTP/1.0 401 Unauthorized');
        Response::fire(401, $reason);
    }

    static protected function forbidden($reason = 'Forbidden')
    {
        header('HTTP/1.0 403 Forbidden');
        Response::fire(403, $reason);
    }

    static public function setAuthCookie($data)
    {
        setcookie('token', $data, time() + 86400, '/');
    }

    static public function clearAuthCookie()
    {
        setcookie('token', '', -1, '/');
    }

}
