<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Http;
class Response
{
    const OK = 200;
    const CREATED = 201;
    const BAD_REQUEST = 400;
    const INVALID_USERNAME_OR_PASSWORD = 403;
    const NOT_FOUND = 404;
    const INTERNAL_SERVER_ERROR = 500;

    const JSON_CONTENT_TYPE = 'application/json';
    const HTML_CONTENT_TYPE = 'text/html';

    public $content;
    public $contentType;
    public $code;

    public function __construct(string $content, string $contentType = self::HTML_CONTENT_TYPE, int $code = self::OK)
    {
        $this->content = $content;
        $this->contentType = $contentType;
        $this->code = $code;
    }
}