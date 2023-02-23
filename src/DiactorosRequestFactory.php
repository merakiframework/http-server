<?php
declare(strict_types=1);

namespace Meraki\Http;

use Laminas\Diactoros\ServerRequestFactory;
use Psr\Http\Message\ServerRequestInterface;

final class DiactorosRequestFactory implements RequestFactory
{
	public function createFromGlobals(): ServerRequestInterface
	{
		return ServerRequestFactory::fromGlobals();
	}
}
