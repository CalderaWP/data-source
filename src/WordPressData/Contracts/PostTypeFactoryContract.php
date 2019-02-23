<?php

namespace calderawp\caldera\DataSource\WordPressData\Contracts;

use calderawp\caldera\DataSource\Exception;
use calderawp\caldera\DataSource\WordPressData\PostType;
use calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable;
use calderawp\interop\Collections\Attributes;

interface PostTypeFactoryContract
{
	/**
	 * Register a WordPress Post type
	 *
	 * @param string $postTypeName
	 * @param array $postTypeArgs
	 *
	 * @return PostType
	 * @throws Exception
	 */
	public function postType(string $postTypeName, array $postTypeArgs = []): PostType;

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
	): PostTypeWithCustomMetaTable;
}
