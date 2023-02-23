<?php
error_reporting(E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';

use Meraki\Http\DiactorosRequestFactory;
use Meraki\Http\Example\RequestHandler\NoHandlersMatched;
use Meraki\Http\Example\Middleware\CatchExceptions;
use Meraki\Http\Example\Middleware\Router;
use Chubbyphp\StaticFile\StaticFileMiddleware;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\StreamFactory;
use Meraki\Http\Runtime;
use Meraki\Http\Application;

// The application is just one big middleware/request-handler
$app = Application::create(new NoHandlersMatched())
	->name('My HTTP Application')
	->add(new CatchExceptions())
	->add(new Router())
	->add(new StaticFileMiddleware(new ResponseFactory(), new StreamFactory(), __DIR__ . '/public'));

// Implement the `Meraki\Http\RequestFactory` interface
// to use your own PSR7-compatible request objects.
$requestFactory = new DiactorosRequestFactory();
$httpServer = new Meraki\Http\Server\FPM($requestFactory);

// run the application
$httpServer->run($app);

/*
	Visit these URLs to test application:

	- GET /				handled by router middleware
	- GET /about		handled by router middleware
	- GET /contact		handled by router middleware
	- POST /contact		handled by router middleware
	- GET /db			handled by uncaught exceptions middleware
	- GET /style.css	handled by static files middleware
	- GET /test			handled by default/fallback handler
*/
