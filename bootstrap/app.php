<?php 

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\View\Twig;

$app = new Cart\App;

$container = $app->getContainer();

$capsule = new Illuminate\Database\Capsule\Manager;

$capsule->addConnection([

	'driver' => 'mysql',
	'host'   => 'localhost',
	'database' => 'shop_cart',
	'username' => 'root',
	'password' => '',
	'charset'  => 'utf8',
	'collation' => 'utf8_unicode_ci'

]);


$capsule->setAsGlobal();


$capsule->bootEloquent();

require_once __DIR__ . '/../app/routes.php';


$app->add( new \Cart\Middleware\ValidationErrorsMiddleware( $container->get(Slim\Views\Twig::class)) );
$app->add( new \Cart\Middleware\OldInputMiddleware( $container->get(Slim\Views\Twig::class)) );

$app->add( new \Cart\Middleware\MessagesNotifyMiddleware( $container->get(Slim\Views\Twig::class)) );