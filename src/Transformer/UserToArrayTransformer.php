<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 21.01.19
 * Time: 19:23
 */

namespace Transformer;


use Entity\User;

class UserToArrayTransformer
{

    public function transform(User $user): array
    {
        return [
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'password_hash' => $user->getPasswordHash(),
            'role_id' => $user->getRole()->getId(),
            'role_code' => $user->getRole()->getCode()
        ];
    }

}