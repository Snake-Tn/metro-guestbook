<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 20:52
 */

namespace Security\Voter;


use Security\Token;

interface VoterInterface
{
    /**
     * determines if a user holding $token is allowed to perform $action on the subject $subject
     * returns true if access is granted, otherwise false
     * @param Token $token
     * @param $subject
     * @param string $action
     * @return bool
     */
    public function vote(Token $token, $subject, string $action): bool;

    /**
     * determines if subject and action are supported by voter.
     * @param $subject
     * @param string $action
     * @return bool
     */
    public function supports($subject, string $action): bool;
}