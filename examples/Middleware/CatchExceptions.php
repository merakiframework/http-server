<?php
declare(strict_types=1);

namespace Meraki\Http\Example\Middleware;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\TextResponse;
use Throwable;

final class CatchExceptions implements MiddlewareInterface
{
	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		try {
			return $handler->handle($request);
		} catch (Throwable $e) {
			// log...
			return new TextResponse('500 Internal Server Error: ' . $e->getMessage());
		}
	}
}
