<?php

namespace CodeceptionCuriosity\Entity;

class User
{

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $role;

    /**
     * User constructor.
     * @param string $name
     * @param string $password
     * @param string $role
     */
    public function __construct(string $name, string $password, string $role)
    {
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $password): bool
    {
        return $password === $this->password;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
