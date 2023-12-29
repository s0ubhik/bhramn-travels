<?php require_once("config.php");
require_once("router.php");
require_once __DIR__.'/../vendor/autoload.php';

use MongoDB\Client;

$env = parse_ini_file(__DIR__.'/../.env');

$mongo = new MongoDB\Client($env['MONGO_URL']);


?>