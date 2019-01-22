<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 21.01.19
 * Time: 22:05
 */

namespace Validator;

interface ValidatorInterface
{
    /**
     * Validate input and return an array of errors if not valid, empty array if valid.
     * @param array $input array to validate
     * @return ValidationError[]
     */
    public function validate(array $input): array;

}