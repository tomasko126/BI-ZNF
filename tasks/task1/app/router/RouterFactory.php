<?php

namespace App;

use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\StaticClass;

/**
 * Class RouterFactory
 * @package App
 */
class RouterFactory
{
	use StaticClass;

	/**
	 *
	 * @return IRouter
	 */
	public static function createRouter()
	{
		$router = new RouteList;
		$router[] = new Route('<action>[/<number1>[/<number2>]]', 'Calculator:default');
		return $router;
	}
}
