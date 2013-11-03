<?php
namespace Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject;

use Kir\Data\ArrayObjectConverter\Accessors\SimpleAccessor\Reflection\ReflObject;

class ReflProperty {
	/**
	 * @var ReflObject
	 */
	private $object = null;

	/**
	 * @var \ReflectionProperty
	 */
	private $property = null;

	/**
	 * @param ReflObject $object
	 * @param \ReflectionProperty $property
	 */
	public function __construct(ReflObject $object, \ReflectionProperty $property) {
		$this->object = $object;
		$this->property = $property;
	}

	/**
	 * @return ReflObject
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