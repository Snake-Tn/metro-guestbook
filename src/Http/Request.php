<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Http;

use Exception\BadRequestException;

class Request
{
    /**
     * @var string
     */
    private $urlPath;

    /**
     * @var string
     */
    private $method;

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var array
     */
    private $headers = [];
    /**
     * @var string
     */
    private $body;

    /**
     * @param string $parameterKey
     * @return string
     * @throws BadRequestException
     */
    public function get(string $parameterKey): string
    {
        if (!isset($this->parameters[$parameterKey])) {
            throw new BadRequestException(sprintf("Parameter [%s] is missing.", $parameterKey));
        }
        return $this->parameters[$parameterKey];
    }

    /**
     * @param string $parameterKey
     * @return bool
     */
    public function has(string $parameterKey): bool
    {
        return array_key_exists($parameterKey, $this->parameters);
    }

    /**
     * @param mixed $urlPath
     * @return Request
     */
    public function setUrlPath(string $urlPath): Request
    {
        $this->urlPath = $urlPath;
        return $this;
    }

    /**
     * @param mixed $method
     * @return Request
     */
    public function setMethod(string $method): Request
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @param array $parameters
     * @return Request
     */
    public function setParameters(array $parameters): Request
    {
        $this->parameters = $parameters;
        return $this;
    }

    /**
     * @param string $key
     * @param string $value
     * @return Request
     */
    public function addParameter(string $key, string $value): Request
    {
        $this->parameters[$key] = $value;
        return $this;
    }

    /**
     * @param array $headers
     * @return Request
     */
    public function setHeaders(array $headers): Request
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @param string $body
     * @return Request
     */
    public function setBody(string $body): Request
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getUrlPath(): string
    {
        return $this->urlPath;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param $headerKey
     * @return bool
     */
    public function hasHeader($headerKey): bool
    {
        return array_key_exists($headerKey, $this->headers);
    }

    /**
     * @param $headerKey
     * @return string
     * @throws BadRequestException
     */
    public function getHeader(string $headerKey): string
    {
        if (!isset($this->headers[$headerKey])) {
            throw new BadRequestException(sprintf("Header [%s] is missing.", $headerKey));
        }
        return $this->headers[$headerKey];
    }
}