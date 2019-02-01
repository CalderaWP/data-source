<?php


namespace calderawp\caldera\DataSource\Contracts;

use WpDbTools\Type\Result;
use calderawp\DB\Exceptions\InvalidColumnException;

interface Query
{
	/**
	 * Search where a column has a value
	 *
	 * @param  string           $column Column to search in
	 * @param  string|int|float $value  Value to search by
	 * @return Result
	 * @throws InvalidColumnException
	 */
	public function findWhere(string $column, $value) : array;

	/**
	 * Find with an in() query
	 *
	 * @param array $ins
	 * @param string $column
	 *
	 * @return array
	 */
	public function findIn(array $ins, string $column) : array;
	/**
	 * Find a record by primary key
	 *
	 * @param  $id
	 * @return Result
	 */
	public function findById(int $id) : array;
}
