<?php


namespace calderawp\caldera\DataSource\Contracts;

interface Query
{

	public function where(string $field, string $value);
	public function in(array $ids);
	public function orderBy(string $orderBy);
}
