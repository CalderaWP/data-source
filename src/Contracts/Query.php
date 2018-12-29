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
	public function findWhere(string $column, $value) : Result;
	public function findIn(array $ins, string $column) : Result;
	/**
	 * Find a record by primary key
	 *
	 * @param  $id
	 * @return Result
	 */
	public function findById(int $id) : Result;
}
