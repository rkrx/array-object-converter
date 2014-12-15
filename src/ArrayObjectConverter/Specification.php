<?php
namespace Kir\Data\ArrayObjectConverter;

interface Specification {
	/**
	 * @return Specification\Property[]
	 */
	public function getProperties();

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasProperty($name);

	/**
	 * @param string $name
	 * @return Specification\Property
	 */
	public function getProperty($name);
	
	/**
	 * @return Specification\Method[]
	 */
	public function getMethods();

	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasMethod($name);

	/**
	 * @param string $name
	 * @return Specification\Method
	 */
	public function getMethod($name);
} 