<?php declare(strict_types=1);

namespace Iam\Tests\Unit;

use Iam\Application\Model\BaseAccount;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @covers \Iam\Application\Model\BaseAccount
 */
class BaseAccountTest extends TestCase
{
    final public const IDENTIFIER_VALUE = '123456';

    final public const EMAIL_VALUE = 'irrelevant@example.com';

    final public const PASSWORD_VALUE = 'encrypted-password';

    /**
     * @test
     */
    public function shouldExposeTheIdentifier(): void
    {
        $sut = new BaseAccount(self::IDENTIFIER_VALUE, self::EMAIL_VALUE, self::PASSWORD_VALUE);

        self::assertEquals(self::IDENTIFIER_VALUE, $sut->id());
    }

    /**
     * @test
     */
    public function shouldExposeTheEmail(): void
    {
        $sut = new BaseAccount(self::IDENTIFIER_VALUE, self::EMAIL_VALUE, self::PASSWORD_VALUE);

        self::assertEquals(self::EMAIL_VALUE, $sut->email());
    }

    /**
     * @test
     */
    public function shouldExposeThePassword(): void
    {
        $sut = new BaseAccount(self::IDENTIFIER_VALUE, self::EMAIL_VALUE, self::PASSWORD_VALUE);

        self::assertEquals(self::PASSWORD_VALUE, $sut->getPassword());
    }

    /**
     * @test
     */
    public function shouldChangeThePassword(): void
    {
        $sut = new BaseAccount(self::IDENTIFIER_VALUE, self::EMAIL_VALUE, self::PASSWORD_VALUE);

        $sut->setPassword('new-password');

        self::assertNotEquals(self::PASSWORD_VALUE, $sut->getPassword());
        self::assertEquals('new-password', $sut->getPassword());
    }

    /**
     * @test
     */
    public function shouldBeConformedToSecurityFrameworkInterfaces(): void
    {
        $sut = new BaseAccount(self::IDENTIFIER_VALUE, self::EMAIL_VALUE, self::PASSWORD_VALUE);

        self::assertInstanceOf(UserInterface::class, $sut);
        self::assertInstanceOf(PasswordAuthenticatedUserInterface::class, $sut);
    }

    /**
     * @test
     */
    public function shouldHaveMinimumRole(): void
    {
        $sut = new BaseAccount(self::IDENTIFIER_VALUE, self::EMAIL_VALUE, self::PASSWORD_VALUE);

        self::assertContains('ROLE_USER', $sut->getRoles());
    }

    /**
     * @test
     */
    public function shouldAcceptMultipleRoles(): void
    {
        $sut = new BaseAccount(self::IDENTIFIER_VALUE, self::EMAIL_VALUE, self::PASSWORD_VALUE);
        $sut->setRoles(['ROLE_ALPHA', 'ROLE_BETA']);

        self::assertContains('ROLE_USER', $sut->getRoles());
        self::assertContains('ROLE_ALPHA', $sut->getRoles());
        self::assertContains('ROLE_BETA', $sut->getRoles());
    }

    public function shouldEraseCredentials(): never
    {
        self::markTestIncomplete();
    }
}
