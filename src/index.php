<?php
require './routes/routes.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, DELETE, PUT, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Max-Age: *');
header('Content-Type: *');


$URI = $_SERVER['REQUEST_URI'];
$httpMethod = $_SERVER['REQUEST_METHOD'];


$explodedURI = explode('/', $URI);

$router->routeHandler($explodedURI, $httpMethod);