<?php
declare(strict_types=1);

namespace Meraki\Http;

use Meraki\Http\Exception as HttpException;

final class DirectoryDoesntExist extends \RuntimeException implements HttpException
{
	public function __construct(string $directory)
	{
		parent::__construct("Environment not configured correctly: the directory '$directory' does not exist.");
	}
}
