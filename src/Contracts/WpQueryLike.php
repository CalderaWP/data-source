<?php


namespace calderawp\caldera\DataSource\Contracts;

interface WpQueryLike
{
	/** @return  array */
	public function query($query);
	/** @return  array */
	public function get_posts();
}
