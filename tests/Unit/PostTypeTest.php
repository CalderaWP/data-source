<?php

namespace calderawp\caldera\DataSource\Tests\Unit;

use calderawp\caldera\DataSource\Exception;
use calderawp\caldera\DataSource\Tests\TestCase;
use calderawp\caldera\DataSource\WordPressData\PostType;
use Brain\Monkey;
use Brain\Monkey\Functions;

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
		$wpQuery = \Mockery::mock('\WP_Query');
		Functions\when('wp_insert_post')->justReturn(1 );
		$postType = new PostType('a',$wpQuery);
		$this->assertSame(1, $postType->create([]));

	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::create() */
	public function testCreateThrows()
	{
		$this->expectException(Exception::class);

		$wpQuery = \Mockery::mock('\WP_Query');
		$wpError = \Mockery::mock( '\WP_Error');
		$wpError->shouldReceive( 'get_error_message' )
			->andReturn('Error!');
		$wpError->shouldReceive( 'get_error_code')
			->andReturn( 500 );
		Functions\when('wp_insert_post')->justReturn( $wpError );
		$postType = new PostType('a',$wpQuery);
		$this->assertSame(1, $postType->create([]));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::delete() */
	public function testDelete()
	{
		$wpQuery = \Mockery::mock('\WP_Query');
		Functions\when('wp_delete_post')->justReturn(['post_title' => 'adsasd'] );
		$postType = new PostType('a',$wpQuery);
		$this->assertTrue( $postType->delete(1));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::delete() */
	public function testDeleteFailed()
	{
		$wpQuery = \Mockery::mock('\WP_Query');
		Functions\when('wp_delete_post')->justReturn(false );
		$postType = new PostType('a',$wpQuery);
		$this->assertFalse( $postType->delete(1));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::update() */
	public function testUpdate()
	{
		$expected = ['post_title' => 'adassddf'];
		$wpQuery = \Mockery::mock('\WP_Query');
		Functions\when('wp_update_post')->justReturn(1 );
		Functions\when('get_post')->justReturn($expected );
		$postType = new PostType('a',$wpQuery);
		$this->assertSame( $expected,$postType->update(1,[]));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::anonymize() */
	public function testAnonymize()
	{
		$expected = ['post_title' => 'adassddf'];
		$wpQuery = \Mockery::mock('\WP_Query');
		Functions\when('wp_update_post')->justReturn(1 );
		Functions\when('get_post')->justReturn($expected );
		$postType = new PostType('a',$wpQuery);
		$this->assertSame( $expected,$postType->anonymize(1,'a'));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostType::read() */
	public function testRead()
	{
		$expected = [ 'post_title' => 'pants'];
		$wpQuery = \Mockery::mock('\WP_Query');
		Functions\when('get_post')->justReturn($expected );
		$postType = new PostType('a',$wpQuery);
		$this->assertSame($expected, $postType->read(1));
	}
}
