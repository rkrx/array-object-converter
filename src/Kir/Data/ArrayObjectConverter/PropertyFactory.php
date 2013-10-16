<?php
namespace Kir\Data\ArrayObjectConverter;

class PropertyFactory {
	/**
	 * @var object
	 */
	private $obj=null;

	/**
	 * @param object $obj
	 */
	public function __construct($obj) {
		$this->obj = $obj;
	}

	/**
	 * @return Property[]
	 */
	public function getAll() {
		$refObj = new \ReflectionClass($this->obj);
		$properties = array();
		foreach($refObj->getProperties() as $refProperty) {
			$properties[] = new Property($refProperty, $this->obj);
		}
		return $properties;
	}
} 