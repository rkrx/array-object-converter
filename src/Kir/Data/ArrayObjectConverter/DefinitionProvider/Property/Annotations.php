<?php
namespace Kir\Data\ArrayObjectConverter\DefinitionProvider\Property;

interface Annotations {
	/**
	 * @param string $key
	 * @return bool
	 */
	public function has($key);

	/**
	 * @param string $key
	 * @return Annotation
	 */
	public function getFirst($key);

	/**
	 * @param string $key
	 * @return Annotation[]
	 */
	public function getAll($key);
} 