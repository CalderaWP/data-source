<?php

namespace calderawp\caldera\DataSource\Tests\Unit;

use calderawp\caldera\DataSource\CalderaDataSource;
use calderawp\caldera\DataSource\Tests\TestCase;
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
	 * @covers \calderawp\caldera\DataSource\WordPressData\WordPressPost::toArray()
	 */
	public function testToFromArray()
	{
		$data = $this->getHelloWorld();
		$post = WordPressPost::fromArray($data);
		$this->assertEquals( $data, $post->toArray());
	}


	protected function getHelloWorld()
	{
		return [
			'id' => 1,
			'date' => '2018-12-28T14:55:53',
			'date_gmt' => '2018-12-28T14:55:53',
			'guid' =>
				array (
					'rendered' => 'https://caldera.lndo.site/?p=1',
				),
			'modified' => '2018-12-30T03:08:35',
			'modified_gmt' => '2018-12-30T03:08:35',
			'slug' => 'hello-world',
			'status' => 'publish',
			'type' => 'post',
			'link' => 'https://caldera.lndo.site/hello-world/',
			'title' =>
				array (
					'rendered' => 'Hello world!',
				),
			'content' =>
				array (
					'rendered' => '
<p >Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>
',
					'protected' => false,
				),
			'excerpt' =>
				array (
					'rendered' => '<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>
',
					'protected' => false,
				),
			'author' => 1,
			'featured_media' => 0,
			'comment_status' => 'open',
			'ping_status' => 'open',
			'sticky' => false,
			'template' => '',
			'format' => 'standard',
			'meta' =>
				array (
				),
			'categories' =>
				array (
					0 => 1,
				),
			'tags' =>
				array (
				),
		];
	}
}
