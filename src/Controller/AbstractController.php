<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 20:42
 */

namespace Controller;


use Exception\BadRequestException;
use Exception\ForbiddenException;
use Exception\NotFoundException;
use Http\Request;
use Repository\TokenRepository;
use Security\Token;
use Security\Voter\VoterInterface;

abstract class AbstractController
{

    /**
     * @var VoterInterface[]
     */
    private $voters = [];

    protected $tokenRepository;

    public function __construct(TokenRepository $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    protected function denyAccessUnlessGranted(Request $request, string $action, $subject = null)
    {
        try {
            $token = $this->getToken($request);
        } catch (BadRequestException $e) {
            throw new ForbiddenException("access denied.");
        } catch (NotFoundException $e) {
            throw new ForbiddenException("access denied.");
        }

        foreach ($this->voters as $voter) {
            if (
                $voter->supports($subject, $action) &&
                !$voter->vote($token, $subject, $action)
            ) {
                throw new ForbiddenException('access denied.');
            }
        }
    }


    /**
     * @param Request $request
     * @return Token
     * @throws BadRequestException
     * @throws NotFoundException
     */
    protected function getToken(Request $request): Token
    {
        $authorizationKey = $request->getHeader("Authorization");
        $tokenKey = str_replace('Bearer ', '', $authorizationKey);

        return $this->tokenRepository->fetchByKey($tokenKey);
    }

    public function addVoter(VoterInterface $voter): self
    {
        $this->voters[] = $voter;
        return $this;
    }

}