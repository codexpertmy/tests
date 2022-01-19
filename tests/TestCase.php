<?php

namespace Codexpert\Tests;

use Mockery as m;
use PHPUnit\Framework\TestCase as PHPUnit;

class TestCase extends PHPUnit
{
    protected function tearDown(): void
    {
        m::close();
    }
}
