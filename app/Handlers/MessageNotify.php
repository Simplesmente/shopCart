<?php 

namespace Cart\Handlers;

use Cart\Handlers\Contracts\HandlerInterface;

use Cart\Models\Message;
/**
* 		
*/
class MessageNotify implements HandlerInterface
{
	
	public function handler($event)
	{

		$_SESSION['messages'] = ' Your Order was created successfully!';

		Message::create([
			'message' =>' Your Order was created successfully!'

		]);
	}
}