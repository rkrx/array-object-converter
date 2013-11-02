<?php
namespace Kir\Data\ArrayObjectConverter\Handlers\SimpleSetterHandler;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;
use Kir\Data\ArrayObjectConverter\DefinitionProvider;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Handlers\SimpleHandler\PropertyAccessor;

class PropertyWriter extends PropertyAccessor {
	/**
	 * @param object $object
	 * @param DefinitionProvider\Property $property
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue($object, Property $property, $value) {
		$refClass = new \ReflectionClass($object);
		$refProperty = $refClass->getProperty($property->getName());
		if ($refProperty->isPublic()) {
			$refProperty->setValue($object, $value);
		} else {
			$this->trySetValueThroughMethod($refClass, $object, $property, $value);
		}
		return $this;
	}

	/**
	 * @param \ReflectionClass $refClass
	 * @param object $object
	 * @param DefinitionProvider\Property $property
	 * @param mixed $value
	 * @throws \Exception
	 */
	private function trySetValueThroughMethod(\ReflectionClass $refClass, $object, Property $property, $value) {
		if ($property->annotations()->has('array-setBy')) {
			$methodName = $property->annotations()->getFirst('array-setBy');
			$this->setValueThroughMethod($refClass, $object, $methodName, $value);
		} else {
			$refProperty = $refClass->getProperty($property->getName());
			$this->trySetValueThroughGuessedMethod($object, $refProperty, $value);
		}
	}

	/**
	 * @param \ReflectionClass $refClass
	 * @param object $object
	 * @param string $methodName
	 * @param mixed $value
	 * @throws \Exception
	 */
	private function setValueThroughMethod(\ReflectionClass $refClass, $object, $methodName, $value) {
		if (!$refClass->hasMethod($methodName)) {
			throw new \Exception("Missing method {$methodName}");
		}
		$refClass->getMethod($methodName)->invokeArgs($object, [$value]);
	}

	/**
	 * @param object $object
	 * @param \ReflectionProperty $refProperty
	 * @param string $value
	 * @throws Exception
	 */
	private function trySetValueThroughGuessedMethod($object, \ReflectionProperty $refProperty, $value) {
		foreach ($this->getPossibleSetterMethodNames($refProperty) as $methodName) {
			$refClass = new \ReflectionClass($object);
			if ($refClass->hasMethod($methodName)) {
				$method = $refClass->getMethod($methodName);
				if (count($method->getParameters()) != 1) {
					continue;
				}
				$method->invoke($object, $value);
				return;
			}
		}
		throw new Exception("No suitable setter-method found for {$refProperty->getName()}");
	}

	/**
	 * @param \ReflectionProperty $refProperty
	 * @return string[]
	 */
	private function getPossibleSetterMethodNames(\ReflectionProperty $refProperty) {
		return array(
			"set" . $refProperty->getName(),
			"set" . $this->getCamelCaseMethodName($refProperty),
			"set_" . $refProperty->getName()
		);
	}
} 