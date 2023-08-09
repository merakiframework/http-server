<?php

declare(strict_types=1);

namespace Meraki\Http\Server;

final class Config
{
	public array $protocols = ['h1' => [], 'h2' => []];
	public string $host = '0.0.0.0';
	public int $port = 443;
	// public Mode $mode = Mode::simple();
	public string $address = '0.0.0.0:443';
	public string $documentRoot = '';
	public bool $staticHandlerEnabled = true;
	public bool $reloadOnFileChange = false;

	public function __construct()
	{
	}

	public static function create(): self
	{
		return new self();
	}

	public function useVersion(int $version, array $options = []): self
	{
		$copy = clone $this;
		$copy->protocols["h$version"] = $options;

		return $copy;
	}

	public function setOptionsForVersion(int $version, array $options): self
	{
		$copy = clone $this;
		$copy->protocols["h$version"] = $options;

		return $copy;
	}

	public function withDocumentRoot(string $docRoot): self
	{
		$copy = clone $this;
		$copy->documentRoot = $docRoot;

		return $copy;
	}

	public function watchFiles(): self
	{
		$copy = clone $this;
		$copy->reloadOnFileChange = true;

		return $copy;
	}

	public function handleStaticfiles(): self
	{
		$copy = clone $this;
		$copy->staticHandlerEnabled = true;

		return $copy;
	}

	public function isUsingVersion(int $version): bool
	{
		return array_key_exists("h$version", $this->protocols);
	}

	public function getOptionsFor(int $version): array
	{
		if ($this->isUsingVersion($version)) {
			return $this->protocols["h$version"];
		}

		return [];
	}
}
