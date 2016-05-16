<?php

define('BASEDIR', dirname(dirname(__DIR__)));

require_once BASEDIR . '/app.php';
User::authenticate();

if (!headers_sent()) {
    $date = gmdate('Y-m-d H:i:s');
    setcookie('RemainValue', $date, 0, '/', null, false, true);
    Response::fire(200, array("success" => true, "RemainValue" => $date));
}
Response::fire(500, array("success" => false));