<?php
namespace Kir\Data\ArrayObjectConverter;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;

class PropertyReader extends PropertyAccessor {
	/**
	 * @param object $object
	 * @param Property $property
	 * @return mixed
	 */
	public function getValue($object, Property $property) {
		$refClass = new \ReflectionClass($object);
		$refProperty = $refClass->getProperty($property->getName());
		if ($refProperty->isPublic()) {
			return $refProperty->getValue($object);
		}
		if ($property->annotations()->has('array-getBy')) {
			$methodName = $property->annotations()->getFirst('array-getBy');
			return $this->getValueFromMethod($refClass, $object, $methodName);
		}
		return $this->tryGetValueFromGuessedMethod($object, $refProperty);
	}

	/**
	 * @param \ReflectionClass $refClass
	 * @param object $object
	 * @param string $methodName
	 * @throws \Exception
	 * @return mixed
	 */
	private function getValueFromMethod(\ReflectionClass $refClass, $object, $methodName) {
		if (!$refClass->hasMethod($methodName)) {
			throw new \Exception("Missing method {$methodName}");
		}
		return $refClass->getMethod($methodName)->invoke($object);
	}

	/**
	 * @param object $object
	 * @param \ReflectionProperty $property
	 * @throws Exception
	 * @return mixed
	 */
	private function tryGetValueFromGuessedMethod($object, \ReflectionProperty $property) {
		foreach ($this->getPossibleGetterMethodNames($property) as $methodName) {
			$refClass = new \ReflectionClass($object);
			if ($refClass->hasMethod($methodName)) {
				$method = $refClass->getMethod($methodName);
				if (count($method->getParameters()) > 0) {
					continue;
				}
				return $method->invoke($object);
			}
		}
		throw new Exception("No suitable getter-method found for {$property->getName()}");
	}

	/**
	 * @param \ReflectionProperty $refProperty
	 * @return string[]
	 */
	private function getPossibleGetterMethodNames(\ReflectionProperty $refProperty) {
		return array(
			"get" . $refProperty->getName(),
			"get" . $this->getCamelCaseMethodName($refProperty),
			"get_" . $refProperty->getName()
		);
	}
} 