<?php


namespace calderawp\caldera\DataSource\Contracts;

interface Crud
{


	public function create(array $DataSourceSource):array;
	public function read(int $id): array;
	public function update(int $id, array $DataSource):array;
	public function anonymize($id, $column):array;
	public function delete($id):bool;
}
