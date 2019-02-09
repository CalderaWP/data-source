<?php

namespace calderawp\caldera\DataSource\Tests\Unit;

use calderawp\caldera\DataSource\Exception;
use calderawp\caldera\DataSource\Tests\TestCase;
use calderawp\caldera\DataSource\WordPressData\PostType;
use Brain\Monkey;
use Brain\Monkey\Functions;
use calderawp\DB\Exceptions\InvalidColumnException;

class PostTypeTest extends TestCase
{

	protected function tearDown()
	{
		Monkey\tearDown();
		parent::tearDown();
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::create() */
	public function testCreate()
	{
		Functions\when('wp_insert_post')->justReturn(1);
		$postType = new PostType('a');
		$this->assertSame(1, $postType->create([]));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::create() */
	public function testCreateThrows()
	{
		$this->expectException(Exception::class);

		$wpError = \Mockery::mock('\WP_Error');
		$wpError->shouldReceive('get_error_message')
			->andReturn('Error!');
		$wpError->shouldReceive('get_error_code')
			->andReturn(500);
		Functions\when('wp_insert_post')->justReturn($wpError);
		$postType = new PostType('a');
		$this->assertSame(1, $postType->create([]));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::delete() */
	public function testDelete()
	{
		$wpQuery = \Mockery::mock('\WP_Query');
		Functions\when('wp_delete_post')->justReturn(['post_title' => 'adsasd']);
		$postType = new PostType('a', $wpQuery);
		$this->assertTrue($postType->delete(1));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::delete() */
	public function testDeleteFailed()
	{
		Functions\when('wp_delete_post')->justReturn(false);
		$postType = new PostType('a');
		$this->assertFalse($postType->delete(1));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::update() */
	public function testUpdate()
	{
		$expected = ['post_title' => 'adassddf'];
		Functions\when('wp_update_post')->justReturn(1);
		Functions\when('get_post')->justReturn($expected);
		$postType = new PostType('a');
		$this->assertSame($expected, $postType->update(1, []));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::anonymize() */
	public function testAnonymize()
	{
		$expected = ['post_title' => 'adassddf'];
		Functions\when('wp_update_post')->justReturn(1);
		Functions\when('get_post')->justReturn($expected);
		$postType = new PostType('a');
		$this->assertSame($expected, $postType->anonymize(1, 'a'));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::read() */
	public function testRead()
	{
		$expected = ['post_title' => 'pants'];
		Functions\when('get_post')->justReturn($expected);
		$postType = new PostType('a');
		$this->assertSame($expected, $postType->read(1));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::findById() */
	public function testFindById()
	{
		$expected = ['post_title' => 'pants'];
		Functions\when('get_post')->justReturn($expected);
		$postType = new PostType('a');
		$this->assertSame($expected, $postType->findById(1));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::findWhere() */
	public function testFindWhereTitle()
	{
		$expected = [['post_title' => 'pants'], ['post_title' => 'post2']];
		$title = 'the title';
		Functions\when('get_posts')->justReturn($expected);

		$postType = new PostType('a');
		$this->assertSame($expected, $postType->findWhere('ID', $title));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::findWhere() */
	public function testFindWhereId()
	{
		$expected = [['post_title' => 'pants'], ['post_title' => 'post2']];
		Functions\expect('get_posts')
			->once()
			->with(['post_type' => 'a', 'p' => 1])
			->andReturn($expected);
		$postType = new PostType('a');
		$this->assertSame($expected, $postType->findWhere('ID', 1));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::findWhere() */
	public function testFindWhereParent()
	{
		$expected = [['post_title' => 'pants'], ['post_title' => 'post2']];
		Functions\when('get_posts')->justReturn($expected);

		$postType = new PostType('a');
		$this->assertSame($expected, $postType->findWhere('parent_id', 1));
	}


	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::findWhere() */
	public function testFindWhereThrows()
	{
		$this->expectException(InvalidColumnException::class);

		$postType = new PostType('a');
		$postType->findWhere('rando', 1);
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::findIn() */
	public function testFindInId()
	{
		$expected = [['post_title' => 'pants'], ['post_title' => 'post2']];
		Functions\when('get_posts')->justReturn($expected);

		$postType = new PostType('a');
		$this->assertSame($expected, $postType->findIn([1,2], 'ID'));
	}
}
