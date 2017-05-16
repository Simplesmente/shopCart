<?php  

declare(strict_types=1);

namespace Cart\Models;


use Cart\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Message extends Model
{
	public $timestamps = false;

	protected $fillable = ['message'];
	
}


