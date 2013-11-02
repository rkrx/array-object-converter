<?php
namespace Kir\Data\ArrayObjectConverter\Reflection;

class ReflectionProperty {
	/**
	 * @var ReflectionObject
	 */
	private $object = null;

	/**
	 * @var \ReflectionProperty
	 */
	private $property = null;

	/**
	 * @param ReflectionObject $object
	 * @param \ReflectionProperty $property
	 */
	public function __construct(ReflectionObject $object, \ReflectionProperty $property) {
		$this->object = $object;
		$this->property = $property;
	}

	/**
	 * @return ReflectionObject
	 */
	public function getObject() {
		return $this->object;
	}
	
	/**
	 * @return string
	 */
	public function getName() {
		return $this->property->getName();
	}

	/**
	 * @return string
	 */
	public function getDocComment() {
		return $this->property->getDocComment();
	}

	/**
	 * @return bool
	 */
	public function isPublic() {
		return $this->property->isPublic();
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->property->getValue($this->object->getObject());
	}

	/**
	 * @param mixed $value
	 * @return $this
	 */
	public function setValue($value) {
		$this->property->setValue($this->object->getObject(), $value);
		return $this;
	}
} 