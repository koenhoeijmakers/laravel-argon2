<?php

namespace KoenHoeijmakers\LaravelArgon2\Tests\Unit;

use PHPUnit\Framework\TestCase;
use KoenHoeijmakers\LaravelArgon2\Argon2Hasher;

class Argon2HasherTest extends TestCase
{
    public function testArgon2Hashing()
    {
        if (! defined('PASSWORD_ARGON2I')) {
            $this->markTestSkipped('PHP not compiled with argon2 hashing support.');
        }

        $hasher = new Argon2Hasher();

        $value = $hasher->make('password');
        $this->assertNotSame('password', $value);
        $this->assertTrue($hasher->check('password', $value));
        $this->assertFalse($hasher->needsRehash($value));
        $this->assertTrue($hasher->needsRehash($value, ['threads' => 1]));
    }
}
