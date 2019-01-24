<?php

require __DIR__ . '/../vendor/autoload.php';

$requestBuilder = new \Http\RequestBuilder();
$request = $requestBuilder->build();

$router = new Router(new Container);
if ($request->getMethod() == "OPTIONS") {
    header('Access-Control-Allow-Headers: authorization,content-type');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE');
    header('Access-Control-Allow-Origin: *');
    die;
}
$response = $router->route($request);

header('Content-Type: ' . $response->contentType);
header('Access-Control-Allow-Origin: *');

http_response_code($response->code);
echo $response->content;
