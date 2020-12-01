<?php

namespace CodeceptionCuriosity\Tests\Unit\Provider;

use CodeceptionCuriosity\Entity\User;
use CodeceptionCuriosity\Provider\UserProvider;

class UserProviderTest extends \Codeception\Test\Unit
{
    public function testFound()
    {
        $provider = new UserProvider();
        $user = $provider->find('admin');
        $this->assertInstanceOf(User::class, $user);
    }

    public function testNotFound()
    {
        $provider = new UserProvider();
        $user = $provider->find('noname');
        $this->assertNull($user);
    }
}
