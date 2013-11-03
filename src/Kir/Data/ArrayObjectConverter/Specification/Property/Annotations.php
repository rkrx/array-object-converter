<?php
namespace Kir\Data\ArrayObjectConverter\Specification\Property;

interface Annotations {
	/**
	 * @return Annotation[]
	 */
	public function getAll();

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name);

	/**
	 * @param string $name
	 * @throws NoSuchAnnotationException
	 * @return Annotation
	 */
	public function getFirst($name);	

	/**
	 * @param string $name
	 * @throws NoSuchAnnotationException
	 * @return Annotation[]
	 */
	public function get($name);	
} 