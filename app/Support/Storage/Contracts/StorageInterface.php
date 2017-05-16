<?php 


declare(strict_types=1);

namespace Cart\Support\Storage\Contracts;

/**
* 
*/
interface StorageInterface
{
	
	public function get(int $index);

	public function set($index,$value);

	public function all();

	public function exists(int $index);

	public function unset(int $index): bool;

	public function clear(int $index): void;
	

}