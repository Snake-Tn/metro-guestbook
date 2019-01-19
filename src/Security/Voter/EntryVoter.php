<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 20:53
 */

namespace Security\Voter;


use Security\Token;


class EntryVoter implements VoterInterface
{
    public function vote(Token $token, $subject, string $action): bool
    {
        return true;
        // TODO: Implement vote() method.
    }


    public function supports($subject, string $action): bool
    {
        return true;
        // TODO: Implement supports() method.
    }

}