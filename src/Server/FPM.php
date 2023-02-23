<?php
declare(strict_types=1);

namespace Meraki\Http\Server;

use Meraki\Http\RequestFactory;
use Meraki\Http\Server;
use Meraki\Http\Application;
use Narrowspark\HttpEmitter\SapiEmitter;

final class FPM extends Server
{
	public function __construct(private RequestFactory $requestFactory)
	{

	}

	public function run(Application $app): void
	{
		parent::run($app);

		$request = $this->requestFactory->createFromGlobals();
		$emitter = new SapiEmitter();

		$emitter->emit($app->handle($request));
	}
}
