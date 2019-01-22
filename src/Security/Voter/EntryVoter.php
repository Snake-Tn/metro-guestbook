<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Security\Voter;


use Entity\Entry;
use Security\Token;


class EntryVoter implements VoterInterface
{
    public function vote(Token $token, $subject, string $action): bool
    {
        switch ($action) {
            case 'create_entry':
                return true;
            case 'approve_entry':
                return $this->isAdmin($token);
            case 'update_entry':
            case 'delete_entry':
                /* @var $subject Entry */
                return $this->isAdmin($token) ||
                    ($this->isGuest($token) && $subject->getOwner()->getId() === $token->getUser()->getId());
            default:
                return false;
        }
    }


    public function supports($subject, string $action): bool
    {
        return in_array($action, ['create_entry', 'approve_entry', 'update_entry', 'delete_entry']) &&
            (is_null($subject) || $subject instanceof Entry);
    }


    private function isGuest(Token $token): bool
    {
        return $token->getUser()->getRole()->getCode() === 'guest';
    }

    private function isAdmin(Token $token): bool
    {
        return $token->getUser()->getRole()->getCode() === 'admin';
    }

}