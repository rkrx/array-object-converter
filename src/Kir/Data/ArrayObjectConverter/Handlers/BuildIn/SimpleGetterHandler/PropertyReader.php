<?php
namespace Kir\Data\ArrayObjectConverter\Handlers\BuildIn\SimpleGetterHandler;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Handlers\BuildIn\SimpleHandler\PropertyAccessor;
use Kir\Data\ArrayObjectConverter\Reflection\ReflectionObject;
use Kir\Data\ArrayObjectConverter\Reflection\ReflectionProperty;

class PropertyReader extends PropertyAccessor {
	/**
	 * @param ReflectionObject $object
	 * @param Property $property
	 * @return mixed
	 */
	public function getValue(ReflectionObject $object, Property $property) {
		$refProperty = $object->getProperty($property->getName());
		if ($refProperty->isPublic()) {
			$value = $refProperty->getValue();
			return $value;
		}
		if ($property->annotations()->has('array-getBy')) {
			$methodName = $property->annotations()->getFirst('array-getBy');
			return $this->getValueFromMethod($object, $methodName);
		}
		return $this->tryGetValueFromGuessedMethod($refProperty);
	}

	/**
	 * @param ReflectionObject $object
	 * @param string $methodName
	 * @throws \Exception
	 * @return mixed
	 */
	private function getValueFromMethod(ReflectionObject $object, $methodName) {
		if (!$object->hasMethod($methodName)) {
			throw new \Exception("Missing method {$methodName}");
		}
		return $object->getMethod($methodName)->invoke();
	}

	/**
	 * @param ReflectionProperty $property
	 * @throws \Kir\Data\ArrayObjectConverter\Exception
	 * @return mixed
	 */
	private function tryGetValueFromGuessedMethod(ReflectionProperty $property) {
		foreach ($this->getPossibleGetterMethodNames($property) as $methodName) {
			if ($property->getObject()->hasMethod($methodName)) {
				$method = $property->getObject()->getMethod($methodName);
				if (count($method->getParameters()) > 0) {
					continue;
				}
				return $method->invoke();
			}
		}
		throw new Exception("No suitable getter-method found for {$property->getName()}");
	}

	/**
	 * @param ReflectionProperty $refProperty
	 * @return string[]
	 */
	private function getPossibleGetterMethodNames(ReflectionProperty $refProperty) {
		return array(
			"get" . $this->getCamelCaseMethodName($refProperty),
			"get" . $refProperty->getName(),
			"get_" . $refProperty->getName()
		);
	}
} 