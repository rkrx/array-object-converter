<?php
namespace Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\PhpDocParser;

use Kir\Data\ArrayObjectConverter\Exception;
use Kir\Data\ArrayObjectConverter\PhpDocDefinitionProvider\PhpDocParser\ParserAnnotation;

class ParserAnnotations {
	/**
	 * @var ParserAnnotation[]
	 */
	private $annotations = array();

	/**
	 * @param ParserAnnotation[] $annotations
	 */
	public function __construct(array $annotations) {
		foreach ($annotations as $annotation) {
			$key = $annotation->getKey();
			if (!array_key_exists($key, $this->annotations)) {
				$this->annotations[$key] = [];
			}
			$this->annotations[$key][] = $annotation;
		}
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
	 * @return ParserAnnotation
	 */
	public function getFirst($name) {
		if ($this->has($name)) {
			$annotations = $this->get($name);
			$firstAnnotation = array_shift($annotations);
			return $firstAnnotation;
		}
		return null;
	}

	/**
	 * @param string $name
	 * @throws Exception
	 * @return ParserAnnotation[]
	 */
	public function get($name) {
		if ($this->has($name)) {
			$annotations = $this->annotations[$name];
			if (!is_array($annotations)) {
				throw new Exception("Invalid annotation");
			}
			return $annotations;
		}
		return array();
	}

	/**
	 * @return array
	 */
	public function getAll() {
		return $this->annotations;
	}
} 