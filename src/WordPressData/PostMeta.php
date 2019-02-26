<?php


namespace calderawp\caldera\DataSource\WordPressData;


use calderawp\caldera\DataSource\Contracts\PostMetaContract;
use calderawp\interop\ArrayLike;

class PostMeta extends ArrayLike implements PostMetaContract
{

	/**
	 * Get one meta key
	 *
	 * @param string $key
	 * @param null $default
	 *
	 * @return mixed|null
	 */
	public function getMeta( string $key, $default = null )
	{
		return $this->offsetExists($key) ? $this->offsetGet($key) : $default;
	}

	/**
	 * Update one meta key
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return PostMeta
	 */
	public function updateMeta(string $key, $value ) : PostMetaContract
	{
		 $this->offsetSet($key,$value);
		return $this;
	}

}
