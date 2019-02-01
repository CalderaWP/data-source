<?php


namespace calderawp\caldera\DataSource\WordPressData;

use calderawp\caldera\DataSource\Contracts\Crud;
use calderawp\caldera\DataSource\Exception;
use calderawp\DB\Exceptions\InvalidColumnException;

class PostType implements Crud
{
	/** @var \WP_Query */
	protected $wpQuery;
	public function __construct(string $postType,\WP_Query $WPQuery)
	{
	}

	/**
	 * @inheritDoc
	 */
	public function create(array $data): int
	{
		$idOrError = wp_insert_post($data);
		if( is_numeric($idOrError)){
			return (int)$idOrError;
		}
		throw new Exception($idOrError->get_error_message(), $idOrError->get_error_code() );
	}

	/**
	 * @inheritDoc
	 */
	public function read(int $id): array
	{
		$post = get_post($id,ARRAY_A);
		if( is_array($post)){
			return $post;
		}
		throw new Exception('Not Found', 404 );
	}

	/**
	 * @inheritDoc
	 */
	public function update(int $id, array $data): array
	{
		$data[ 'ID' ] = $id;
		$idOrError = wp_update_post($data);
		if( is_numeric($idOrError)){
			return $this->read($idOrError);
		}
		throw new Exception($idOrError->get_error_message(), $idOrError->get_error_code() );
	}

	/**
	 * @inheritDoc
	 */
	public function anonymize(int $id, string $column): array
	{
		$post = $this->read($id);
		if( isset( $post[$column])){
			$post[$column] = 'XXXX';
			return $this->update($id,$post);
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

}
