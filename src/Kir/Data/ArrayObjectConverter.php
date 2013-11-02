<?php
namespace Kir\Data;

use Kir\Data\ArrayObjectConverter\GetterHandler;
use Kir\Data\ArrayObjectConverter\SetterHandler;
use Kir\Data\ArrayObjectConverter\DefinitionProvider;
use Kir\Data\ArrayObjectConverter\DefinitionProviders\PhpDocDefinitionProvider;
use Kir\Data\ArrayObjectConverter\GetterHandlers\SimpleGetterHandler;
use Kir\Data\ArrayObjectConverter\SetterHandlers\SimpleSetterHandler;

class ArrayObjectConverter {
	/**
	 * @var object
	 */
	private $object;

	/**
	 * @var DefinitionProvider
	 */
	private $definitionProvider=null;

	/**
	 * @var GetterHandler
	 */
	private $getterHandler=null;

	/**
	 * @var SetterHandler
	 */
	private $setterHandler=null;

	/**
	 * @param object $object
	 * @param DefinitionProvider $definitionProvider
	 * @param GetterHandler $getterHandler
	 * @param SetterHandler $setterHandler
	 */
	public function __construct($object, DefinitionProvider $definitionProvider = null, GetterHandler $getterHandler = null, SetterHandler $setterHandler = null) {
		$this->object = $object;
		if ($definitionProvider === null) {
			$definitionProvider = new PhpDocDefinitionProvider($object);
		}
		if($getterHandler === null) {
			$getterHandler = new SimpleGetterHandler($object, $definitionProvider, new ArrayObjectConverter\Filters());
		}
		if($setterHandler === null) {
			$setterHandler = new SimpleSetterHandler($object, $definitionProvider, new ArrayObjectConverter\Filters());
		}
		$this->definitionProvider = $definitionProvider;
		$this->getterHandler = $getterHandler;
		$this->setterHandler = $setterHandler;
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function setArray(array $data) {
		$this->setterHandler->setArray($data);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getArray() {
		return $this->getterHandler->getArray();
	}

	/**
	 * @return GetterHandler
	 */
	public function getterHandler() {
		return $this->getterHandler;
	}

	/**
	 * @return SetterHandler
	 */
	public function setterHandler() {
		return $this->setterHandler;
	}
}