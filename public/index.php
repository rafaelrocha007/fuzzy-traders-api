<?php

ini_set('display_errors', 1);

require_once "../vendor/autoload.php";

use App\Database\Connector;
use Dotenv\DotEnv;

$dotenv = new DotEnv(__DIR__ . '/../');
$dotenv->load();

$conn = (new Connector())->getConnection();


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if (!in_array($uri[1], ['asset', 'portfolio', 'user'])) {
    header("HTTP/1.1 404 Not Found");
    die('Http not found');
}

$resourceId = null;
if (isset($uri[2])) {
    $resourceId = (int)$uri[2];
}

$method = $_SERVER["REQUEST_METHOD"];

$controller = '\\App\\Controller\\' . ucfirst($uri[1]) . 'Controller';

$controller = new $controller($conn, $method, $resourceId);
$controller->processRequest();


