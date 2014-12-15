<?php
namespace Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification;

use Kir\Data\ArrayObjectConverter\Specification\Property;
use Kir\Data\ArrayObjectConverter\Specification\Property\Annotations;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocAnnotation;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocAnnotations;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocParser\AnnotationParser;
use Kir\Data\ArrayObjectConverter\Specificators\PhpDocSpecificationProvider\PhpDocSpecification\PhpDocProperty\PhpDocParser\PhpDocAnnotation\PhpDocParameter;

class PhpDocProperty implements Property {
	/**
	 * @var string
	 */
	private $name = null;

	/**
	 * @var string
	 */
	private $type = null;

	/**
	 * @var PhpDocProperty\PhpDocAnnotation[]
	 */
	private $annotations = [];

	/**
	 * @param \ReflectionProperty $refProperty
	 */
	public function __construct(\ReflectionProperty $refProperty) {
		$this->name = $refProperty->getName();
		$doc = $refProperty->getDocComment();
		$this->type = $this->findType($doc);
		$annotations = $this->findAnnotations($doc);
		$this->annotations = new PhpDocAnnotations($annotations);
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return Annotations
	 */
	public function annotations() {
		return $this->annotations;
	}

	/**
	 * @param string $doc
	 * @return string
	 */
	private function findType($doc) {
		if (strpos($doc, '@var') !== false) {
			$matches = [];
			if (preg_match('/^\\s*\\*\\s+@var\\s+([\\w\\\\]+)/im', $doc, $matches)) {
				return trim($matches[1]);
			}
		}
		return 'mixed';
	}

	/**
	 * @param string $doc
	 * @return PhpDocAnnotation[]
	 */
	private function findAnnotations($doc) {
		$result = [];
		if (!strpos($doc, '@aoc-') !== false) {
			return $result;
		}
		$parser = new AnnotationParser();
		$lines = explode("\n", $doc);
		foreach($lines as $line) {
			$line = trim($line);
			if(strpos($line, '@aoc-') !== false) {
				$result = $this->parseDefinition($line, $parser, $result);
			}
		}
		return $result;
	}

	/**
	 * @param string $line
	 * @param AnnotationParser $parser
	 * @param array $result
	 * @return array
	 */
	private function parseDefinition($line, $parser, $result) {
		$matches = [];
		if (preg_match('/^\\s*\\*\\s+@aoc-([\\w\\-]+.*)$/', $line, $matches)) {
			$definition = $matches[1];
			$definition = $parser->parseDefinition($definition);
			if ($definition['name']) {
				$parameters = $this->initializeParameters($definition);
				$result[] = new PhpDocAnnotation($definition['name'], $definition['value'], $parameters);
			}
		}
		return $result;
	}

	/**
	 * @param array $definition
	 * @return array
	 */
	private function initializeParameters($definition) {
		$parameters = [];
		foreach ($definition['params'] as $key => $value) {
			$parameters[] = new PhpDocParameter($key, $value);
		}
		return $parameters;
	}
} 