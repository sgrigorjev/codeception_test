<?php

namespace CodeceptionCuriosity\Provider;

use CodeceptionCuriosity\Entity\User;

class UserProvider
{
    private $users = array(
        'admin' => array(
            'role' => User::ROLE_ADMIN,
            'password' => 'admin'
        ),
        'user1' => array(
            'role' => User::ROLE_USER,
            'password' => 'temp123'
        ),
        'user2' => array(
            'role' => User::ROLE_USER,
            'password' => 'temp123'
        )
    );

    public function find(string $name): ?User
    {
        if (isset($this->users[$name])) {
            return new User($name, $this->users[$name]['password'], $this->users[$name]['role']);
        }

        return null;
    }
}
