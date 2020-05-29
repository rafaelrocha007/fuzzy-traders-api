<?php

ini_set('display_errors', 1);

require_once "../vendor/autoload.php";

use App\Database\Connector;
use Dotenv\Dotenv;

if(!getenv('DB_HOST')) {
    $dotenv = new Dotenv(__DIR__ . '/../');
    $dotenv->load();
}

$conn = (new Connector())->getConnection();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if (!in_array($uri[1], ['asset', 'portfolio', 'user', 'session'])) {
    header("HTTP/1.1 404 Not Found");
}

$resourceId = null;
if (isset($uri[2])) {
    $resourceId = $uri[2];
}

$method = $_SERVER["REQUEST_METHOD"];

$controller = '\\App\\Controller\\' . ucfirst($uri[1]) . 'Controller';
if (!class_exists($controller))
    $controller = '\\App\\Controller\\Controller';

$gateway = '\\App\\Model\\TableGateway\\' . ucfirst($uri[1]) . 'Gateway';
$controller = new $controller($method, $resourceId, new $gateway($conn));
$controller->processRequest();
