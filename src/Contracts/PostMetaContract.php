<?php

namespace calderawp\caldera\DataSource\Contracts;

use calderawp\caldera\DataSource\WordPressData\PostMeta;

interface PostMetaContract
{
	/**
	 * Get one meta key
	 *
	 * @param string $key
	 * @param null $default
	 *
	 * @return mixed|null
	 */
	public function getMeta(string $key, $default = null);

	/**
	 * Update one meta key
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return PostMetaContract
	 */
	public function updateMeta(string $key, $value): PostMetaContract;
}
