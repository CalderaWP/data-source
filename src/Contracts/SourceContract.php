<?php


namespace calderawp\caldera\DataSource\Contracts;

interface SourceContract
{


	public function getCrud(): Crud;
	public function getQuery(): Query;
}
