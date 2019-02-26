<?php

namespace calderawp\caldera\DataSource\Tests\Unit;

use calderawp\caldera\DataSource\CalderaDataSource;
use calderawp\caldera\DataSource\Tests\TestCase;
use calderawp\caldera\DataSource\WordPressData\PostMeta;
use calderawp\caldera\DataSource\WordPressData\PostType;
use calderawp\caldera\DataSource\WordPressData\WordPressPost;

class WpPostTest extends TestCase
{


	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::getId()
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::setId()
	 */
	public function testGetSetId()
	{
		$post = new WordPressPost();
		$post->setId(7);
		$this->assertSame(7, $post->getId());
	}

	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::setTitle()
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::getTitle()
	 */
	public function testGetSetTitle()
	{
		$title = '<h1>h6</h1>';
		$post = new WordPressPost();
		$post->setTitle($title);
		$this->assertSame($title, $post->getTitle($title));
	}

	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::setContent()
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::getContent()
	 */
	public function testGetSetContent()
	{
		$content = '<h1>h6</h1>';
		$post = new WordPressPost();
		$post->setContent($content);
		$this->assertSame($content, $post->getContent($content));
		$content = 'new content';
		$post->setContent($content);
		$this->assertSame($content, $post->getContent($content));

	}


	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::setExcerpt()
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::getExcerpt()
	 */
	public function testGetSetExcerpt()
	{
		$content = '<h1>h6</h1>';
		$post = new WordPressPost();
		$post->setExcerpt($content);
		$this->assertSame($content, $post->getExcerpt($content));
		$content = 'new execprt';
		$post->setExcerpt($content);
		$this->assertSame($content, $post->getExcerpt($content));

	}

	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::setGuid()
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::getGuid()
	 */
	public function testGetSetGuid()
	{
		$content = 'https://caldera.lndo.site/?p=1';
		$post = new WordPressPost();
		$post->setGuid($content);
		$this->assertSame($content, $post->getGuid($content));


	}

	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::getMeta()
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::setMeta()
	 */
	public function testGetSetMeta()
	{
		$meta = new PostMeta();
		$meta[ 'r22' ] = 'type1';
		$post = new WordPressPost();
		$post->setMeta($meta);
		$this->assertEquals($meta, $post->getMeta());
		$this->assertEquals('type1', $post->getMeta()[ 'r22' ]);
	}

	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::getMeta()
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::setMeta()
	 */
	public function testGetSetMetaValues()
	{

		$post = new WordPressPost();
		$post->setMetaValue('r34', 'v1');
		$this->assertEquals('v1', $post->getMetaValue('r34', 'DO NOT USE ME, I AM SET!'));
		$this->assertEquals('v22', $post->getMetaValue('r344444', 'v22'));
	}

	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::toArray()
	 */
	public function testToFromArray()
	{
		$data = $this->getHelloWorld();
		$post = WordPressPost::fromArray($data);
		$data[ 'meta' ] = [
			'post_id' => $data['id']
		];
		$this->assertEquals($data, $post->toArray());
	}

	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::toArray()
	 */
	public function testMetaToArray()
	{
		$post = new WordPressPost();
		$post->setId(12);
		$post->setMetaValue('r34', 'v1');
		$array = $post->toArray();
		$this->assertEquals([
			'r34' => 'v1',
			'post_id' => 12,
		], $array[ 'meta' ]);
	}
	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::fromArray()
	 */
	public function testMetaFromArray()
	{
		$post = WordPressPost::fromArray( ['id' => 12, 'meta' => [ 'r34' => 'v1']]);
		$array = $post->toArray();
		$this->assertEquals([
			'r34' => 'v1',
			'post_id' => 12,
		], $array[ 'meta' ]);
	}

	public function testResultToPost()
	{
		$data = $this->getHelloWorld();
		$postType = new PostType('a');
		$post = $postType->resultToPost($data, new PostMeta());
		$value = 'c4567';

		$meta = new PostMeta(['meta_one' => $value]);
		$post = WordPressPost::fromArray($data, $meta);
		$this->assertEquals($post->getExcerpt(), ($postType->resultToPost($data,new PostMeta(['post_id' => 1])))->getExcerpt());
	}


	protected function getHelloWorld()
	{
		return [
			'id' => 1,
			'date' => '2018-12-28T14:55:53',
			'date_gmt' => '2018-12-28T14:55:53',
			'guid' =>
				[
					'rendered' => 'https://caldera.lndo.site/?p=1',
				],
			'modified' => '2018-12-30T03:08:35',
			'modified_gmt' => '2018-12-30T03:08:35',
			'slug' => 'hello-world',
			'status' => 'publish',
			'type' => 'post',
			'link' => 'https://caldera.lndo.site/hello-world/',
			'title' =>
				[
					'rendered' => 'Hello world!',
				],
			'content' =>
				[
					'rendered' => '
<p >Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>
',
					'protected' => false,
				],
			'excerpt' =>
				[
					'rendered' => '<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>
',
					'protected' => false,
				],
			'author' => 1,
			'featured_media' => 0,
			'comment_status' => 'open',
			'ping_status' => 'open',
			'sticky' => false,
			'template' => '',
			'format' => 'standard',
			'meta' =>
				[
				],
			'categories' =>
				[
					0 => 1,
				],
			'tags' =>
				[
				],
		];
	}
}
