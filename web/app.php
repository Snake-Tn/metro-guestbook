<?php

require __DIR__ . '/../vendor/autoload.php';

$requestBuilder = new \Http\RequestBuilder();
$request = $requestBuilder->build();

$router = new Router(new Container);
$response = $router->route($request);

header('Content-Type: ' . $response->contentType);
header('Access-Control-Allow-Origin: *');

http_response_code($response->code);
echo $response->content;
