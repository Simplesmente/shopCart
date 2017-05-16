<?php 

declare(strict_types=1);

namespace Cart\Middleware;

use Slim\Views\Twig;

/**
* 
*/
class MessagesNotifyMiddleware 
{
	protected $view;

	public function __construct(Twig $view)
	{
		$this->view = $view;
	}
	
	public function __invoke($request, $response, $next)
	{
		if(isset($_SESSION['messages'])){

			$this->view->getEnvironment()->addGlobal('messages', $_SESSION['messages']);

			unset($_SESSION['messages']);
		}

		$response = $next($request, $response);

		return $response;
	}
}