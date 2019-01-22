<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 21.01.19
 * Time: 22:06
 */

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