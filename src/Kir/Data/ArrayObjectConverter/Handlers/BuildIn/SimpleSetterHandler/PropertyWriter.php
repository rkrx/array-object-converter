<?php
namespace Kir\Data\ArrayObjectConverter\Handlers\BuildIn\SimpleSetterHandler;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;
use Kir\Data\ArrayObjectConverter\DefinitionProvider;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Handlers\BuildIn\SimpleHandler\PropertyAccessor;
use Kir\Data\ArrayObjectConverter\Reflection\ReflectionObject;
use Kir\Data\ArrayObjectConverter\Reflection\ReflectionProperty;

class PropertyWriter extends PropertyAccessor {
	/**
	 * @param ReflectionObject $object $object
	 * @param DefinitionProvider\Property $property
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue(ReflectionObject $object, Property $property, $value) {
		$refProperty = $object->getProperty($property->getName());
		if ($refProperty->isPublic()) {
			$refProperty->setValue($value);
		} else {
			$this->trySetValueThroughMethod($object, $property, $value);
		}
		return $this;
	}

	/**
	 * @param ReflectionObject $object $object
	 * @param DefinitionProvider\Property $property
	 * @param mixed $value
	 */
	private function trySetValueThroughMethod(ReflectionObject $object, Property $property, $value) {
		if ($property->annotations()->has('array-setBy')) {
			$methodName = $property->annotations()->getFirst('array-setBy');
			$this->setValueThroughMethod($object, $methodName, $value);
		} else {
			$refProperty = $object->getProperty($property->getName());
			$this->trySetValueThroughGuessedMethod($refProperty, $value);
		}
	}

	/**
	 * @param ReflectionObject $refObject
	 * @param string $methodName
	 * @param mixed $value
	 * @throws \Exception
	 */
	private function setValueThroughMethod(ReflectionObject $refObject, $methodName, $value) {
		if (!$refObject->hasMethod($methodName)) {
			throw new \Exception("Missing method {$methodName}");
		}
		$refObject->getMethod($methodName)->invokeArgs([$value]);
	}

	/**
	 * @param ReflectionProperty $refProperty
	 * @param string $value
	 * @throws Exception
	 */
	private function trySetValueThroughGuessedMethod(ReflectionProperty $refProperty, $value) {
		foreach ($this->getPossibleSetterMethodNames($refProperty) as $methodName) {
			$refObject = $refProperty->getObject();
			if ($refObject->hasMethod($methodName)) {
				$method = $refObject->getMethod($methodName);
				if (count($method->getParameters()) != 1) {
					continue;
				}
				$method->invokeArgs([$value]);
				return;
			}
		}
		throw new Exception("No suitable setter-method found for {$refProperty->getName()}");
	}

	/**
	 * @param ReflectionProperty $refProperty
	 * @return string[]
	 */
	private function getPossibleSetterMethodNames(ReflectionProperty $refProperty) {
		return array(
			"set" . $refProperty->getName(),
			"set" . $this->getCamelCaseMethodName($refProperty),
			"set_" . $refProperty->getName()
		);
	}
} 