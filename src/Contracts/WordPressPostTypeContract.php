<?php


namespace calderawp\caldera\DataSource\Contracts;

use calderawp\caldera\DataSource\WordPressData\Contracts\PostContract as Post;
use calderawp\caldera\DataSource\WordPressData\PostMeta;

interface WordPressPostTypeContract extends SourceContract
{

	/**
	 * Get array of columns to query by
	 *
	 * @return array
	 */
	public function getQueryColumns(): array;


	public function getPostType() : string;

	/**
	 * Convert database result to Post object
	 *
	 * @param array $data
	 * @param PostMeta|null $meta
	 *
	 * @return Post
	 */
	public function resultToPost(array $data, ?PostMeta $meta) : Post;
}
