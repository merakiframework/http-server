<?php
declare(strict_types=1);

namespace Meraki\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Meraki ships with its own request factory interface rather
 * than using the PSR17 one, the reason, PSR17 does not define
 * a way to marshall a request from PHP's super globals. Considering
 * every PSR17 compatible library ships with some kind of way
 * to marshall a server request from PHP's super globals, this
 * seems like an oversight from the FIG group...
 */
interface RequestFactory
{
	/**
	 * Marshall a request from PHP's super globals.
	 */
	public function createFromGlobals(): ServerRequestInterface;
}
