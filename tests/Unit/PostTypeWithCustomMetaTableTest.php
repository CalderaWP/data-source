<?php

namespace calderawp\caldera\DataSource\Tests\Unit;

use calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable;
use calderawp\DB\Exceptions\InvalidColumnException;
use calderawp\DB\Table;
use PHPUnit\Framework\TestCase;

class PostTypeWithCustomMetaTableTest extends TestCase
{

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable::setMetaTable() */
	public function testSetMetaTable()
	{
		$table = \Mockery::mock(Table::class );
		$postType = new PostTypeWithCustomMetaTable('a');
		$postType->setMetaTable($table);
		$this->assertAttributeEquals($table, 'table', $postType );
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable::findByMetaColumn() */
	public function testFindByMetaColumn()
	{
		$expected = [];
		$table = \Mockery::mock(Table::class );
		$table
			->shouldReceive( 'findWhere' )
			->andReturn( $expected );
		$postType = new PostTypeWithCustomMetaTable('a');
		$postType->setMetaTable($table);
		$this->assertSame($expected, $postType->getMetaRow(1));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable::findByMetaColumn() */
	public function testFindByMetaColumnThrows()
	{
		$this->expectException(InvalidColumnException::class);
		$table = \Mockery::mock(Table::class );
		$table
			->shouldReceive( 'isAllowedKey' )
			->andReturn( false );
		$postType = new PostTypeWithCustomMetaTable('a');
		$postType->setMetaTable($table);
		$postType->findByMetaColumn('noms', 'aa' );

	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable::getMetaValue() */
	public function testGetMetaValue()
	{
		$expected = [
			'arms' => 77
		];
		$table = \Mockery::mock(Table::class );
		$table
			->shouldReceive( 'findWhere' )
			->andReturn( $expected );
		$postType = new PostTypeWithCustomMetaTable('a');
		$postType->setMetaTable($table);
		$this->assertSame(77,$postType->getMetaValue(1, 'arms'));
	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable::getMetaTable() */
	public function testGetMetaTable()
	{$table = \Mockery::mock(Table::class );
		$postType = new PostTypeWithCustomMetaTable('a');
		$postType->setMetaTable($table);
		$this->assertSame($table, $postType->getMetaTable());

	}

	/** @covers \calderawp\caldera\DataSource\WordPressData\PostTypeWithCustomMetaTable::getMetaRow() */
	public function testGetMetaRow()
	{
		$expected = [];
		$table = \Mockery::mock(Table::class );
		$table
			->shouldReceive( 'findWhere' )
			->andReturn( $expected );
		$postType = new PostTypeWithCustomMetaTable('a');
		$postType->setMetaTable($table);
		$this->assertSame($expected,$postType->getMetaRow(1));
	}
}
