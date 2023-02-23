<?php
declare(strict_types=1);

namespace Meraki\Http;

use RuntimeException;

final class Version
{
	private const UPGRADE_PATHS = [
		'1.0' => '1.1',
		'1.1' => '2.0'
	];

	public function __construct(private int $major, private int $minor = 0)
	{
	}

	public function upgrade(): self
	{
		$current = (string) $this;

		if (array_key_exists($current, self::UPGRADE_PATHS)) {
			return self::fromDouble(self::UPGRADE_PATHS[$current]);
		}

		throw new RuntimeException(sprintf('Cannot find an upgrade path from HTTP Version %s.', $current));
	}

	public static function fromDouble(double $version): self
	{
		$version = (string) $version;
		list($major, $minor) = explode('.', $version);

		return new self($major, $minor);
	}

	public function __toString(): string
	{
		return sprintf('%i.%i', $this->major, $this->minor);
	}
}
