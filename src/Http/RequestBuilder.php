<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 22:08
 */

namespace Http;


class RequestBuilder
{

    public function build()
    {
        $request = new Request();

        parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $parameters);

        $request->setUrlPath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
            ->setParameters($parameters)
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->setBody(file_get_contents('php://input'))
            ->setHeaders($this->getAllHeaders());


        return $request;
    }

    private function getAllHeaders()
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headers[str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
            }
        }
        return $headers;
    }

}