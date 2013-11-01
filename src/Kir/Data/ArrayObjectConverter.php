<?php
namespace Kir\Data;

use Kir\Data\ArrayObjectConverter\DefinitionProvider;
use Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider;

class ArrayObjectConverter {
	/**
	 * @var object
	 */
	private $object;

	/**
	 * @var DefinitionProvider
	 */
	private $definitionProvider;

	/**
	 * @var ArrayObjectConverter\Filters
	 */
	private $setterFilters = array();

	/**
	 * @var ArrayObjectConverter\Filters
	 */
	private $getterFilters = array();

	/**
	 * @param object $object
	 * @param DefinitionProvider $definitionProvider
	 */
	public function __construct($object, DefinitionProvider $definitionProvider=null) {
		$this->object = $object;
		if($definitionProvider === null) {
			$definitionProvider = new PhpDocDefinitionProvider($object);
		}
		$this->definitionProvider = $definitionProvider;
		$this->setterFilters = new ArrayObjectConverter\Filters();
		$this->getterFilters = new ArrayObjectConverter\Filters();
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function setArray(array $data) {
		$setter = new ArrayObjectConverter\SetterHandler($this->object, $this->definitionProvider, $this->setterFilters);
		$setter->set($data);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getArray() {
		$getter = new ArrayObjectConverter\GetterHandler($this->object, $this->definitionProvider, $this->getterFilters);
		return $getter->get();
	}

	/**
	 * @return ArrayObjectConverter\Filters
	 */
	public function setterFilters() {
		return $this->setterFilters;
	}

	/**
	 * @return ArrayObjectConverter\Filters
	 */
	public function getterFilters() {
		return $this->getterFilters;
	}
}