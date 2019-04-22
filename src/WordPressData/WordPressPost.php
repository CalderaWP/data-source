<?php


namespace calderawp\caldera\DataSource\WordPressData;

use calderawp\caldera\DataSource\Contracts\PostMetaContract as PostMeta;
use calderawp\caldera\DataSource\WordPressData\Contracts\PostContract as Post;
use calderawp\caldera\Messaging\Traits\SimpleRepository;

class WordPressPost implements Post
{

	use SimpleRepository;

	/**
	 * Get post Id
	 *
	 * @return int
	 */
	public function getId(): int
	{
		return (int) $this->get('id', 0);
	}

	/**
	 * Set post Id
	 * @param int $id
	 *
	 * @return WordPressPost
	 */
	public function setId(int $id): Post
	{
		return $this->set('id', $id);
	}

	/**
	 * Get post title
	 *
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->getItemThatIsRepresentedWithArray('title')['rendered'];
	}

	/**
	 * Set post title
	 *
	 * @param string $title
	 *
	 * @return WordPressPost
	 */
	public function setTitle(string $title): Post
	{
		return $this->setValueRepresentedWithArray($title, 'title');
	}

	/**
	 * Set post except
	 *
	 * @param string $excerpt
	 *
	 * @return WordPressPost
	 */
	public function setExcerpt(string $excerpt): Post
	{
		return $this->setValueRepresentedWithArray($excerpt, 'excerpt');
	}

	/**
	 * Get post excerpt
	 *
	 * @return string
	 */
	public function getExcerpt(): string
	{
		return $this->getItemThatIsRepresentedWithArray('excerpt')['rendered'];
	}

	/**
	 * Set post content
	 *
	 * @param string $content
	 *
	 * @return WordPressPost
	 */
	public function setContent(string $content): Post
	{
		return $this->setValueRepresentedWithArray($content, 'content');
	}

	/**
	 * Get post content
	 *
	 * @return string
	 */
	public function getContent(): string
	{
		return $this->getItemThatIsRepresentedWithArray('content')['rendered'];
	}

	/**
	 * Set the GUID
	 *
	 * @param string $guid
	 *
	 * @return WordPressPost
	 */
	public function setGuid(string $guid): Post
	{
		return $this->setValueRepresentedWithArray($guid, 'guid');
	}

	/**
	 * Get the GUID
	 *
	 * @param string $guid
	 *
	 * @return WordPressPost
	 */
	public function getGuid(): string
	{
		return $this->getItemThatIsRepresentedWithArray('guid')['rendered'];
	}

	/**
	 * Set all post meta
	 *
	 * @param PostMeta $meta
	 *
	 * @return Post
	 */
	public function setMeta(PostMeta $meta) : Post
	{
		$meta->updateMeta('post_id', $this->getId());
		return $this->set('meta', $meta);
	}

	/**
	 * Get a post meta value
	 *
	 * @param string $key
	 * @param null|mixed $default
	 *
	 * @return mixed|null
	 */
	public function getMetaValue(string  $key, $default = null)
	{
		return $this->getMeta()->getMeta($key, $default);
	}

	/**
	 * Set a post meta value
	 *
	 * @param string $key
	 * @param $value
	 *
	 * @return Post
	 */
	public function setMetaValue(string $key, $value): Post
	{
		return $this->setMeta(
			$this->getMeta()->updateMeta($key, $value)
		);
	}

	/**
	 * Get all post meta
	 *
	 * @return PostMeta
	 */
	public function getMeta(): PostMeta
	{
		return $this->get('meta', new \calderawp\caldera\DataSource\WordPressData\PostMeta(['post_id' => $this->getId() ]));
	}


	public function getAllowedProperties(): array
	{
		return [
			'id',
			'date',
			'date_gmt',
			'guid',
			'modified',
			'modified_gmt',
			'slug',
			'status',
			'type',
			'title',
			'content',
			'excerpt',
			'author',
			'featured_media',
			'comment_status',
			'ping_status',
			'sticky',
			'template',
			'format',
			'meta',
			'categories',
			'tags',
			'link',

		];
	}

	/** @inheritdoc */
	public function toArray(): array
	{
		$array = [];
		foreach ($this->getAllowedProperties() as $property) {
			if ($this->has($property)) {
				$value = $this->get($property);
				if (is_object($value) && is_callable([$value, 'toArray'])) {
					$value = $value->toArray();
				}
				$array[ $property ] = $value;
			}
		}
		if (! is_array($array['meta'])) {
			$array['meta'] = [];
		}
		$array['meta']['post_id'] = $this->getId();
		return $array;
	}

	public static function fromArray(array $items = []): WordPressPost
	{
		$obj = new static;
		foreach ($items as $key => $item) {
			if (in_array($key, [
				'title',
				'content',
				'excerpt',
				'guid',
			])) {
				if (is_array($item)) {
					$obj->set($key, $item);
				} else {
					$obj->set($key, [
						'rendered' => $item,
					]);
				}
			} else {
				if ($obj->allowed($key)) {
					$obj->set($key, $item);
				}
			}
		}
		return $obj;
	}

	/**
	 * @param $key
	 *
	 * @return array
	 */
	private function getItemThatIsRepresentedWithArray($key) : array
	{
		$item = $this->get($key, [
			'rendered' => '',
		]);
		if (!isset($item[ 'rendered' ])) {
			$this->set($key, [
				'rendered' => '',
			]);
			$item = $this->get($key);
		}
		return $item;
	}

	/**
	 * @param string $value
	 * @param $key
	 *
	 * @return  $this
	 */
	private function setValueRepresentedWithArray(string $value, $key): WordPressPost
	{
		$item = $this->getItemThatIsRepresentedWithArray($key);
		$item[ 'rendered' ] = $value;
		$this->set($key, $item);
		return $this;
	}
}
