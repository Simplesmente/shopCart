<?php 

declare(strict_types=1);

namespace Cart\Controllers;

use Slim\Router;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Cart\Models\Product;

/**
* 		
*/
class ProductController
{
	/**
	 * [$view description]
	 * @var [Object Slim\Views\Twig ]
	 */
	private $view;

	/**
	 * [$product description]
	 * @var [Object Cart\Models\Product]
	 */
	private $product;


	/**
	 * [$router description]
	 * @var [Object Slim\Router]
	 */
	private $router;

	public function __construct(Twig $view, Router $router) 
	{
		$this->view = $view;

		$this->product = new Product;

		$this->router = $router;
	}

	public function get( string $slug, Request $request, Response $response)
	{
		$product = $this->product->where('slug',$slug)->first();
		//echo '<pre>';
		//var_dump($product->hasLowStock());die;
		if(!$product){

			return $response->withRedirect( $this->router->pathFor('home') );
		}

		return $this->view->render($response, 'products/product.twig',['product' => $product ]);
	}
}