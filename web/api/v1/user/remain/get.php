<?php

define('BASEDIR', dirname(dirname(__DIR__)));

require_once BASEDIR . '/app.php';
User::authenticate();

if (array_key_exists('RemainValue', $_COOKIE) && $_COOKIE['RemainValue']) {
    Response::fire(200, array("success" => true, "RemainValue" => $_COOKIE['RemainValue']));
}
Response::fire(400, array("success" => false, "description" => "Cookie is not found"));