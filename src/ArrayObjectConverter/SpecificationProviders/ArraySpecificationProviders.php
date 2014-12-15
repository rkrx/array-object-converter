<?php
namespace Kir\Data\ArrayObjectConverter\SpecificationProviders;

use Kir\Data\ArrayObjectConverter\SpecificationProvider;
use Kir\Data\ArrayObjectConverter\SpecificationProviders;

class ArraySpecificationProviders implements SpecificationProviders {
	/**
	 * @var SpecificationProvider[]
	 */
	private $providers = [];

	/**
	 * @param SpecificationProvider $provider
	 * @param string $name
	 * @return $this
	 */
	public function setProvider(SpecificationProvider $provider, $name = null) {
		$this->providers[(string)$name] = $provider;
		return $this;
	}

	/**
	 * @param string $name
	 * @return SpecificationProvider
	 * @throws NoSuchProviderException
	 */
	public function getProvider($name = null) {
		$name = (string)$name;
		if (array_key_exists($name, $this->providers)) {
			return $this->providers[$name];
		}
		throw new NoSuchProviderException($name);
	}
} 