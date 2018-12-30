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
	 * @return int New entry ID
	 */
	public function create(array $data):int;
	/**
	 * Find by primary key
	 *
	 * @param  int $id
	 * @return array
	 */
	public function read(int $id): array;
	/**
	 * Update a record
	 *
	 * @param  int $id   ID of record to update
	 * @param  array  $data New data to update with
	 * @return array
	 */
	public function update(int $id, array $data):array;
	/**
	 * Anonymize a column of one record
	 *
	 * @param  int $id     ID of record to update
	 * @param  string $column
	 * @return array
	 * @throws InvalidColumnException
	 */
	public function anonymize(int $id, string $column):array;
	/**
	 * Delete a row by primary key
	 *
	 * @param  int $id Delete a record by ID
	 * @return bool
	 */
	public function delete(int$id):bool;
}
