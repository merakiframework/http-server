<?php
declare(strict_types=1);

namespace Meraki\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

final class Application implements RequestHandlerInterface, MiddlewareInterface
{
	public string $name = '';

	private SplQueue $middleware;

	public function __construct(private RequestHandlerInterface $notFoundHandler)
	{
		$this->middleware = new SplQueue();
	}

	public static function create(RequestHandlerInterface $notFoundHandler): self
	{
		return new self($notFoundHandler);
	}

	public function name(string $name): self
	{
		$copy = clone $this;
		$copy->name = $name;

		return $copy;
	}

	public function add(MiddlewareInterface $middleware): self
	{
		$copy = clone $this;

		$copy->middleware->enqueue($middleware);

		return $copy;
	}

	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		return $this->process($request, $this->notFoundHandler);
	}

	public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
	{
		return (new Next($this->middleware, $handler))->handle($request);
	}

	public function __clone(): void
	{
		$this->middleware = clone $this->middleware;
	}
}
