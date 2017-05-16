<?php

use Cart\Support\Storage\Contracts\StorageInterface;
use Cart\Support\Storage\SessionStorage;
use Interop\Container\ContainerInterface;
use Slim\Views\TwigExtension;
use Cart\Basket\Basket;
use Cart\Models\Product;
use Cart\Models\Order;
use Cart\Models\Customer;
use Cart\Models\Address;
use Cart\Models\Payment;

use Cart\Validation\Contracts\ValidationInterface;
use Cart\Validation\Validator;

use function Di\get;

return [
	

	//'router' => get(Slim\Router::class),
	ValidationInterface::class => function(ContainerInterface $c){
		return new Validator;
	},

	 StorageInterface::class => function(ContainerInterface $c){

	 	return new SessionStorage('cart');
	 },

	 Product::class => function(ContainerInterface $c){

	 	return new Product();
	 },

	 Order::class => function(ContainerInterface $c){
	 		return new Order;
	 },

	 Customer::class => function(ContainerInterface $c){
	 		return new Customer;
	 },

	 Address::class => function(ContainerInterface $c){
	 		return new Address;
	 },
	 Payment::class => function(ContainerInterface $c){
	 		return new Payment;
	 },
	 Basket::class => function(ContainerInterface $c){

	 	return new Basket(
	 		$c->get(SessionStorage::class),
	 		$c->get(Product::class)
	 	);
	 },


	 Slim\Views\Twig::class => function(ContainerInterface $c){

	 	$twig = new Slim\Views\Twig(__DIR__ . '/../resources/views',[
	 		'cache' => false
	 	]);

	 	$twig->addExtension(new TwigExtension(
	 		
	 		$c->get('router'),
	 		
	 		$c->get('request')->getUri()
	 	));

	 	$twig->getEnvironment()->addGlobal("basket", $c->get(Basket::class));

	 	return $twig;
	}	
];
