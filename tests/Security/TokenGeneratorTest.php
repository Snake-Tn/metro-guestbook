<?php


namespace Test\Security;


use Entity\User;
use Entity\UserRole;
use Security\TokenGenerator;
use PHPUnit\Framework\TestCase;
use Security\TokenGeneratorInterface;

class TokenGeneratorTest extends TestCase
{
    /**
     * @var TokenGeneratorInterface
     */
    private $generator;

    public function setUp()
    {
        $this->generator = new TokenGenerator("sample_secret_key");
    }

    public function test_generate()
    {
        $user = new User(1, "some login", "some password hash", new UserRole(1, "some role code"));
        $token1 = $this->generator->generate($user);
        $token2 = $this->generator->generate($user);
        $this->assertNotEquals($token1->getTokenKey(),$token2->getTokenKey());
    }

}
