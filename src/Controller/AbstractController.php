<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 20:42
 */

namespace Controller;


use Exception\ForbiddenException;
use Security\Token;
use Security\Voter\VoterInterface;

abstract class AbstractController
{

    /**
     * @var VoterInterface[]
     */
    private $voters = [];

    protected function denyAccessUnlessGranted($accessToken, string $action, $subject = null)
    {
        foreach ($this->voters as $voter) {
            if (
                $voter->supports($subject, $action) &&
                $voter->vote($this->getToken(), $subject, $action)
            ) {
                throw new ForbiddenException('access denied.');
            }
        }
    }


    public function addVoter(VoterInterface $voter): self
    {
        $this->voters[] = $voter;
        return $this;
    }

    protected function getToken(): Token
    {
    }
}