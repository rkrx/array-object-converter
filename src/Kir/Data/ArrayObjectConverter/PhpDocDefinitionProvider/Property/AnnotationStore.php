<?php
namespace Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\Property;

use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotation;
use Kir\Data\ArrayObjectConverter\DefinitionProvider\Property\Annotations;

/**
 */
class AnnotationStore implements Annotations {
	/**
	 * @var Annotation[]
	 */
	private $annotations = [];

	/**
	 * @param Annotation[] $annotations
	 */
	public function __construct(array $annotations) {
		foreach($annotations as $annotation) {
			$key = $annotation->getKey();
			if(!array_key_exists($key, $this->annotations)) {
				$this->annotations[$key] = [];
			}
			$this->annotations[$key][] = $annotation;
		}
	}

	/**
	 * @param string $key
	 * @return bool
	 */
	public function has($key) {
		return array_key_exists($key, $this->annotations);
	}

	/**
	 * @param string $key
	 * @throws Exception
	 * @return Annotation
	 */
	public function getFirst($key) {
		if($this->has($key)) {
			return $this->annotations[$key][0];
		}
		throw new Exception("Key not found: {$key}");
	}

	/**
	 * @param string $key
	 * @throws Exception
	 * @return Annotation[]
	 */
	public function getAll($key) {
		if($this->has($key)) {
			return $this->annotations[$key];
		}
		throw new Exception("Key not found: {$key}");
	}
}