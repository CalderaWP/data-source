<?php


namespace calderawp\caldera\DataSource\WordPressData;

use calderawp\caldera\DataSource\Exception;
use calderawp\DB\Table;
use calderawp\DB\Factory as DbFactory;
use calderawp\interop\Attribute;
use calderawp\interop\Collections\Attributes;

class PostTypeFactory
{

	/** @var DbFactory */
	protected $dbFactory;
	protected $registerPostType;
	protected $wpdb;

	/**
	 * Factory constructor.
	 *
	 * @param callable $registerPostType Should be register_post_type()
	 */
	public function __construct(callable $registerPostType, DbFactory $dbFactory, \wpdb $wpdb)
	{
		$this->registerPostType = $registerPostType;
		$this->dbFactory = $dbFactory;
		$this->wpdb = $wpdb;
	}

	/**
	 * Register a WordPress Post type
	 *
	 * @param string $postTypeName
	 * @param array $postTypeArgs
	 *
	 * @return PostType
	 * @throws Exception
	 */
	public function postType(string $postTypeName, array $postTypeArgs = []): PostType
	{

		$this->registerPostType($postTypeName, $postTypeArgs);
		return new PostType($postTypeName);

	}

	/**
	 * Register a WordPress post type with custom meta table
	 *
	 * @param string $postTypeName
	 * @param array $postTypeArgs
	 * @param Attributes $attributes
	 * @param string $primaryKey
	 * @param array $indexes
	 *
	 * @return PostTypeWithCustomMetaTable
	 * @throws Exception
	 */
	public function postTypeWithMeta(
		string $postTypeName,
		array $postTypeArgs,
		Attributes $attributes,
		string $primaryKey = 'id',
		array $indexes = []
	): PostTypeWithCustomMetaTable {
		$this->registerPostType($postTypeName,$postTypeArgs);
		$tableName = $postTypeName . '_' . 'meta';
		$tableSchema = $this->dbFactory->tableSchema($attributes->toArray(), $tableName, $primaryKey, $indexes);
		$metaTable = $this->dbFactory->wordPressDatabaseTable($tableSchema,$this->wpdb);
		$postType = new PostTypeWithCustomMetaTable($postTypeName);
		$postType->setMetaTable($metaTable);
		return $postType;

	}

	/**
	 * @param string $postTypeName
	 * @param array $postTypeArgs
	 *
	 * @throws Exception
	 */
	private function registerPostType(string $postTypeName, array $postTypeArgs): void
	{
		$postTypeObject = call_user_func($this->registerPostType, $postTypeName, $postTypeArgs);
		if ($postTypeObject instanceof \WP_Error) {
			throw new Exception(sprintf('Could not register post type %s', $postTypeName));
		}
	}
}
