<?php
declare(strict_types=1);

namespace Meraki\Http;

/**
 * The server is responsible for running the application
 * by executing it in a given runtime.
 */
abstract class Server
{
	public bool $started = false;

	public function start(): void
	{
		$this->started = true;
	}

	public function stop(): void
	{
		$this->started = false;
	}

	public function run(Application $app): void
	{
		if (!$this->started) {
			$this->start();
		}
	}
}
