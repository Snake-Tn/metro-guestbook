<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

namespace Tests\Security\Voter;


use Entity\User;
use Entity\UserRole;
use PHPUnit\Framework\TestCase;
use Security\Token;
use Security\Voter\EntryVoter;

class EntryVoterTest extends TestCase
{
    /**
     * @var EntryVoter
     */
    private $voter;

    public function setUp()
    {
        $this->voter = new EntryVoter();
    }

    function test_vote_case_user_is_guest_action_is_approve_entry()
    {
        $guest = $this->getToken('guest');
        $voteDecision = $this->voter->vote($guest, "some_subject", "approve_entry");
        $this->assertFalse($voteDecision);
    }
    function test_vote_case_user_is_guest_action_is_show_approved_entries()
    {
        $guest = $this->getToken('guest');
        $voteDecision = $this->voter->vote($guest, "some_subject", "show_approved_entries");
        $this->assertTrue($voteDecision);
    }

    function test_vote_case_user_is_admin_action_is_show_all_entries()
    {
        $guest = $this->getToken('admin');
        $voteDecision = $this->voter->vote($guest, "some_subject", "show_approved_entries");
        $this->assertTrue($voteDecision);
    }

    private function getToken($roleCode): Token
    {
        return new Token("some_token_key", new User(1, "some_login", "some_pass_hash", new UserRole(1, $roleCode)), 999);
    }

}