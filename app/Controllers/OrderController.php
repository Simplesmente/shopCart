<?php 

declare(strict_types=1);

namespace Cart\Controllers;


use Slim\Router;
use Slim\Views\Twig;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Cart\Validation\Contracts\ValidationInterface;
use Cart\Validation\Forms\OrderForm;
use Cart\Basket\Basket;

use Cart\Models\Customer;
use Cart\Models\Address;

//use Cart\Handlers\EmptyBasket;

/**
* 		
*/
class OrderController
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


	/**
	 * [$validator description]
	 * @var [Object Cart\Validation\Contracts\ValidationInterface]
	 */
	private $validator;

	public function __construct(Twig $view, Router $router, Basket $basket, ValidationInterface $validator) 
	{
		$this->view = $view;

		$this->router = $router;

		$this->basket = $basket;

		$this->validator = $validator;


	}

	public function index(Request $request, Response $response, Twig $view)
	{

		$this->basket->refresh();

		if( !$this->basket->subTotal() ){

			return $response->withRedirect($this->router->pathFor('home'));
		}

		return $view->render($response, 'order/index.twig');
	}

	public function create(Request $request, Response $response, Customer $customer,Address $address)
	{
		$this->basket->refresh();


		$hash = null;

		if( !$this->basket->subTotal() ){
			return $response->withRedirect($this->router->pathFor('cart.index'));
		}

		$this->validator->validate($request, OrderForm::rules());
		

		// if( !$this->validator->fails() ){
			
		// 	return $response->withRedirect($this->router->pathFor('order.index'));
		// }

		$hash = bin2hex(random_bytes(32));

		$customer = $customer->firstOrCreate([

			'email' => $request->getParam('email'),
			'name' => $request->getParam('name')
		]);

		$address = $address->firstOrCreate([
			'address1' => $request->getParam('address1'),
			'address2' => $request->getParam('address2'),
			'city' => $request->getParam('city'),
			'postal_code' => $request->getParam('postal_code'),
		]);

		$order = $customer->orders()->create([
			'hash' => $hash,
			'paid' => false,
			'total' => $this->basket->subTotal() + 5,
			'address_id' => $address->id
		]);

		$order->products()->saveMany(
			$this->basket->all(),
			$this->getQuantities($this->basket->all())
		);

		// process any gateway of payment here!
		// 
		// 
		// 
		

		$event = new \Cart\Events\OrderWasCreated();

		$event->attach([
			new \Cart\Handlers\EmptyBasket,
			new \Cart\Handlers\MessageNotify,
		]);


		$event->dispatch();

	}

	protected function getQuantities($items)
	{
		$quantities = [];

		foreach ($items as $item) {
			$quantities[] = [ 'quantity' => $item->quantity ];
		}

		return $quantities;
	}
}