<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 16:45
 */

namespace Security;


use Entity\User;

interface TokenGeneratorInterface
{

    public function generate(User $user): Token;

}