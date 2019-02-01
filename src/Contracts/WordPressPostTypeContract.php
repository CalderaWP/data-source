<?php


namespace calderawp\caldera\DataSource\Contracts;

interface WordPressPostTypeContract extends SourceContract
{

	/**
	 * Get array of columns to query by
	 *
	 * @return array
	 */
	public function getQueryColumns(): array;


	public function getPostType() : string;
}
