<?php

namespace calderawp\caldera\DataSource\Tests;

use calderawp\caldera\DataSource\DataSource;

class DataSourceTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\DataSource\DataSource::getIdentifier()
	 */
	public function testGetIdentifier()
	{
		$dataSource = new DataSource($this->core(),$this->serviceContainer());
		$this->assertSame(DataSource::IDENTIFIER,$dataSource->getIdentifier());
	}
	/**
	 * @covers \calderawp\caldera\DataSource\DataSource::addSource()
	 * @covers \calderawp\caldera\DataSource\DataSource::getSource()
	 */
	public function testAddGetSource()
	{
		$source = \Mockery::mock('FormsSource', \calderawp\caldera\DataSource\Contracts\SourceContract::class );
		$dataSource = new DataSource($this->core(),$this->serviceContainer());
		$dataSource->addSource($source );
		$this->assertSame($source, $dataSource->getSource(get_class($source) ) );
	}
	/**
	 * @covers \calderawp\caldera\DataSource\DataSource::registerServices()
	 */
	public function testRegisterServices()
	{
		$dataSource = new DataSource($this->core(),$this->serviceContainer());
		$this->assertInstanceOf(DataSource::class, $dataSource->registerServices($dataSource->getServiceContainer()));

	}
	/**
	 * @covers \calderawp\caldera\DataSource\DataSource::getSources()
	 */
	public function testGetSources()
	{
		$source = \Mockery::mock('FormsSource', \calderawp\caldera\DataSource\Contracts\SourceContract::class );
		$dataSource = new DataSource($this->core(),$this->serviceContainer());
		$dataSource->addSource($source );
		$this->assertCount(1,$dataSource->getSources( ) );
	}
}
