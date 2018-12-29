<?php


namespace calderawp\caldera\DataSource;

use calderawp\CalderaContainers\Service\Container as ServiceContainer;
use calderawp\interop\Contracts\CalderaModule;
use calderawp\interop\Module;
use calderawp\caldera\DataSource\Contracts\DataSourceContract;
use calderawp\caldera\DataSource\Contracts\SourceContract as Source;

class DataSource extends Module implements DataSourceContract
{
	const IDENTIFIER  = 'dataSource';

	/**
	 * @var Source[]
	 */
	protected $sources;
	/**
	 * @inheritDoc
	 */
	public function getIdentifier(): string
	{
		return self::IDENTIFIER;
	}

	/**
	 * @return DataSourceContract[]
	 */
	public function getSources(): array
	{
		return $this->sources;
	}

	/**
	 * @param Source $source
	 *
	 * @return DataSource
	 */
	public function addSource(Source $source): DataSource
	{
		$this->sources[get_class($source)] = $source;
		return $this;
	}

	/**
	 * Get source by class name
	 *
	 * @param string $className
	 *
	 * @return Source
	 */
	public function getSource(string $className): Source
	{
		return $this->sources[$className];
	}

	/**
	 * @param ServiceContainer $container
	 *
	 * @return CalderaModule
	 */
	public function registerServices(ServiceContainer $container): CalderaModule
	{

		return $this;
	}
}
