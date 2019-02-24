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
	public function setMetaTable(Table $table): PostTypeWithCustomMetaTable
	{
		$this->table = $table;
		return $this;
	}

	/** @inheritdoc */
	public function findIn(array $ins, string $column): array
	{
		if ($this->isMetaColumn($column)) {
			return $this->getMetaTable()->findIn($ins, $column);
		}

		return parent::findIn($ins, $column);
	}

	/** @inheritdoc */
	public function findWhere(string $column, $value): array
	{
		if ($this->isMetaColumn($column)) {
			$results = [];
			$metaResults =  $this->getMetaTable()->findWhere($column, $value);
			$postIds = [];
			foreach ( $metaResults as $result ){
				$postIds[] = $result[ 'post_id'];
			}
			$posts = parent::findIn( $postIds, 'ID');
			foreach ( $posts as $post ){
				foreach ($metaResults as $i =>  $result ){
					if( $post->ID == $result[ 'post_id']){

						$results[] = array_merge((array)$post, ['meta' => $result ] );
						unset($metaResults[$i]);
						break;
					}
				}
			}
			\WP_REST_Posts_Controller::
			return $results;
		}
		return parent::findWhere($column, $value);
	}

	/**
	 * @inheritDoc
	 */
	public function create(array $data): int
	{
		$prepared = $this->sortData($data);

		$saved = parent::create($prepared[ 'post' ]);
		if ($saved) {
			$prepared[ 'meta' ][ 'post_id' ] = $saved;
			$this->getMetaTable()->create($prepared[ 'meta' ]);
		}
		return $saved;
	}


	/**
	 * @inheritDoc
	 */
	public function update(int $id, array $data): array
	{
		$prepared = $this->sortData($data);
		try {
			$metaRow = $this->getMetaTable()->read($id);
			$this->getMetaTable()->update($metaRow[ 'id' ], $prepared[ 'meta' ]);
		} catch (\Exception $e) {
		}

		return parent::update($id, $data[ 'post' ]);
	}

	protected function sortData($data)
	{
		$prepared[ 'meta' ] = [];
		$prepared[ 'post' ] = [];
		foreach ($data as $key => $value) {
			if ($this->isMetaColumn($key)) {
				$prepared[ 'meta' ][ $key ] = $value;
			} else {
				$prepared[ 'post' ][ $key ] = $value;
			}
		}

		if( empty( $prepared[ 'post' ]['post_title'] ) ){
			$prepared[ 'post' ][ 'post_title' ] = md5(serialize($prepared));
		}
		$prepared[ 'post' ]['post_type'] = $this->getPostType();

		return $prepared;
	}

	public function read(int $id): array
	{
		$data = $this->findById($id);
		return $data;
	}

	/**
	 * @inheritDoc
	 */
	public function anonymize(int $id, string $column): array
	{
		if ($this->isMetaColumn($column)) {
			return $this->getMetaTable()->anonymize($id, $column);
		}
		return parent::anonymize($id, $column);
	}

	/**
	 * @inheritDoc
	 */
	public function delete(int $id): bool
	{
		try {
			$metaRow = $this->getMetaTable()->read($id);
			$this->getMetaTable()->delete($metaRow[ 'id' ]);
		} catch (\Exception $e) {
		}
		return parent::delete($id); // TODO: Change the autogenerated stub
	}

	/**
	 * @inheritDoc
	 */
	public function findById(int $id): array
	{
		$data = $this->getMetaTable()->findById($id);
		if( ! empty( $data) && isset( $data[0])){
			$meta = $data[0];
			$postId = $meta['post_id'];
			$data = array_merge(parent::read($postId),['meta' => $meta ]);
			return $data;
		}
		return [];

	}


	protected function isMetaColumn(string $column): bool
	{
		return $this->getMetaTable()->isAllowedKey($column);
	}
}
