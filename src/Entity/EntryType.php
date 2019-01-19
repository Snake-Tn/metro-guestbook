<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 12:32
 */

namespace Entity;


class EntryType
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $code;

    /**
     * @param string $id
     * @param string $code
     */
    public function __construct(string $id, string $code)
    {
        $this->id = $id;
        $this->code = $code;
    }


}