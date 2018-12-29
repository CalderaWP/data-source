<?php


namespace calderawp\caldera\DataSource\Tests;

use calderawp\caldera\Core\Tests\Traits\SharedFactories;
use PHPUnit\Framework\TestCase as _TestCase;

abstract class TestCase extends \Mockery\Adapter\Phpunit\MockeryTestCase
{
	use SharedFactories;
}
