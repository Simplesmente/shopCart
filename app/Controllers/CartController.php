<?php 

declare(strict_types=1);

namespace Cart\Controllers;

use Slim\Router;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Cart\Basket\Exceptions\QuantityExceedException;
use Cart\Models\Product;
use Cart\Basket\Basket;

/**
* 		
*/
class CartController
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

	/**
	 * [$basket description]
	 * @var [Object Cart\Basket\Basket]
	 */
	private $basket;

	public function __construct(Twig $view, Router $router, Basket $basket) 
	{
		$this->view = $view;

		$this->product = new Product;

		$this->router = $router;

		$this->basket = $basket;


	}

	public function index( Request $request, Response $response)
	{
		$this->basket->refresh();

		return $this->view->render($response, 'cart/index.twig');
	}

	public function add(string $slug, int $quantity, Request $request, Response $response )
	{
		
		$product = $this->findItemOrRedirect($slug);

		try {
			
			$this->basket->add($product, $quantity);

		} catch (QuantityExceedException $e) {
			//
		}

		return $response->withRedirect( $this->router->pathFor('cart.index') );
	}

	public function update(string $slug, Request $request, Response $response )
	{
		$product = $this->findItemOrRedirect($slug);


		try {
			
			$this->basket->update($product, (int) $request->getParam('quantity') );

		} catch (QuantityExceedException $e) {
			//
		}

		return $response->withRedirect( $this->router->pathFor('cart.index') );


	}

	private function findItemOrRedirect(string $slug)
	{
		
		$product = null;

		$product = $this->product->where('slug',$slug)->first();

		if( ! product ){

			return $response->withRedirect($route->pathFor('home'));
		}

		return $product;

	}
}