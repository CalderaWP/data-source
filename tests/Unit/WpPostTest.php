<?php

namespace calderawp\caldera\DataSource\Tests\Unit;

use calderawp\caldera\DataSource\CalderaDataSource;
use calderawp\caldera\DataSource\Tests\TestCase;
use calderawp\caldera\DataSource\WordPressData\WordPressPost;
class WpPostTest extends TestCase
{



	public function testToFromArray()
	{
		$data = $this->getHelloWorld();
		$post = WordPressPost::fromArray($data);
		$this->assertSame( $data, $post->toArray());
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
