<?php
namespace Kir\Data\ArrayObjectConverter\DefinitionProviders;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;
use Kir\Data\ArrayObjectConverter\DefinitionProvider;
use Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider\PropertyFactory;

class PhpDocDefinitionProvider implements DefinitionProvider {
	/**
	 * @var object
	 */
	private $object = null;

	/**
	 * @var Property[]
	 */
	private $properties = [];

	/**
	 * @param object $object
	 */
	public function __construct($object) {
		$this->object = $object;
		$factory = new PropertyFactory($object);
		$this->properties = $factory->getAll();
	}

	/**
	 * @return DefinitionProvider\Property[]
	 */
	public function getProperties() {
		return $this->properties;
	}

	/**
	 * @return bool
	 */
	public function isCachable() {
		return true;
	}
} 