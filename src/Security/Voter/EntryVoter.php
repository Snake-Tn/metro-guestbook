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
        switch ($action){
            case 'create_entry':
                return true;
            default:
                return true;
        }
    }


    public function supports($subject, string $action): bool
    {
        return in_array($action, ['create_entry']);
    }

}