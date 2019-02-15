<?php

namespace GasolWu\Zend1\Resource;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    protected function getTestAccessToken()
    {
        return str_repeat('x', 32);
    }
}
