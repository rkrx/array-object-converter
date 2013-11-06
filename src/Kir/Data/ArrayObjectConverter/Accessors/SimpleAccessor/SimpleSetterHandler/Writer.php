<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleSetterHandler;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject\ReflProperty;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler\SimpleAccessor;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Specification\Property;

class Writer extends SimpleAccessor {
	/**
	 * @param ReflObject $object $object
	 * @param Property $property
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue(ReflObject $object, Property $property, $value) {
		$refProperty = $object->getProperty($property->getName());
		if ($refProperty->isPublic()) {
			$refProperty->setValue($value);
		} else {
			$this->trySetValueThroughMethod($object, $property, $value);
		}
		return $this;
	}

	/**
	 * @param ReflObject $object $object
	 * @param Property $property
	 * @param mixed $value
	 */
	private function trySetValueThroughMethod(ReflObject $object, Property $property, $value) {
		if ($property->annotations()->has('set-by')) {
			$methodName = $property->annotations()->getFirst('set-by')->getValue();
			$this->setValueThroughMethod($object, $methodName, $value);
		} else {
			$refProperty = $object->getProperty($property->getName());
			$this->trySetValueThroughGuessedMethod($refProperty, $value);
		}
	}

	/**
	 * @param ReflObject $refObject
	 * @param string $methodName
	 * @param mixed $value
	 * @throws \Exception
	 */
	private function setValueThroughMethod(ReflObject $refObject, $methodName, $value) {
		if (!$refObject->hasMethod($methodName)) {
			throw new \Exception("Missing method {$methodName}");
		}
		$refObject->getMethod($methodName)->invokeArgs([$value]);
	}

	/**
	 * @param ReflProperty $property
	 * @param string $value
	 * @throws Exception
	 */
	private function trySetValueThroughGuessedMethod(ReflProperty $property, $value) {
		foreach ($this->getPossibleSetterMethodNames($property) as $methodName) {
			$refObject = $property->getObject();
			if ($refObject->hasMethod($methodName)) {
				$method = $refObject->getMethod($methodName);
				if (count($method->getParameters()) != 1) {
					continue;
				}
				$method->invokeArgs([$value]);
				return;
			}
		}
		throw new Exception("No suitable setter-method found for {$property->getName()}");
	}

	/**
	 * @param ReflProperty $refProperty
	 * @return string[]
	 */
	private function getPossibleSetterMethodNames(ReflProperty $refProperty) {
		return array(
			"set" . $refProperty->getName(),
			"set" . $this->getCamelCaseMethodName($refProperty),
			"set_" . $refProperty->getName()
		);
	}
} 