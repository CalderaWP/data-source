<?php


namespace calderawp\caldera\DataSource\Contracts;

use WpDbTools\Type\Result;
use calderawp\DB\Exceptions\InvalidColumnException;

interface Crud
{

	/**
	 * Insert new data into the database for this table
	 *
	 * Value of new row's primary key is returned if successful.
	 *
	 * @param  array $data
	 * @return int New tentry ID
	 */
	public function create(array $data):int;
	/**
	 * Find by primary key
	 *
	 * @param  int $id
	 * @return Result
	 */
	public function read(int $id): Result;
	/**
	 * Update a record
	 *
	 * @param  int $id   ID of record to update
	 * @param  array  $data New data to update with
	 * @return Result
	 */
	public function update(int $id, array $data):Result;
	/**
	 * Anonymize a column of one record
	 *
	 * @param  int $id     ID of record to update
	 * @param  string $column
	 * @return Result
	 * @throws InvalidColumnException
	 */
	public function anonymize(int $id, string $column):Result;
	/**
	 * Delete a row by primary key
	 *
	 * @param  int $id Delete a record by ID
	 * @return bool
	 */
	public function delete(int$id):bool;
}
