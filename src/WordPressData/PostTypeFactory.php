<?php


namespace calderawp\caldera\DataSource\WordPressData;

use calderawp\caldera\DataSource\Exception;
use calderawp\caldera\DataSource\WordPressData\Contracts\PostTypeFactoryContract;
use calderawp\DB\Table;
use calderawp\DB\Factory as DbFactory;
use calderawp\interop\Attribute;
use calderawp\interop\Collections\Attributes;

class PostTypeFactory implements PostTypeFactoryContract
{

	/** @var DbFactory */
	protected $dbFactory;
	protected $registerPostType;
	protected $registerMeta;
	protected $wpdb;

	/**
	 * Factory constructor.
	 *
	 * @param callable $registerPostType Should be register_post_type()
	 */
	public function __construct(callable $registerPostType, callable $registerMeta, DbFactory $dbFactory, \wpdb $wpdb)
	{
		$this->registerPostType = $registerPostType;
		$this->registerMeta = $registerMeta;
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
		array $indexes = ['post_id']
	): PostTypeWithCustomMetaTable {
		$postIdAttribute = Attribute::fromArray([
			'name' => 'post_id',
			'type' => 'integer',
			'required' => true,
			'description' => 'Identifier for post',
			'sqlDescriptor' => 'int(11) unsigned NOT NULL',
		]);

		$this->registerPostType($postTypeName, $postTypeArgs);
		$tableName = $postTypeName . '_' . 'meta';

		foreach ($attributes->toArray() as $attribute) {
			call_user_func($this->registerMeta, $postTypeName, Attribute::fromArray($attribute));
		}
		$attributes->addAttribute($postIdAttribute);

		$tableSchema = $this->dbFactory->tableSchema($attributes->toArray(), $tableName, $primaryKey, $indexes);
		$metaTable = $this->dbFactory->wordPressDatabaseTable($tableSchema, $this->wpdb);
		$postType = new PostTypeWithCustomMetaTable($postTypeName);
		$postType->setMetaTable($metaTable);
		return $postType;
	}


	protected function postTypeArgs(array $args): array
	{
		return array_merge([
			'show_in_rest' => true,
			'labels' => [],
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => false,
			'query_var' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
		], $args);
	}

	/**
	 * @param string $postTypeName
	 * @param array $postTypeArgs
	 *
	 * @throws Exception
	 */
	private function registerPostType(string $postTypeName, array $postTypeArgs): void
	{
		$postTypeObject = call_user_func($this->registerPostType, $postTypeName, $this->postTypeArgs($postTypeArgs));
		if ($postTypeObject instanceof \WP_Error) {
			throw new Exception(sprintf('Could not register post type %s', $postTypeName));
		}
	}
}
