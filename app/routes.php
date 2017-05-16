<?php 

$app->get('/',[Cart\Controllers\HomeController::class,'index'])->setName('home');

$app->get('/products/{slug}',[Cart\Controllers\ProductController::class,'get'])->setName('product.get');
$app->get('/cart',[Cart\Controllers\CartController::class,'index'])->setName('cart.index');

$app->get('/cart/add/{slug}/{quantity}',[Cart\Controllers\CartController::class,'add'])
																			->setName('cart.add');

$app->post('/cart/update/{slug}',[Cart\Controllers\CartController::class,'update'])
																			->setName('cart.update');
$app->get('/order',[Cart\Controllers\OrderController::class,'index'])->setName('order.index');

$app->post('/order/create',[Cart\Controllers\OrderController::class,'create'])->setName('order.create');