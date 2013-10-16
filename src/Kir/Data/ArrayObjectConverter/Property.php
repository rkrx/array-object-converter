<?php
namespace Kir\Data\ArrayObjectConverter;

class Property {
	/**
	 * @var \ReflectionProperty
	 */
	private $property=null;

	/**
	 * @var Annotations
	 */
	private $annotations=null;

	/**
	 * @param \ReflectionProperty $property
	 * @param object $object
	 */
	public function __construct(\ReflectionProperty $property, $object) {
		$this->property = $property;
		$this->object = $object;
		$parser = new PhpDocParser();
		$params = $parser->parse($this->property->getDocComment());
		$this->annotations = new Annotations($params);
	}

	/**
	 * @return Annotations
	 */
	public function annotations() {
		return $this->annotations;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		if($this->property->isPublic()) {
			return $this->property->getValue($this->object);
		}
		return $this->tryGetValueFromMethod();
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue($value) {
		if($this->property->isPublic()) {
			$this->property->setValue($this->object, $value);
		} else {
			$this->trySetValueThroughMethod($value);
		}
		return $this;
	}

	/**
	 * @return mixed
	 * @throws Exception
	 */
	private function tryGetValueFromMethod() {
		foreach($this->getPossibleGetterMethodNames() as $methodName) {
			$refClass = new \ReflectionClass($this->object);
			if($refClass->hasMethod($methodName)) {
				$method = $refClass->getMethod($methodName);
				if(count($method->getParameters()) > 0) {
					continue;
				}
				return $method->invoke($this->object);
			}
		}
		throw new Exception("No suitable getter-method found for {$this->property->getName()}");
	}

	/**
	 * @param mixed $value
	 * @throws \Exception
	 */
	private function trySetValueThroughMethod($value) {
		if($this->annotations()->has('aoc-data-setBy')) {
			$setByMethod = $this->annotations()->getFirst('aoc-data-setBy');
			$refClass = new \ReflectionClass($this->object);
			if($refClass->hasMethod($setByMethod)) {
				$refMethod = $refClass->getMethod($setByMethod);
				$refMethod->invoke($this->object, $value);
			} else {
				throw new \Exception("Missing method {$setByMethod}");
			}
		} else {
			$this->trySetValueThroughGuessedMethod($value);
		}
	}

	/**
	 * @param string $value
	 * @throws Exception
	 */
	private function trySetValueThroughGuessedMethod($value) {
		foreach($this->getPossibleSetterMethodNames() as $methodName) {
			$refClass = new \ReflectionClass($this->object);
			if($refClass->hasMethod($methodName)) {
				$method = $refClass->getMethod($methodName);
				if(count($method->getParameters()) != 1) {
					continue;
				}
				$method->invoke($this->object, $value);
				return;
			}
		}
		throw new Exception("No suitable setter-method found for {$this->property->getName()}");
	}

	/**
	 * @return string[]
	 */
	private function getPossibleGetterMethodNames() {
		return array(
			"get" . $this->property->getName(),
			"get" . $this->getCamelCaseMethodName(),
			"get_" . $this->property->getName()
		);
	}

	/**
	 * @return string[]
	 */
	private function getPossibleSetterMethodNames() {
		return array(
			"set" . $this->property->getName(),
			"set" . $this->getCamelCaseMethodName(),
			"set_" . $this->property->getName()
		);
	}

	/**
	 * @return string
	 */
	private function getCamelCaseMethodName() {
		$methodName = $this->property->getName();
		$lowerCamelCaseMethodName = preg_replace_callback('/(_[A-Za-z])/', function ($matches) {
			$token = $matches[1];
			$token = ltrim($token, '_');
			$token = strtoupper($token);
			return $token;
		}, $methodName);
		$lowerCamelCaseMethodName = ucfirst($lowerCamelCaseMethodName);
		return $lowerCamelCaseMethodName;
	}
}