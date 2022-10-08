<?php declare(strict_types=1);

namespace Iam\Application\Model;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class BaseAccount implements UserInterface, PasswordAuthenticatedUserInterface
{
    private array $roles = [];

    public function __construct(
        private readonly string $id,
        private readonly string $email,
        private string $password,
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * TODO: Implement eraseCredentials() method.
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
    }
}
