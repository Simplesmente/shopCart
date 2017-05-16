<?php 


declare(strict_types=1);

namespace Cart\Basket\Exceptions;

use Exception;

/**
* 
*/
class QuantityExceededException extends Exception
{
	protected $message = "You have added the maximum stock for this item.";
}




