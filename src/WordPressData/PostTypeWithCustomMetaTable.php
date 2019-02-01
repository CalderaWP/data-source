<?php


namespace calderawp\caldera\DataSource\WordPressData;


use calderawp\DB\Exceptions\InvalidColumnException;
use calderawp\DB\Table;

class PostTypeWithCustomMetaTable extends PostType
{

	/** @var Table */
	protected $table;


	/**
	 * @param string $column
	 * @param string $value
	 *
	 * @return array
	 * @throws InvalidColumnException
	 */
	public function findByMetaColumn(string $column, string $value): array
	{
		if (!$this->getMetaTable()->isAllowedKey($column)) {
			throw new InvalidColumnException();
		}
		return $this->getMetaTable()->findWhere($column, $value);
	}

	/**
	 * @param int $postId
	 *
	 * @return array
	 * @throws InvalidColumnException
	 */
	public function getMetaRow(int $postId): array
	{
		return $this->getMetaTable()->findWhere('post_id', $postId);
	}

	/**
	 * @param int $postId
	 * @param string $metaColumn
	 *
	 * @return mixed
	 * @throws InvalidColumnException
	 */
	public function getMetaValue(int $postId, string $metaColumn)
	{
		$row = $this->getMetaRow($postId);
		if (!empty($row) && isset($row[ $metaColumn ])) {
			return $row[ $metaColumn ];
		}

		throw new InvalidColumnException();
	}

	/**
	 * @return Table
	 */
	public function getMetaTable(): Table
	{
		return $this->table;
	}

	/**
	 * @param Table $table
	 *
	 * @return PostTypeWithCustomMetaTable
	 */
	public function setMetaTable(Table $table) : PostTypeWithCustomMetaTable
	{
		$this->table = $table;
		return $this;
	}


}
