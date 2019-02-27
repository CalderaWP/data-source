<?php

namespace calderawp\caldera\DataSource\WordPressData\Contracts;

use calderawp\caldera\DataSource\WordPressData\WordPressPost;
use calderawp\interop\Contracts\Arrayable;

interface PostContract extends Arrayable
{
	/**
	 * Get post Id
	 *
	 * @return int
	 */
	public function getId(): int;

	/**
	 * Set post Id
	 *
	 * @param int $id
	 *
	 * @return WordPressPost
	 */
	public function setId(int $id): PostContract;

	/**
	 * Get post title
	 *
	 * @return string
	 */
	public function getTitle(): string;

	/**
	 * Set post title
	 *
	 * @param string $title
	 *
	 * @return WordPressPost
	 */
	public function setTitle(string $title): PostContract;

	/**
	 * Set post except
	 *
	 * @param string $excerpt
	 *
	 * @return WordPressPost
	 */
	public function setExcerpt(string $excerpt): PostContract;

	/**
	 * Get post excerpt
	 *
	 * @return string
	 */
	public function getExcerpt(): string;

	/**
	 * Set post content
	 *
	 * @param string $content
	 *
	 * @return WordPressPost
	 */
	public function setContent(string $content): PostContract;

	/**
	 * Get post content
	 *
	 * @return string
	 */
	public function getContent(): string;

	/**
	 * Set the GUID
	 *
	 * @param string $guid
	 *
	 * @return WordPressPost
	 */
	public function setGuid(string $guid): PostContract;

	/**
	 * Get the GUID
	 *
	 * @param string $guid
	 *
	 * @return WordPressPost
	 */
	public function getGuid(): string;

	public function getAllowedProperties(): array;
}
