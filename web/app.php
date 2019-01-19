<?php

require __DIR__ . '/../vendor/autoload.php';

function buildRequest(): \Http\Request
{
    $request = new Http\Request();

    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $parameters);

    $request->setUrlPath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
        ->setParameters($parameters)
        ->setMethod($_SERVER['REQUEST_METHOD'])
        ->setBody(file_get_contents('php://input'));

    return $request;
}

$request = buildRequest();
$router = new Router(new Container);
$response = $router->route($request);
header('Content-Type: ' . $response->contentType);
header('Access-Control-Allow-Origin: *');

http_response_code($response->code);
echo $response->content;
