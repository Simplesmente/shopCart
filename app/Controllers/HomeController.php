<?php 

declare(strict_types=1);

namespace Cart\Controllers;

use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Cart\Models\Product;;

/**
* 		
*/
class HomeController
{
	
	public function index(Request $request, Response $response, Twig $view)
	{

		$product = new Product;

		return $view->render($response, 'home.twig',['products' => $product->get() ]);
	}
}