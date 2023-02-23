<?php

declare(strict_types=1);

namespace Meraki\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use SplQueue;

/**
 * Iterate a queue of middlewares and execute them.
 * "Inspired" by Laminas-Stratigility component.
 */
final class Next implements RequestHandlerInterface
{
	// private RequestHandlerInterface $fallbackHandler;

	// private ?SplQueue $queue;

	/**
	 * Clones the queue provided to allow re-use.
	 */
	public function __construct(
		private ?SplQueue $queue,
		private RequestHandlerInterface $fallbackHandler)
	{
		$this->queue = clone $queue;
		$this->fallbackHandler = $fallbackHandler;
	}

	public function handle(ServerRequestInterface $request): ResponseInterface
	{
		if ($this->queue === null) {
			throw new \RuntimeException('middleware exhausted');
			//throw MiddlewarePipeNextHandlerAlreadyCalledException::create();
		}

		if ($this->queue->isEmpty()) {
			$this->queue = null;
			return $this->fallbackHandler->handle($request);
		}

		$middleware = $this->queue->dequeue();
		$next = clone $this; // deep clone is not used intentionally
		$this->queue = null; // mark queue as processed at this nesting level

		return $middleware->process($request, $next);
	}
}
