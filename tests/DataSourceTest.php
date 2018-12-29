<?php

namespace calderawp\caldera\DataSource\Tests;

use calderawp\caldera\DataSource\CalderaDataSource;

class DataSourceTest extends TestCase
{

	/**
	 * @covers \calderawp\caldera\DataSource\CalderaDataSource::getIdentifier()
	 */
	public function testGetIdentifier()
	{
		$dataSource = new CalderaDataSource($this->core(), $this->serviceContainer());
		$this->assertSame(CalderaDataSource::IDENTIFIER, $dataSource->getIdentifier());
	}
	/**
	 * @covers \calderawp\caldera\DataSource\CalderaDataSource::addSource()
	 * @covers \calderawp\caldera\DataSource\CalderaDataSource::getSource()
	 */
	public function testAddGetSource()
	{
		$source = \Mockery::mock('FormsSource', \calderawp\caldera\DataSource\Contracts\SourceContract::class);
		$dataSource = new CalderaDataSource($this->core(), $this->serviceContainer());
		$dataSource->addSource($source);
		$this->assertSame($source, $dataSource->getSource(get_class($source)));
	}
	/**
	 * @covers \calderawp\caldera\DataSource\CalderaDataSource::registerServices()
	 */
	public function testRegisterServices()
	{
		$dataSource = new CalderaDataSource($this->core(), $this->serviceContainer());
		$this->assertInstanceOf(CalderaDataSource::class, $dataSource->registerServices($dataSource->getServiceContainer()));
	}
	/**
	 * @covers \calderawp\caldera\DataSource\CalderaDataSource::getSources()
	 */
	public function testGetSources()
	{
		$source = \Mockery::mock('FormsSource', \calderawp\caldera\DataSource\Contracts\SourceContract::class);
		$dataSource = new CalderaDataSource($this->core(), $this->serviceContainer());
		$dataSource->addSource($source);
		$this->assertCount(1, $dataSource->getSources());
	}
}
