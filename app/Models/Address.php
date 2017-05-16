<?php  

declare(strict_types=1);

namespace Cart\Models;


use Cart\Models\Order;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class Address extends Model
{
	
	protected $fillable = [
		'address1',
		'address2',
		'city',
		'postal_code'
	];
	

	public function order()
	{
		return $this->hasMany(Order::class);
	}
}


