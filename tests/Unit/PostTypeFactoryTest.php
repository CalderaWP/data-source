<?php

namespace calderawp\caldera\DataSource\Tests\Unit;

use calderawp\caldera\DataSource\WordPressData\PostType;
use calderawp\caldera\DataSource\WordPressData\PostTypeFactory;
use calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable;
use calderawp\DB\Factory;
use calderawp\DB\Table;
use calderawp\interop\Attribute;
use calderawp\interop\Collections\Attributes;
use PHPUnit\Framework\TestCase;

class PostTypeFactoryTest extends TestCase
{
	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\PostTypeFactory::postTypeWithMeta()
	 */
	public function testPostTypeWithMeta()
	{
		$data = new \stdClass();
		$postTypeArgs = [ 'labels' => []];
		$register = function ($calledName,$calledArgs) use ($data){
			$data->args = $calledArgs;
			$data->name = $calledName;
		};
		$dbFactory = new Factory();
		$factory = new PostTypeFactory($register,$dbFactory,\Mockery::mock(\wpdb::class ) );

		$attribute  = Attribute::fromArray([
			'name' => 'desc',
			'description' => 'the description',
			'sqlDescriptor' => 'int(11) unsigned NOT NULL AUTO_INCREMENT ',
			'dataType' => 'string',
			'format' => '%s'
		]);
		$idAttribute  = Attribute::fromArray([
			'name' => 'id',
			'description' => 'the primary id',
			'sqlDescriptor' => 'int(11) unsigned NOT NULL AUTO_INCREMENT ',
			'dataType' => 'integer',
			'format' => '%ds'
		]);

		$attributes = (new Attributes())->addAttribute($attribute)->addAttribute($idAttribute);
		$postType = $factory->postTypeWithMeta('the-name', $postTypeArgs,$attributes );
		$this->assertInstanceOf( PostTypeWithCustomMetaTable::class, $postType );
		$this->assertEquals('the-name',$postType->getPostType());
		$this->assertEquals( 'the-name', $data->name );
		$this->assertEquals( $postTypeArgs, $data->args );

	}

	public function test__construct()
	{
		$wpdb = \Mockery::mock(\wpdb::class );
		$register = function (){};
		$dbFactory = \Mockery::mock(Factory::class);
		$factory = new PostTypeFactory($register,$dbFactory,$wpdb );
		$this->assertAttributeEquals( $register, 'registerPostType', $factory );
		$this->assertAttributeEquals( $dbFactory, 'dbFactory', $factory );

	}

	/**
	 * @covers \calderawp\caldera\DataSource\WordPressData\PostTypeFactory::postType()
	 */
	public function testPostType()
	{
		$data = new \stdClass();
		$postTypeArgs = [ 'labels' => []];
		$register = function ($calledName,$calledArgs) use ($data){
			$data->args = $calledArgs;
			$data->name = $calledName;
		};
		$dbFactory = \Mockery::mock(Factory::class);
		$factory = new PostTypeFactory($register,$dbFactory,\Mockery::mock(\wpdb::class ) );
		$postType = $factory->postType('the-name', $postTypeArgs );
		$this->assertInstanceOf( PostType::class, $postType );

		$this->assertEquals('the-name',$postType->getPostType());
		$this->assertEquals( 'the-name', $data->name );
		$this->assertEquals( $postTypeArgs, $data->args );
	}
}
