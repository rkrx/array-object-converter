<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\SpecificationProviders\NoSuchProviderException;

interface SpecificationProviders {
	/**
	 * @param SpecificationProvider $provider
	 * @param string $name
	 * @return $this
	 */
	public function setProvider(SpecificationProvider $provider, $name);

	/**
	 * @param string $name
	 * @return SpecificationProvider
	 * @throws NoSuchProviderException
	 */
	public function getProvider($name);
} 