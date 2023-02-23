<?php
declare(strict_types=1);

namespace Meraki\Http\Example\RequestHandler;

use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Laminas\Diactoros\Response\TextResponse;

final class NoHandlersMatched implements RequestHandlerInterface
{
	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		return new TextResponse('404 Page Not Found');
	}
}
