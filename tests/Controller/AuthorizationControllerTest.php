<?php
/**
 * Created by PhpStorm.
 * User: a.kooli
 * Date: 21.01.19
 * Time: 17:08
 */

namespace Tests\Controller;


use Controller\AuthorizationController;
use Entity\User;
use Entity\UserRole;
use Exception\ForbiddenException;
use Exception\NotFoundException;
use Http\Request;
use PHPUnit\Framework\TestCase;
use Repository\TokenRepository;
use Repository\UserRepository;
use Security\TokenGeneratorInterface;

class AuthorizationControllerTest extends TestCase
{

    public function test_login_case_wrong_password()
    {
        $this->expectException(ForbiddenException::class);

        $userRepositoryMock = $this->getUserRepositoryMock('some_login', 'some_password');

        $controller = new AuthorizationController(
            $userRepositoryMock,
            $this->createMock(TokenGeneratorInterface::class),
            $this->createMock(TokenRepository::class)
        );

        $request = new Request();
        $request->setParameters(['login' => "some_login", "password" => "some_WRONG_password"]);

        $controller->login($request);
    }

    public function test_login_case_non_existent_user()
    {
        $this->expectException(ForbiddenException::class);

        $userRepositoryMock = $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock->method("fetchByLogin")
            ->willThrowException(new NotFoundException());

        $controller = new AuthorizationController(
            $userRepositoryMock,
            $this->createMock(TokenGeneratorInterface::class),
            $this->createMock(TokenRepository::class)
        );

        $request = new Request();
        $request->setParameters(['login' => "some_NON_EXISTENT_login", "password" => "some_WRONG_password"]);

        $controller->login($request);
    }

    private function getUserRepositoryMock(string $login, string $password): \PHPUnit\Framework\MockObject\MockObject
    {
        $userRepositoryMock = $this->createMock(UserRepository::class);

        $userRepositoryMock->method("fetchByLogin")
            ->with($login)
            ->willReturn(
                new User(1, $login,
                    password_hash($password, PASSWORD_DEFAULT),
                    new UserRole(
                        1,
                        "some_role"
                    )
                )
            );
        return $userRepositoryMock;
    }

}