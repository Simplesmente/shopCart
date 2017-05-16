<?php  

declare(strict_types=1);

namespace Cart\Models;


use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Payment extends Model
{
	
	protected $fillable = [
		'failed',
		'transaction_id'
	];
	
}


