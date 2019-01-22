<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 21.01.19
 * Time: 19:29
 */

namespace Transformer;


use Entity\User;
use Entity\UserRole;

class ArrayToUserTransformer
{
    public function transform(array $userAsArray): user
    {
        return new User($userAsArray['id'], $userAsArray['login'], $userAsArray['password_hash'], new UserRole($userAsArray['role_id'], $userAsArray['role_code']));
    }
}