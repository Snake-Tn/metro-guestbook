<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Validator;


class ValidationError
{
    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $msg;

    /**
     * @param string $code
     * @param string $msg
     */
    public function __construct(string $code, string $msg)
    {
        $this->code = $code;
        $this->msg = $msg;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMsg(): string
    {
        return $this->msg;
    }


}