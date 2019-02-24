<?php


namespace calderawp\caldera\DataSource\WordPressData;

use calderawp\caldera\DataSource\Contracts\WordPressPostTypeContract;
use calderawp\caldera\DataSource\Exception;
use calderawp\DB\Exceptions\InvalidColumnException;
use WpDbTools\Type\Result;

class PostType implements WordPressPostTypeContract
{
	/** @var string  */
	protected $postType;
	public function __construct(string $postType)
	{
		$this->postType = $postType;
	}

	/**
	 * @inheritDoc
	 */
	public function create(array $data): int
	{
		$idOrError = wp_insert_post($data);
		if (is_numeric($idOrError)) {
			return (int)$idOrError;
		}
		throw new Exception($idOrError->get_error_message(), $idOrError->get_error_code());
	}

	/**
	 * @inheritDoc
	 */
	public function read(int $id): array
	{
		$post = get_post($id, ARRAY_A);
		if (is_array($post)) {
			return $post;
		}
		throw new Exception('Not Found', 404);
	}

	/**
	 * @inheritDoc
	 */
	public function update(int $id, array $data): array
	{
		$data[ 'ID' ] = $id;
		$idOrError = wp_update_post($data);
		if (is_numeric($idOrError)) {
			return $this->read($idOrError);
		}
		throw new Exception($idOrError->get_error_message(), $idOrError->get_error_code());
	}

	/**
	 * @inheritDoc
	 */
	public function anonymize(int $id, string $column): array
	{
		$post = $this->read($id);
		if (isset($post[$column])) {
			$post[$column] = 'XXXX';
			return $this->update($id, $post);
		}
		return $post;
	}

	/**
	 * @inheritDoc
	 */
	public function delete(int $id): bool
	{
		return false != wp_delete_post($id);
	}

	/**
	 * @inheritDoc
	 */
	public function findWhere(string $column, $value): array
	{

		if (! in_array($column, $this->getQueryColumns())) {
			throw new InvalidColumnException();
		}
		$args = [
			'post_type' => $this->getPostType()
		];

		switch ($column) {
			case 'ID':
				$args[ 'p' ] = (int) $value;
				break;
			case 'title':
				$args[ 'title' ] =  $value;
				break;
			case 'parent_id';
				$args[ 'post_parent'] = (int) $value;
				break;
		}
		return get_posts($args);
	}

	/**
	 * @inheritDoc
	 */
	public function findIn(array $ins, string $column): array
	{
		if (! in_array($column, $this->getQueryColumns())) {
			throw new InvalidColumnException();
		}
		$args = [
			'post_type' => $this->getPostType(),
			'post_status' => 'any'
		];

		switch ($column) {
			case 'ID':
				$args[ 'post__in' ] = $ins;
				break;
			case 'parent_id';
				$args[ 'post_parent__in'] = $ins;
				break;
		}
		return get_posts($args);
	}

	/**
	 * @inheritDoc
	 */
	public function findById(int $id): array
	{
		return $this->read($id);
	}

	/** @inheritdoc */
	public function getQueryColumns(): array
	{
		return [
			'ID',
			'title',
			'parent_id'
		];
	}

	/** @inheritdoc */
	public function getPostType(): string
	{
		return $this->postType;
	}
}
