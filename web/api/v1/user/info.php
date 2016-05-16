<?php

define('BASEDIR', dirname(__DIR__));

require_once BASEDIR . '/app.php';
User::authenticate();

Response::fire(200, array("username" => "guest"));
