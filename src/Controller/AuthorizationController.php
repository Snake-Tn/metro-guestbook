<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 19.01.19
 * Time: 14:31
 */

namespace Controller;

use Exception\ForbiddenException;
use Exception\NotFoundException;
use Http\Request;
use Http\Response;
use Repository\TokenRepository;
use Repository\UserRepository;
use Security\TokenGeneratorInterface;
use Entity\User;

class AuthorizationController extends AbstractController
{

    private $userRepository;
    private $tokenGenerator;

    public function __construct(
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        TokenRepository $tokenRepository
    )
    {
        $this->userRepository = $userRepository;
        $this->tokenGenerator = $tokenGenerator;
        parent::__construct($tokenRepository);
    }


    public function login(Request $request): Response
    {
        $user = $this->getUser($request->get('login'));

        $this->checkPasswordsMatches($request->get('password'), $user->getPasswordHash());

        $token = $this->tokenGenerator->generate($user);
        $this->tokenRepository->persist($token);

        return new Response(json_encode([
            'access_token' => $token->getTokenKey(),
            'expires_in' => $token->getExpiresIn()
        ]), Response::JSON_CONTENT_TYPE, Response::OK);

    }

    /**
     * @param $givenPassword
     * @param $actualPasswordHash
     * @throws ForbiddenException
     */
    private function checkPasswordsMatches(string $givenPassword, string $actualPasswordHash): void
    {
        $passwordsMatches = password_verify($givenPassword, $actualPasswordHash);

        if (!$passwordsMatches) {
            throw new ForbiddenException("bad password or login.");
        }
    }

    /**
     * @param string $login
     * @return \Entity\User
     * @throws ForbiddenException
     */
    private function getUser(string $login): User
    {
        try {
            $user = $this->userRepository->fetchByLogin($login);
        } catch (NotFoundException $e) {
            throw new ForbiddenException("bad password or login.");
        }
        return $user;
    }

}