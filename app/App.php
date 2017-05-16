<?php 

declare(strict_types=1);

namespace Cart;

use DI\ContainerBuilder;
use DI\Bridge\Slim\App as DiBridge;


/**
* @author  André Teles
*/
class App extends DiBridge
{
	
	protected function configureContainer(ContainerBuilder $builder): void
	{
		$builder->addDefinitions([
			'settings.displayErrorDetails' => true
		]);

		$builder->addDefinitions(__DIR__ .'/container.php');
	}
}