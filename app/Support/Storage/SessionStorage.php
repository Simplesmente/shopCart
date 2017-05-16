<?php 


declare(strict_types=1);

namespace Cart\Support\Storage;

use Cart\Support\Storage\Contracts\StorageInterface;

use Countable;

/**
* 			
*/
class SessionStorage implements StorageInterface, Countable
{
	/**
	 * [$bucket description]
	 * @var [string]
	 */
	protected $bucket;


	public function __construct(string $bucket = 'defaut')
	{
		if ( !isset($_SESSION[$bucket]) ){

			$_SESSION[$bucket] = [];
		}

		$this->bucket = $bucket;
	}

	public function get(int $index)
	{
		if( !$this->exists($index)){
			return null;
		}

		return $_SESSION[$this->bucket][$index];
	}

	public function set($index, $value)
	{
		$_SESSION[$this->bucket][$index] = $value;
	}

	public function all()
	{
		return $_SESSION[$this->bucket];
	}

	public function exists(int $index)
	{
		return isset($_SESSION[$this->bucket][$index]);
	}

	public function unset(int $index): bool
	{
		if( $this->exists($index)){

			unset($_SESSION[$this->bucket][$index]);

			return true;
		}

		return false;

	}

	public function clear(int $index): void
	{
		unset($_SESSION[$this->bucket]);
	}

	public function count()
	{
		return count($this->all());
	}
}
