<?php
declare(strict_types=1);

namespace Meraki\Http\Example\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\TextResponse;

final class Router implements MiddlewareInterface
{
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		// 'default' cases are required in match statements
		// this is an example though, so code duplication is fine
		return match (strtolower($request->getMethod())) {
			'get' => match ($request->getRequestTarget()) {
					'/' => new TextResponse('Home page'),
					'/about' => new TextResponse('About page'),
					'/contact' => new TextResponse('Contact form page'),
					'/db' => throw new \RuntimeException('Could not connect to database.'),
					default => $handler->handle($request)
				},

			'post' => match ($request->getRequestTarget()) {
					'/contact' => new TextResponse('Contact form sent'),
					default => $handler->handle($request)
				},

			default => $handler->handle($request)
		};
	}
}
