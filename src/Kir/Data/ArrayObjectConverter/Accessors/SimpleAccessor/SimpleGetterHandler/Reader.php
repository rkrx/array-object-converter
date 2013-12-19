<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleGetterHandler;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject;
use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\SimpleHandler\SimpleAccessor;
use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\Specification\Property;

class Reader extends SimpleAccessor {
	/**
	 * @param ReflObject $object
	 * @param Property $property
	 * @return mixed
	 */
	public function getValue(ReflObject $object, Property $property) {
		$refProperty = $object->getProperty($property->getName());
		if ($refProperty->isPublic()) {
			$value = $refProperty->getValue();
			return $value;
		} elseif($property->annotations()->has('force-access')) {
			return $this->forceGetValueFromProperty($object, $property);
		} elseif ($property->annotations()->has('get-by')) {
			return $this->getValueFromMethod($object, $property);
		}
		return $this->tryGetValueFromGuessedMethod($refProperty);
	}

	/**
	 * @param ReflObject $object
	 * @param Property $property
	 * @throws \Exception
	 * @return mixed
	 */
	private function getValueFromMethod(ReflObject $object, Property $property) {
		$methodName = $property->annotations()->getFirst('get-by')->getValue();
		if (!$object->hasMethod($methodName)) {
			throw new \Exception("Missing method {$methodName}");
		}
		return $object->getMethod($methodName)->invoke();
	}

	/**
	 * @param ReflObject\ReflProperty $property
	 * @throws \Kir\Data\ArrayObjectConverter\Exception
	 * @return mixed
	 */
	private function tryGetValueFromGuessedMethod(ReflObject\ReflProperty $property) {
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
	 * @param ReflObject\ReflProperty $property
	 * @return string[]
	 */
	private function getPossibleGetterMethodNames(ReflObject\ReflProperty $property) {
		return array(
			"get" . $this->getCamelCaseMethodName($property),
			"get" . $property->getName(),
			"get_" . $property->getName()
		);
	}

	/**
	 * @param ReflObject $object
	 * @param Property $property
	 * @return mixed
	 */
	private function forceGetValueFromProperty(ReflObject $object, Property $property) {
		$propertyName = $property->getName();
		$reflProperty = $object->getProperty($propertyName);
		return $reflProperty->forceGetValue();
	}
} 