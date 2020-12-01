<?php

namespace CodeceptionCuriosity\Tests\Unit\Entity;

use CodeceptionCuriosity\Entity\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var User
     */
    protected $user;

    protected function _before()
    {
        $this->user = new User('admin', 'temp123', User::ROLE_ADMIN);
    }

    public function testGetName()
    {
        $this->assertEquals('admin', $this->user->getName());
    }

    public function testVerifyPasswordSuccess()
    {
        $this->assertTrue($this->user->verifyPassword('temp123'));
    }

    public function testVerifyPasswordFailed()
    {
        $this->assertFalse($this->user->verifyPassword('notapassword'));
    }
}
