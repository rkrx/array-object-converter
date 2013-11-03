<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty;

use Kir\Data\ArrayObjectConverter\Specification\Property\Annotation;
use Kir\Data\ArrayObjectConverter\Specification\Property\Annotations;
use Kir\Data\ArrayObjectConverter\Specification\Property\NoSuchAnnotationException;

class PhpDocAnnotations implements Annotations {
	/**
	 * @var Annotation[][]
	 */
	private $annotations = [];

	/**
	 * @var Annotation[]
	 */
	private $annotationsBase = [];

	/**
	 * @param Annotation[] $annotations
	 */
	public function __construct(array $annotations) {
		$this->annotationsBase = $annotations;
		foreach($annotations as $annotation) {
			if(!array_key_exists($annotation->getName(), $this->annotations)) {
				$this->annotations[$annotation->getName()] = [];
			}
			$this->annotations[$annotation->getName()][] = $annotation;
		}
	}

	/**
	 * @return Annotation[]
	 */
	public function getAll() {
		return $this->annotationsBase;
	}

	/**
	 * @param string $name
	 * @return bool
	 */
	public function has($name) {
		return array_key_exists($name, $this->annotations);
	}

	/**
	 * @param string $name
	 * @throws NoSuchAnnotationException
	 * @return Annotation
	 */
	public function getFirst($name) {
		$annotations = $this->get($name);
		return $annotations[0];
	}

	/**
	 * @param string $name
	 * @throws NoSuchAnnotationException
	 * @return Annotation[]
	 */
	public function get($name) {
		if(!$this->has($name)) {
			throw new NoSuchAnnotationException($name);
		}
		return $this->annotations[$name];
	}
} 
