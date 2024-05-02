<?php

namespace App\Tests\UnitTests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestsXdebug extends KernelTestCase
{

    function testXdebug()
    {
        $target = true;
        $this->assertTrue($target);
    }
}