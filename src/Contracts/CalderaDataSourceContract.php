<?php


namespace calderawp\caldera\DataSource\Contracts;

use calderawp\caldera\DataSource\Contracts\SourceContract as Source;
use calderawp\interop\Contracts\CalderaModule;

interface CalderaDataSourceContract extends CalderaModule
{

	/**
 * @return Source[]
 */
	public function getSources(): array;

	/**
	 * @param Source $source
	 *
	 * @return Source
	 */
	public function addSource(Source $source): CalderaDataSourceContract;
	/**
	 * Get source by class name
	 *
	 * @param string $className
	 *
	 * @return Source
	 */
	public function getSource(string $className): Source;
}
