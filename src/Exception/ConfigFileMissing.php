<?php
declare(strict_types=1);

namespace Meraki\Http;

use Meraki\Http\Exception as HttpException;

final class ConfigFileMissing extends \RuntimeException implements HttpException
{
	public function __construct(string $configFile)
	{
		parent::__construct("Environment not configured correctly: the config file is missing at location '$configFile'.");
	}
}
